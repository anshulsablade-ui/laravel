<?php

namespace App\Http\Controllers\SanctumApi;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 'errors']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('token')->plainTextToken;

        return response()->json(['token' => $token, 'message' => 'Registration successful.', 'status' => 'success']);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 'errors']);
        }

        $user = User::where('email', $request->email)->first();

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['status' => 'errors', 'errors' => ['email' => ['Invalid credentials.']]]);
        }

        $user->tokens()->delete();
        $token = $user->createToken('token')->plainTextToken;

        return response()->json(['token' => $token, 'message' => 'Login successful.', 'status' => 'success']);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json([ 'message' => 'Logout successful.', 'status' => 'success']);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function refresh(Request $request)
    {
        $user = $request->user();
        $request->user()->tokens()->delete();

        $newToken = $user->createToken('api-token')->plainTextToken;
        return response()->json(['token' => $newToken, 'message' => 'Token refreshed.', 'status' => 'success']);
    }
}
