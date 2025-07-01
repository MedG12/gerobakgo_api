<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $users = User::all();
        return response()->json($users);
    }
    /**
     * Store a newly created user in storage.
     *
     * @param  \App\Http\Requests\RegisterUserRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RegisterUserRequest $request)
    {
        $validated = $request->validated();
        // Hash the password before saving
        $validated['password'] = Hash::make($validated['password']);
        // Create the user
        $user = User::create($validated);

        auth()->login($user); // Login tanpa perlu attempt lagi
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'data' => $user,
            'token' => $token
        ], 201);
    }

    /**
     * Handle user login.
     *
     * @param  \App\Http\Requests\LoginUserRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginUserRequest $request)
    {
        $credentials = $request->validated();

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'success' => true,
                'data' => $user,
                'token' => $token
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Username atau password salah'], 401);
    }


    /**
     * Display the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->validated());

        return response()->json([
            'success' => true,
            'data' => $user->fresh()
        ]);
    }
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }


    public function uploadImage(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate the image file
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        try {
            // Create image manager with desired driver
            $manager = new ImageManager(new Driver());

            // Read the image file correctly
            $image = $manager->read($request->file('image')->getPathname());

            // Resize and encode the image
            $image->cover(300, 300); // This will crop to fit
            $encodedImage = $image->toJpeg(80); // Convert to JPEG with 80% quality

            // Delete old photo if exists
            if ($user->photoUrl) {
                $oldPhotoPath = str_replace('/storage', 'public', parse_url($user->photoUrl, PHP_URL_PATH));
                Storage::delete($oldPhotoPath);
            }

            // Generate unique filename
            $fileName = 'user_' . $user->id . '_' . time() . '.jpg';
            $storagePath = 'public/users/photos/' . $fileName;

            // Save the image to storage
            Storage::put($storagePath, $encodedImage);

            // Update user record
            $user->photoUrl = $storagePath;
            $user->save();

            return response()->json([
                'success' => true,
                'data' => $user,
                'message' => 'Image uploaded successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload image: ' . $e->getMessage()
            ], 500);
        }
    }
}
