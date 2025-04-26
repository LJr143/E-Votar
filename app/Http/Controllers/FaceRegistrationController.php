<?php

namespace App\Http\Controllers;

use App\Models\FaceData;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class FaceRegistrationController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'captures' => 'required|array|min:1',
                'captures.*.image' => 'required|string',
                'captures.*.quality' => 'required|numeric|between:0,1',
                'captures.*.descriptor' => 'required|array'
            ]);

            $user = User::findOrFail($request->user_id);

            // Delete any existing face data first
            $user->faceData()->delete();

            $successfulCaptures = 0;

            // Store each capture
            foreach ($request->captures as $capture) {
                try {
                    $imagePath = $this->storeImage($capture['image']);

                    $user->faceData()->create([
                        'user_id' => $user->id,
                        'angle' => 0,
                        'image_path' => $imagePath,
                        'quality_score' => $capture['quality'],
                        'descriptor' => json_encode($capture['descriptor'])
                    ]);

                    $successfulCaptures++;
                } catch (\Exception $e) {
                    Log::error("Error processing face capture: " . $e->getMessage());
                    continue;
                }
            }

            if ($successfulCaptures === 0) {
                throw new \Exception("No valid face captures were processed");
            }

            // Update user status
            $user->update(['account_status' => 'Active']);

            return response()->json([
                'success' => true,
                'message' => 'Face registration completed successfully',
                'count' => $successfulCaptures
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function storeImage($base64Image)
    {
        // Remove data URL prefix if present
        if (strpos($base64Image, 'data:image') === 0) {
            $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
        }

        // Decode the base64 string
        $imageData = base64_decode($base64Image);

        // Generate unique filename
        $fileName = 'face_'.time().'_'.Str::random(10).'.jpg';
        $path = 'faces/'.$fileName;

        // Create and store the image using Intervention Image v3
        $image = Image::read($imageData);
        Storage::disk('public')->put($path, $image->encode());

        return $path;
    }
}
