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

            // Prepare binary payload
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

            // Save image
            if (!imagepng($image, $outputPath, 9)) {
                throw new Exception("Failed to save image to: $outputPath");
            }

            return $outputPath;
        } finally {
            if ($image) imagedestroy($image);
        }
    }

    /**
     * Decode data from an image
     */
    public static function decode(string $imagePath): string
    {
        $image = null;
        try {
            $image = self::loadImage($imagePath);
            $binaryData = self::extractBinaryData($image);
            return self::validateAndDecodeData($binaryData);
        } finally {
            if ($image) imagedestroy($image);
        }
    }

    private static function prepareDataForEncoding(string $data): string
    {
        $checksum = crc32($data);
        $header = pack(self::HEADER_FORMAT, self::VERSION, self::VERSION, strlen($data), $checksum);
        $payload = $header . $data . self::DELIMITER;

        // Convert to binary string (8 bits per byte)
        $binary = '';
        for ($i = 0; $i < strlen($payload); $i++) {
            $binary .= str_pad(decbin(ord($payload[$i])), 8, '0', STR_PAD_LEFT);
        }
        return $binary;
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

    private static function validateAndDecodeData(string $binaryData): string
    {
        // Convert binary to string (8 bits per byte)
        $data = '';
        for ($i = 0; $i < strlen($binaryData); $i += 8) {
            $byte = substr($binaryData, $i, 8);
            if (strlen($byte) < 8) break;
            $data .= chr(bindec($byte));
        }

        // Verify minimum length
        if (strlen($data) < self::HEADER_SIZE) {
            throw new Exception("Data too short (".strlen($data)." bytes)");
        }

        // Extract and verify header
        $header = substr($data, 0, self::HEADER_SIZE);
        $unpacked = unpack(self::HEADER_FORMAT, $header);

        if (!is_array($unpacked) || count($unpacked) !== 4) {
            throw new Exception("Invalid header format");
        }

        // Verify version
        if ($unpacked['version'] !== self::VERSION || $unpacked['versionCheck'] !== self::VERSION) {
            throw new Exception("Version mismatch");
        }

        // Verify length
        $expectedLength = self::HEADER_SIZE + $unpacked['length'] + strlen(self::DELIMITER);
        if (strlen($data) < $expectedLength) {
            throw new Exception("Data truncated. Expected {$expectedLength} bytes, got ".strlen($data));
        }

        // Extract payload
        $payload = substr($data, self::HEADER_SIZE, $unpacked['length']);
        $delimiter = substr($data, self::HEADER_SIZE + $unpacked['length']);

        // Verify checksum
        if (crc32($payload) !== $unpacked['checksum']) {
            throw new Exception(sprintf(
                "Checksum failed (Expected: %u, Actual: %u)",
                $unpacked['checksum'],
                crc32($payload)
            ));
        }

        // Verify delimiter
        if ($delimiter !== self::DELIMITER) {
            throw new Exception("Delimiter not found");
        }

        return $payload;
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

            // Get first 100 bytes for analysis
            $sample = substr($binaryData, 0, 800); // 100 bytes * 8 bits
            $sampleStr = '';
            for ($i = 0; $i < strlen($sample); $i += 8) {
                $sampleStr .= chr(bindec(substr($sample, $i, 8)));
            }

            return [
                'image_size' => imagesx($image) . 'x' . imagesy($image),
                'binary_length' => strlen($binaryData) . ' bits',
                'header_sample' => bin2hex(substr($sampleStr, 0, self::HEADER_SIZE)),
                'data_sample' => substr($sampleStr, self::HEADER_SIZE, 50),
                'full_sample' => $sampleStr
            ];
        } finally {
            if ($image) imagedestroy($image);
        }
    }
}
