<?php

namespace App\Http\Controllers;

use App\Models\FaceData;
use App\Models\User;
use Illuminate\Http\Request;
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
                'captures.*.quality' => 'required|numeric',
                'captures.*.descriptor' => 'required|array'
            ]);

            $user = User::findOrFail($request->user_id);

            // Update user status
            $user->update([
                'account_status' => 'Active',
            ]);

            // Delete any existing face data
            $user->faceData()->delete();

            // Store each capture
            foreach ($request->captures as $capture) {
                $imagePath = $this->storeImage($capture['image']);

                $user->faceData()->create([
                    'angle' => 0, // Default angle since we're not capturing multiple angles
                    'image_path' => $imagePath,
                    'quality_score' => $capture['quality'],
                    'descriptor' => json_encode($capture['descriptor']) // Store descriptor as JSON
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Face registration completed successfully',
            ]);

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
