<?php

namespace App\Http\Controllers;

use App\Models\FaceData;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaceAuthController extends Controller
{
    public function getDescriptors(Request $request)
    {
        try {
            $user = Auth::user();

            // Get all face data records for the authenticated user
            $faceData = FaceData::where('user_id', $user->id)->get();

            if ($faceData->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No face data registered for this user'
                ], 404);
            }

            // Extract descriptors from all face data records
            $descriptors = $faceData->pluck('descriptor')->map(function ($descriptor) {
                // Ensure descriptor is properly formatted
                if (is_string($descriptor)) {
                    return json_decode($descriptor, true);
                }
                return $descriptor;
            })->toArray();

            return response()->json([
                'success' => true,
                'descriptors' => $descriptors
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function verify(Request $request)
    {
        try {
            $validated = $request->validate([
                'is_verified' => 'required|boolean',
                'confidence' => 'required|numeric',
                'user_id' => 'required|exists:users,id'
            ]);

            $user = User::findOrFail($request->user_id);

//            // Log the verification attempt
//            $user->faceVerificationLogs()->create([
//                'is_verified' => $request->is_verified,
//                'confidence' => $request->confidence,
//                'ip_address' => $request->ip()
//            ]);

            return response()->json([
                'success' => true,
                'message' => 'Verification result logged'
            ]);



        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
