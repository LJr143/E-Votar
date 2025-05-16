<?php
namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Storage;

class SteganographyHelper
{
    /**
     * Encode data into an image.
     *
     * @param string $imagePath Path to the input image.
     * @param string $data Data to encode.
     * @param string $outputPath Path to save the encoded image.
     * @return string Path to the encoded image
     * @throws Exception
     */
    public static function encode(string $imagePath, string $data, string $outputPath): string
    {
        try {
            // Verify the image exists and is PNG
            if (!file_exists($imagePath)) {
                throw new Exception("Source image not found");
            }

            $imageInfo = getimagesize($imagePath);
            if ($imageInfo[2] !== IMAGETYPE_PNG) {
                throw new Exception("Only PNG images are supported");
            }

            // Load the image
            $image = @imagecreatefrompng($imagePath);
            if (!$image) {
                throw new Exception("Failed to load PNG image");
            }

            // Convert to true color if needed
            if (!imageistruecolor($image)) {
                $trueColorImage = imagecreatetruecolor(imagesx($image), imagesy($image));
                imagecopy($trueColorImage, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
                imagedestroy($image);
                $image = $trueColorImage;
            }

            // Prepare data
            $binaryData = self::prepareDataForEncoding($data);
            $dataLength = strlen($binaryData);
            $width = imagesx($image);
            $height = imagesy($image);

            $dataIndex = 0;
            for ($y = 0; $y < $height; $y++) {
                for ($x = 0; $x < $width; $x++) {
                    if ($dataIndex >= $dataLength) {
                        break 2;
                    }

                    $color = imagecolorat($image, $x, $y);
                    $r = ($color >> 16) & 0xFF;
                    $g = ($color >> 8) & 0xFF;
                    $b = $color & 0xFF;

                    // Modify LSB
                    $b = ($b & ~1) | intval($binaryData[$dataIndex]);

                    // Allocate color with retry logic
                    $newColor = imagecolorallocate($image, $r, $g, $b);
                    if ($newColor === false) {
                        $newColor = imagecolorclosest($image, $r, $g, $b);
                        if ($newColor === false) {
                            $newColor = imagecolorallocate($image, $r & 0xFE, $g & 0xFE, $b & 0xFE);
                            if ($newColor === false) {
                                imagedestroy($image);
                                throw new Exception("Color allocation failed at {$x},{$y}");
                            }
                        }
                    }

                    imagesetpixel($image, $x, $y, $newColor);
                    $dataIndex++;
                }
            }

            // Save with maximum compression
            if (!imagepng($image, $outputPath, 9)) {
                throw new Exception("Failed to save encoded image");
            }

            imagedestroy($image);
            return $outputPath;

        } catch (Exception $e) {
            if (isset($image) && is_resource($image)) {
                imagedestroy($image);
            }
            throw new Exception("Encoding failed: " . $e->getMessage());
        }
    }

    /**
     * Decode data from an image.
     *
     * @param string $imagePath Path to the encoded image.
     * @return string Decoded data.
     * @throws Exception
     */
    public static function decode(string $imagePath): string
    {
        try {
            if (!file_exists($imagePath)) {
                throw new Exception("Encoded image not found at path: {$imagePath}");
            }

            $image = @imagecreatefrompng($imagePath);
            if (!$image) {
                throw new Exception("Failed to load encoded image. Ensure it's a valid PNG file.");
            }

            // Get image dimensions
            $width = imagesx($image);
            $height = imagesy($image);

            // Extract data from the image
            $binaryData = '';
            $channel = 0; // Must match the encoding channel rotation
            for ($y = 0; $y < $height; $y++) {
                for ($x = 0; $x < $width; $x++) {
                    // Get the color of the current pixel
                    $color = imagecolorat($image, $x, $y);
                    $r = ($color >> 16) & 0xFF;
                    $g = ($color >> 8) & 0xFF;
                    $b = $color & 0xFF;

                    // Extract the least significant bit from the current channel
                    switch ($channel) {
                        case 0: $binaryData .= strval($r & 1); break;
                        case 1: $binaryData .= strval($g & 1); break;
                        case 2: $binaryData .= strval($b & 1); break;
                    }

                    $channel = ($channel + 1) % 3; // Rotate through RGB channels
                }
            }

            imagedestroy($image);

            // Convert binary data to string and verify
            return self::processDecodedData($binaryData);
        } catch (Exception $e) {
            if (isset($image) && is_resource($image)) {
                imagedestroy($image);
            }
            throw new Exception("Steganography decoding failed: " . $e->getMessage());
        }
    }

    /**
     * Prepare data for encoding with checksum and delimiter.
     */
    private static function prepareDataForEncoding(string $data): string
    {
        // Add checksum and delimiter
        $checksum = crc32($data);
        $payload = $data . '|CHECKSUM:' . $checksum . '|END|';

        return self::stringToBinary($payload);
    }

    /**
     * Process decoded data and verify checksum.
     */
    private static function processDecodedData(string $binaryData): string
    {
        $decodedString = self::binaryToString($binaryData);

        // Extract checksum and verify
        if (preg_match('/(.*)\|CHECKSUM:(\d+)\|END\|/', $decodedString, $matches)) {
            $data = $matches[1];
            $storedChecksum = $matches[2];

            if (crc32($data) != $storedChecksum) {
                throw new Exception("Data checksum verification failed - possible corruption");
            }

            return $data;
        }

        throw new Exception("Invalid data format - delimiter not found");
    }

    /**
     * Convert a string to binary.
     */
    private static function stringToBinary(string $data): string
    {
        $binary = '';
        for ($i = 0; $i < strlen($data); $i++) {
            $binary .= str_pad(decbin(ord($data[$i])), 8, '0', STR_PAD_LEFT);
        }
        return $binary;
    }

    /**
     * Convert binary to a string.
     */
    private static function binaryToString(string $binary): string
    {
        $string = '';
        // Process in chunks of 8 bits
        $chunks = str_split($binary, 8);

        foreach ($chunks as $chunk) {
            if (strlen($chunk) < 8) continue; // Skip incomplete bytes

            $char = chr(bindec($chunk));
            $string .= $char;
        }

        return $string;
    }
}
