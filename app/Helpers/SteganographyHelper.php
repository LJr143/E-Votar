<?php
namespace App\Helpers;

use Exception;

class SteganographyHelper
{
    private const VERSION = 1;
    private const DELIMITER = '|END|';
    private const HEADER_FORMAT = 'Cversion/CversionCheck/Nlength/Nchecksum';
    private const HEADER_SIZE = 10; // 1+1+4+4 bytes

    /**
     * Encode data into an image
     */
    public static function encode(string $imagePath, string $data, string $outputPath): string
    {
        $image = null;
        try {
            // Validate input
            if (!file_exists($imagePath)) {
                throw new Exception("Source image not found at: $imagePath");
            }

            // Load and prepare image
            $image = self::loadImage($imagePath);
            $width = imagesx($image);
            $height = imagesy($image);

            // Prepare binary payload with 3 copies of data for redundancy
            $binaryData = self::prepareDataForEncoding($data);
            $requiredPixels = ceil(strlen($binaryData) / 3); // 3 bits per pixel (RGB)

            if ($requiredPixels > $width * $height) {
                throw new Exception("Image too small. Needs {$requiredPixels} pixels but has " . ($width * $height));
            }

            // Encode data
            $dataIndex = 0;
            for ($y = 0; $y < $height; $y++) {
                for ($x = 0; $x < $width; $x++) {
                    if ($dataIndex >= strlen($binaryData)) break 2;

                    $color = imagecolorat($image, $x, $y);
                    $r = ($color >> 16) & 0xFF;
                    $g = ($color >> 8) & 0xFF;
                    $b = $color & 0xFF;

                    // Encode in RGB channels
                    if ($dataIndex < strlen($binaryData)) $r = ($r & ~1) | $binaryData[$dataIndex++];
                    if ($dataIndex < strlen($binaryData)) $g = ($g & ~1) | $binaryData[$dataIndex++];
                    if ($dataIndex < strlen($binaryData)) $b = ($b & ~1) | $binaryData[$dataIndex++];

                    $newColor = self::safeColorAllocate($image, $r, $g, $b);
                    imagesetpixel($image, $x, $y, $newColor);
                }
            }

            // Save image with maximum quality
            if (!imagepng($image, $outputPath, 9)) {
                throw new Exception("Failed to save image to: $outputPath");
            }

            return $outputPath;
        } finally {
            if ($image) imagedestroy($image);
        }
    }

    /**
     * Decode data from an image with redundancy checking
     */
    public static function decode(string $imagePath): string
    {
        $image = null;
        try {
            $image = self::loadImage($imagePath);
            $binaryData = self::extractBinaryData($image);

            // Try decoding with multiple redundancy checks
            for ($attempt = 0; $attempt < 3; $attempt++) {
                try {
                    return self::validateAndDecodeData($binaryData);
                } catch (Exception $e) {
                    // On last attempt, rethrow the exception
                    if ($attempt === 2) throw $e;

                    // Try recovering by shifting bits
                    $binaryData = substr($binaryData, 1) . '0';
                }
            }

            throw new Exception("All decoding attempts failed");
        } finally {
            if ($image) imagedestroy($image);
        }
    }

    private static function prepareDataForEncoding(string $data): string
    {
        // Add version, length, checksum and triple redundancy
        $checksum = crc32($data);
        $header = pack(
            'CCNN', // Version (C), VersionCheck (C), Length (N), Checksum (N)
            self::VERSION,
            self::VERSION,
            strlen($data),
            $checksum
        );

        // Encode 3 copies of the data for redundancy
        $payload = $header . str_repeat($data, 3) . self::DELIMITER;

        // Convert to binary string
        $binary = '';
        for ($i = 0; $i < strlen($payload); $i++) {
            $binary .= str_pad(decbin(ord($payload[$i])), 8, '0', STR_PAD_LEFT);
        }
        return $binary;
    }

