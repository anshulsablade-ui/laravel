<?php

namespace App\Http\Controllers\MultipleInsert;

use App\Http\Controllers\Controller;
use App\Models\Countries;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BulkController extends Controller
{
    public function index()
    {
        $countries = Countries::select('country_id', 'country_name')->get();
        return view('multipleinsert.users_bulk', compact('countries'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'name.*' => 'required|string|max:255',
                'email.*' => 'required|email|unique:users,email',
                'password.*' => 'required|min:6',
                'address.*' => 'required|string',
                'country_id.*' => 'required|int',
                'city_id.*' => 'required|int',
                'gender.*' => 'required|in:male,female'
            ],
            [
                'name.*.required' => 'The name field is required.',
                'name.*.string' => 'The name must be a string.',
                'name.*.max' => 'The name may not be greater than 255 characters.',

                'email.*.required' => 'The email field is required.',
                'email.*.email' => 'The email must be a valid email address.',
                'email.*.unique' => 'The email has already been taken.',

                'password.*.required' => 'The password field is required.',
                'password.*.min' => 'The password must be at least 6 characters.',

                'address.*.required' => 'The address field is required.',
                'address.*.string' => 'The address must be a string.',

                'country_id.*.required' => 'The country field is required.',
                'country_id.*.int' => 'The country field must be a number.',

                'city_id.*.required' => 'The city field is required.',
                'city_id.*.int' => 'The city field must be a number.',

                'gender.*.required' => 'The gender field is required.',
                'gender.*.in' => 'The selected gender is invalid.'
            ]
        );
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 'errors']);
        }
        
        
        $data = [];
        foreach ($request->name as $index => $name) {
        $data[] = [
            'name' => $request->name[$index],
            'email' => $request->email[$index],
            'password' => bcrypt($request->password[$index]),
            'address' => $request->address[$index],
            'country_id' => $request->country_id[$index],
            'city_id' => $request->city_id[$index],
            'gender' => $request->gender[$index],
            'created_at' => now(),
            'updated_at' => now(),
        ];
        }

        $insert = User::insert($data);

        session()->flash('message', 'User created successfully.');

        return response()->json(['message' => 'User created successfully.', 'status' => 'success']);

    }

}
