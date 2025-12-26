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

            $token = JWTAuth::fromUser($user);
            session()->put('token', $token);

            session()->flash('message', 'Registration successful.');
            return response()->json(['token' => $token, 'message' => 'Registration successful. ', 'status' => 'success', 'expires_in' => config('jwt.ttl'), 'user' => $user]);
        }
    }



    // login form ----------------------------------------
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function LoginForm(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['status' => 'errors', 'message' => 'Invalid credentials.']);
        }

        $user = User::where('email', $request->email)->first();

        $token = JWTAuth::fromUser($user);
        session()->put('token', $token);

        session()->flash('message', 'Login successful.');
        return response()->json(['token' => $token, 'message' => 'Login successful.', 'status' => 'success', 'expires_in' => config('jwt.ttl') , 'user' => $user]);
    }

    public function logout(Request $request)
    {
        session()->forget('token');

        Auth::guard('api')->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'Logout successful.'
        ]);
    }

    public function me()
    {
        return response()->json(Auth::guard('api')->user());
    }

    public function refresh()
    {
        $token = JWTAuth::refresh(JWTAuth::getToken());
        return response()->json([
                'token' => $token,
                'status' => 'success', 
                'expires_in' => config('jwt.ttl')
            ]);
    }
}
