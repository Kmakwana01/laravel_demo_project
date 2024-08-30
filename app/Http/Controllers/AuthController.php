<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function signUp(Request $req)
    {
        try {
            // Validate incoming request
            $validator = Validator::make($req->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed', // Ensure password confirmation
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Create the user
            $data = $req->only(['name', 'email', 'password']);
            $data['password'] = bcrypt($data['password']);
            $user = User::create($data);

            // Generate the token
            $token = $user->createToken('MyApp')->plainTextToken;

            return response()->json([
                'status' => 201,
                'message' => 'User created successfully',
                'data' => [
                    'user' => $user,
                    'token' => $token,
                ]
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());

            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while creating the user',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function login(Request $req)
    {
        try {
            // Validate incoming request
            $validator = Validator::make($req->all(), [
                'email' => 'required|email',
                'password' => 'required|string|min:8',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Find the user by email
            $user = User::where('email', $req->email)->first();

            // Check if user exists and password is correct
            if (!$user || !Hash::check($req->password, $user->password)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Invalid credentials',
                ], 401);
            }

            // Generate a token for the user
            $token = $user->createToken('MyApp')->plainTextToken;

            return response()->json([
                'status' => 200,
                'message' => 'Login successful',
                'data' => [
                    'user' => $user,
                    'token' => $token,
                ]
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error logging in user: ' . $e->getMessage());

            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while logging in',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function loginError(Request $req)
    {
        try {
            
            // Validate incoming request
            return response()->json([
                'status' => 422,
                'message' => 'Invalid Credentials'
            ], 422);

        } catch (\Exception $e) {
            Log::error('Error logging in user: ' . $e->getMessage());

            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while logging in',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
