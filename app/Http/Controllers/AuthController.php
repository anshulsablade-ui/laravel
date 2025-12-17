<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->all());
        if ($request->ajax()) {

            $data = User::select('id', 'photo', 'name', 'email', 'gender')->limit(10)->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="' . route('edit.user', $row->id) . '" class="edit btn btn-primary btn-sm">Edit</a>
                    <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" data-id="' . $row->id . '">Delete</a>';

                    return $btn;
                })
                ->addColumn('photo', function ($row) {

                    return '<img src="' . asset($row->photo) . '" class="img-thumbnail" width="50px" height="50px">';
                })
                ->rawColumns(['action', 'photo'])
                ->make(true);
        }

        return view('auth.index');
    }


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
            'gender' => 'required|in:male,female,other',
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
                'country_id' => $request->country,
                'city_id' => $request->city,
                'gender' => $request->gender
            ]);

            // image upload handling
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images'), $filename);
                $insert->photo = $filename;
            }

            return response()->json(['success' => 'Registration successful. Please login.', 'status' => 'success']);
            // return Redirect::route('login')->with(['success' => 'Registration successful. Please login.', 'status' => 'success']);
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

            response()->json(['success' => 'Login successful.', 'status' => 'success']);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('showLoginForm');
    }
}
