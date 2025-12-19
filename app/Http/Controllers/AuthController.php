<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function RegisterForm(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 'errors']);
        } else {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            // $token = JWTAuth::fromUser($user);
            $token = $user->createToken('auth_token')->plainTextToken;
            session()->put('token', $token);

            // // image upload
            // if ($request->hasFile('profile_picture')) {
            //     $file = $request->file('profile_picture');
            //     $filename = time() . '.' . $file->getClientOriginalExtension();
            //     $file->move(public_path('images'), $filename);
            //     $insert->photo = $filename;
            // }

            // $insert->save();

            return response()->json(['token' => $token, 'message' => 'Registration successful. ', 'status' => 'success']);
        }
    }



    // login form ----------------------------------------
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function LoginForm(Request $request)
    {
        // dd(auth()->user());
        $credentials = $request->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid login credentials'], 401);
        }

        $user = User::where('email', $request->email)->first();

        $token = $user->createToken('auth_token')->plainTextToken;
        session()->put('token', $token);

        return response()->json(['token' => $token, 'message' => 'Login successful.', 'status' => 'success']);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        session()->forget('token');

        return response()->json([
            'status' => 'success',
            'message' => 'Logout successful.'
        ]);
    }
}
