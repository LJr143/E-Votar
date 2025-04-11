<?php
namespace App\Helpers;

use Exception;

class SteganographyHelper
{
    /**
     * Encode data into an image.
     *
     * @param string $imagePath Path to the input image.
     * @param string $data Data to encode.
     * @param string $outputPath Path to save the encoded image.
     * @return void
     * @throws Exception
     */
    public static function encode(string $imagePath, string $data, string $outputPath): void
    {
        // Load the image
        $image = imagecreatefrompng($imagePath);
        if (!$image) {
            throw new Exception("Failed to load image.");
        }

        // Convert data to binary and add a delimiter
        $binaryData = self::stringToBinary($data . '|END|'); // Ensure we can detect the end of the message

        // Get image dimensions
        $width = imagesx($image);
        $height = imagesy($image);

        // Embed data into the image
        $dataIndex = 0;
        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                if ($dataIndex >= strlen($binaryData)) {
                    break 2; // Stop if all data is embedded
                }

                // Get the color of the current pixel
                $color = imagecolorat($image, $x, $y);
                $r = ($color >> 16) & 0xFF;
                $g = ($color >> 8) & 0xFF;
                $b = $color & 0xFF;

                // Modify the least significant bit of the blue channel
                $b = ($b & ~1) | intval($binaryData[$dataIndex]);
                $newColor = imagecolorallocate($image, $r, $g, $b);

                // Set the new pixel color
                imagesetpixel($image, $x, $y, $newColor);

                $dataIndex++;
            }
        }

        // Save the encoded image
        imagepng($image, $outputPath);
        imagedestroy($image);
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
        // Load the image
        $image = imagecreatefrompng($imagePath);
        if (!$image) {
            throw new Exception("Failed to load image.");
        }

        // Get image dimensions
        $width = imagesx($image);
        $height = imagesy($image);

        // Extract data from the image
        $binaryData = '';
        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                // Get the color of the current pixel
                $color = imagecolorat($image, $x, $y);
                $b = $color & 0xFF;

                // Extract the least significant bit of the blue channel
                $binaryData .= strval($b & 1);
            }
        }

        // Convert binary data to string
        $decodedString = self::binaryToString($binaryData);

        // Check for delimiter and trim extra bits
        $decodedString = explode('|END|', $decodedString)[0];

        return $decodedString;
    }

    /**
     * Convert a string to binary.
     *
     * @param string $data Input string.
     * @return string Binary representation.
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
     *
     * @param string $binary Binary data.
     * @return string Decoded string.
     */
    private static function binaryToString(string $binary): string
    {
        $string = '';
        for ($i = 0; $i < strlen($binary); $i += 8) {
            $char = chr(bindec(substr($binary, $i, 8)));
            if ($char === "\0") break; // Stop at null bytes to prevent corruption
            $string .= $char;
        }
        return $string;
    }
}