    private static function validateAndDecodeData(string $binaryData): string
    {
        // Convert binary to string
        $data = '';
        for ($i = 0; $i < strlen($binaryData); $i += 8) {
            $byte = substr($binaryData, $i, 8);
            if (strlen($byte) < 8) break;
            $data .= chr(bindec($byte));
        }

        // Find all possible delimiters in the data
        $delimiterPositions = [];
        $offset = 0;
        while (($pos = strpos($data, self::DELIMITER, $offset)) !== false) {
            $delimiterPositions[] = $pos;
            $offset = $pos + 1;
        }

        if (empty($delimiterPositions)) {
            throw new Exception("Delimiter not found in extracted data");
        }

        // Try each potential delimiter position
        foreach ($delimiterPositions as $pos) {
            try {
                $potentialData = substr($data, 0, $pos);

                // Verify header
                if (strlen($potentialData) < self::HEADER_SIZE) continue;

                $header = substr($potentialData, 0, self::HEADER_SIZE);
                $unpacked = @unpack('Cversion/CversionCheck/Nlength/Nchecksum', $header);

                if (!is_array($unpacked) || count($unpacked) !== 4) continue;
                if ($unpacked['version'] !== self::VERSION || $unpacked['versionCheck'] !== self::VERSION) continue;

                // Verify checksum against all 3 copies
                $payloadLength = $unpacked['length'];
                $expectedChecksum = $unpacked['checksum'];

                // Check all 3 copies of the data
                $validCopies = 0;
                for ($i = 0; $i < 3; $i++) {
                    $offset = self::HEADER_SIZE + ($i * $payloadLength);
                    $copy = substr($potentialData, $offset, $payloadLength);

                    if (crc32($copy) === $expectedChecksum) {
                        $validCopies++;
                    }
                }

                // Require at least 2 matching copies
                if ($validCopies >= 2) {
                    return substr($potentialData, self::HEADER_SIZE, $payloadLength);
                }
            } catch (Exception $e) {
                continue;
            }
        }

        throw new Exception("No valid data found matching all verification checks");
    }

    private static function extractBinaryData($image): string
    {
        $width = imagesx($image);
        $height = imagesy($image);
        $binary = '';

        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                $color = imagecolorat($image, $x, $y);
                $binary .= ($color >> 16) & 1; // R
                $binary .= ($color >> 8) & 1;  // G
                $binary .= $color & 1;        // B
            }
        }
        return $binary;
    }

    private static function loadImage(string $path)
    {
        $image = @imagecreatefrompng($path);
        if (!$image) throw new Exception("Invalid PNG image: $path");

        if (!imageistruecolor($image)) {
            $trueColor = imagecreatetruecolor(imagesx($image), imagesy($image));
            imagecopy($trueColor, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
            imagedestroy($image);
            $image = $trueColor;
        }

        return $image;
    }

    private static function safeColorAllocate($image, $r, $g, $b)
    {
        $color = @imagecolorallocate($image, $r, $g, $b);
        return $color !== false ? $color : imagecolorclosest($image, $r, $g, $b);
    }

    /**
     * Debug an encoded image
     */
    public static function debug(string $imagePath): array
    {
        $image = null;
        try {
            $image = self::loadImage($imagePath);
            $binaryData = self::extractBinaryData($image);

            // Convert first 1000 bits for analysis
            $sample = substr($binaryData, 0, 1000);
            $sampleStr = '';
            for ($i = 0; $i < strlen($sample); $i += 8) {
                $byte = substr($sample, $i, 8);
                if (strlen($byte) < 8) break;
                $sampleStr .= chr(bindec($byte));
            }

            // Find all delimiter positions
            $delimiterPositions = [];
            $offset = 0;
            while (($pos = strpos($sampleStr, self::DELIMITER, $offset)) !== false) {
                $delimiterPositions[] = $pos;
                $offset = $pos + 1;
            }

            return [
                'image_size' => imagesx($image) . 'x' . imagesy($image),
                'binary_length' => strlen($binaryData) . ' bits',
                'header_sample' => bin2hex(substr($sampleStr, 0, self::HEADER_SIZE)),
                'delimiter_positions' => $delimiterPositions,
                'data_sample' => substr($sampleStr, self::HEADER_SIZE, 50),
                'delimiter_found' => !empty($delimiterPositions)
            ];
        } finally {
            if ($image) imagedestroy($image);
        }
    }
}
