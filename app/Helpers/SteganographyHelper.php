<?php
namespace App\Helpers;

use Exception;

class SteganographyHelper
{
    private const VERSION = 1;
    private const DELIMITER = '|END|';
    private const HEADER_SIZE = 9; // Version (1) + Declared Length (4) + Actual Length (4)

    /**
     * Encode data into an image
     */
    public static function encode(string $imagePath, string $data, string $outputPath): string
    {
        try {
            // Validate input
            if (!file_exists($imagePath)) {
                throw new Exception("Source image not found");
            }

            // Load image and convert to true color
            $image = self::loadImage($imagePath);
            $width = imagesx($image);
            $height = imagesy($image);
            $maxDataSize = ($width * $height * 3) / 8; // 3 bits per pixel (RGB)

            // Prepare binary data with headers and checksum
            $binaryData = self::prepareDataForEncoding($data);
            if (strlen($binaryData) > $maxDataSize) {
                throw new Exception("Data too large for image. Max: {$maxDataSize} bytes");
            }

            // Encode data into image
            $dataIndex = 0;
            for ($y = 0; $y < $height; $y++) {
                for ($x = 0; $x < $width; $x++) {
                    if ($dataIndex >= strlen($binaryData)) break 2;

                    $color = imagecolorat($image, $x, $y);
                    $r = ($color >> 16) & 0xFF;
                    $g = ($color >> 8) & 0xFF;
                    $b = $color & 0xFF;

                    // Encode in all three channels
                    if ($dataIndex < strlen($binaryData)) {
                        $r = ($r & ~1) | intval($binaryData[$dataIndex++]);
                    }
                    if ($dataIndex < strlen($binaryData)) {
                        $g = ($g & ~1) | intval($binaryData[$dataIndex++]);
                    }
                    if ($dataIndex < strlen($binaryData)) {
                        $b = ($b & ~1) | intval($binaryData[$dataIndex++]);
                    }

                    $newColor = self::safeColorAllocate($image, $r, $g, $b);
                    imagesetpixel($image, $x, $y, $newColor);
                }
            }

            // Save with maximum compression
            if (!imagepng($image, $outputPath, 9)) {
                throw new Exception("Failed to save encoded image");
            }

            return $outputPath;
        } finally {
            if (isset($image)) imagedestroy($image);
        }
    }

    /**
     * Decode data from an image
     */
    public static function decode(string $imagePath): string
    {
        try {
            $image = self::loadImage($imagePath);
            $width = imagesx($image);
            $height = imagesy($image);

            // Extract binary data from all channels
            $binaryData = '';
            for ($y = 0; $y < $height; $y++) {
                for ($x = 0; $x < $width; $x++) {
                    $color = imagecolorat($image, $x, $y);
                    $binaryData .= ($color >> 16) & 1; // R
                    $binaryData .= ($color >> 8) & 1;  // G
                    $binaryData .= $color & 1;         // B
                }
            }

            return self::processDecodedData($binaryData);
        } finally {
            if (isset($image)) imagedestroy($image);
        }
    }

    private static function prepareDataForEncoding(string $data): string
    {
        $checksum = crc32($data);
        $header = pack('C2N2', self::VERSION, self::VERSION, strlen($data), $checksum);
        $payload = $header . $data . self::DELIMITER;
        return self::stringToBinary($payload);
    }

    private static function processDecodedData(string $binaryData): string
    {
        $data = self::binaryToString($binaryData);

        // Verify minimum length
        if (strlen($data) < self::HEADER_SIZE + 4 + strlen(self::DELIMITER)) {
            throw new Exception("Data too short");
        }

        // Extract header
        $header = unpack('Cversion/CversionCheck/Nlength/Nchecksum', substr($data, 0, self::HEADER_SIZE));

        // Verify header consistency
        if ($header['version'] !== self::VERSION || $header['versionCheck'] !== self::VERSION) {
            throw new Exception("Invalid data format version");
        }

        // Extract payload
        $payload = substr($data, self::HEADER_SIZE, $header['length']);
        $storedDelimiter = substr($data, self::HEADER_SIZE + $header['length']);

        // Verify checksum
        if (crc32($payload) !== $header['checksum']) {
            throw new Exception(sprintf(
                "Checksum mismatch (Expected: %u, Actual: %u)",
                $header['checksum'],
                crc32($payload)
            ));
        }

        // Verify delimiter
        if ($storedDelimiter !== self::DELIMITER) {
            throw new Exception("Delimiter not found");
        }

        return $payload;
    }

    private static function loadImage(string $path)
    {
        $image = @imagecreatefrompng($path);
        if (!$image) throw new Exception("Invalid PNG image");

        // Convert to true color if needed
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
        $color = imagecolorallocate($image, $r, $g, $b);
        return $color !== false ? $color : imagecolorclosest($image, $r, $g, $b);
    }

    private static function stringToBinary(string $data): string
    {
        $binary = '';
        foreach (str_split($data) as $char) {
            $binary .= str_pad(decbin(ord($char)), 8, '0', STR_PAD_LEFT);
        }
        return $binary;
    }

    private static function binaryToString(string $binary): string
    {
        $string = '';
        foreach (str_split($binary, 8) as $byte) {
            $string .= chr(bindec(str_pad($byte, 8, '0')));
        }
        return $string;
    }

    /**
     * Debugging tool to verify encoding
     */
    public static function debug(string $imagePath): array
    {
        $image = self::loadImage($imagePath);
        $width = imagesx($image);
        $height = imagesy($image);

        $binary = '';
        for ($y = 0; $y < min($height, 10); $y++) { // Sample first 10 rows
            for ($x = 0; $x < $width; $x++) {
                $color = imagecolorat($image, $x, $y);
                $binary .= ($color >> 16) & 1; // R
                $binary .= ($color >> 8) & 1;  // G
                $binary .= $color & 1;        // B
            }
        }

        imagedestroy($image);

        $headerBinary = substr($binary, 0, self::HEADER_SIZE * 8);
        $header = self::binaryToString($headerBinary);
        $unpacked = @unpack('Cversion/CversionCheck/Nlength/Nchecksum', $header);

        return [
            'image_size' => "{$width}x{$height}",
            'header_raw' => bin2hex($header),
            'header_parsed' => $unpacked ?: 'Invalid header',
            'first_100_bits' => substr($binary, 0, 100),
            'estimated_capacity' => floor(($width * $height * 3) / 8) . ' bytes'
        ];
    }
}
