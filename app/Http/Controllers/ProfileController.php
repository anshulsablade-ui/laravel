<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use App\Models\Countries;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->all());
        if ($request->ajax()) {

            $data = User::select('id', 'photo', 'name', 'email', 'gender')->limit(10)->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="' . route('show.user', $row->id) . '" class="show btn btn-info btn-sm">View</a> <a href="' . route('edit.user', $row->id) . '" class="edit btn btn-primary btn-sm">Edit</a>
                    <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" data-id="' . $row->id . '">Delete</a>';

                    return $btn;
                })
                ->addColumn('photo', function ($row) {
                    if (!$row->photo) {
                        return '<img src="' . asset('images/default.jpg') . '" class="img-thumbnail" width="50px" height="50px">';
                    }
                    return '<img src="' . asset('images/' . $row->photo) . '" class="img-thumbnail" width="50px" height="50px">';
                })
                ->rawColumns(['action', 'photo'])
                ->make(true);
        }

        return view('profile.index');
    }

    public function edit($id)
    {
        $user = User::find($id);
        $countries = Countries::select('country_id', 'country_name')->get();
        $cities = Cities::select('city_id', 'city_name')->where('country_id', $user->country_id)->get();
        return view('profile.update', compact('user', 'countries', 'cities'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|exists:users,email',
            'address' => 'required|string',
            'country_id' => 'required|int',
            'city_id' => 'required|int',
            'gender' => 'required|in:male,female',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 'errors']);
        }
        $insert = User::where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'country_id' => $request->country_id,
            'city_id' => $request->city_id,
            'gender' => $request->gender
        ]);

        $user = User::find($request->id);


        if ($request->hasFile('profile_picture')) {

            // delete old image
            if (isset($user->photo) && file_exists(public_path('images/' . $user->photo))) {
                unlink(public_path('images/' . $user->photo));
            }

            $file = $request->file('profile_picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            User::where('id', $request->id)->update(['photo' => $filename]);
        }

        return response()->json(['success' => 'User update successful.', 'status' => 'success']);
    }

    public function delete($id)
    {
        $user = User::find($id);
        if ($user->photo && file_exists(public_path('images/' . $user->photo))) {
            unlink(public_path('images/' . $user->photo));
        }

        $user->delete();

        return response()->json(['success' => 'User delete successful.', 'status' => 'success']);
    }

    public function show($id)
    {
        $user = User::with('country', 'city')->find($id);
        return view('profile.show', compact('user'));
    }
}
