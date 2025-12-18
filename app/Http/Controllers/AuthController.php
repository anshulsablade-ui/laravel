<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        $countries = Countries::select('country_id', 'country_name')->get();
        return view('auth.register', compact('countries'));
    }

    public function RegisterForm(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'address' => 'required|string',
            'country_id' => 'required|int',
            'city_id' => 'required|int',
            'gender' => 'required|in:male,female',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 'errors']);
        } else {

            $insert = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'address' => $request->address,
                'country_id' => $request->country_id,
                'city_id' => $request->city_id,
                'gender' => $request->gender
            ]);

            // image upload
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images'), $filename);
                $insert->photo = $filename;
            }

            $insert->save();

            return response()->json(['success' => 'Registration successful. Please login.', 'status' => 'success']);
        }
    }

    public function update(Request $request) {}



    // login form ----------------------------------------
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function LoginForm(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json(['success' => 'Login successful.', 'status' => 'success']);
        }

        return response()->json(['error' => 'The provided credentials do not match our records.', 'status' => 'error']);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('showLoginForm');
    }
}
