<?php

namespace App\Http\Controllers;

use App\Models\User;
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

                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('auth.index');
    }


    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function LoginForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            redirect()->back()->withErrors($validator)->withInput();
        } else {
        }
    }


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
            'password' => 'required|min:6',
            'address' => 'required|string',
            'gender' => 'required|in:male,female,other',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 'error']);
            // redirect()->back()->withErrors($validator)->withInput();
        } else {

            $insert = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'address' => $request->address,
                'city_id' => $request->city,
                'country_id' => $request->country,
                'gender' => $request->gender
            ]);

            // image upload handling
            if ($request->hasFile('profile_picture')) {
                $image = $request->file('profile_picture');
                $imageName = time() . '_.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/profile_pictures'), $imageName);
                $insert->photo = 'uploads/profile_pictures/' . $imageName;
                $insert->save();
            }

            return response()->json(['success' => 'Registration successful. Please login.', 'status' => 'success']);
            // return Redirect::route('login')->with(['success' => 'Registration successful. Please login.', 'status' => 'success']);
        }
    }

    public function update(Request $request) {}
}
