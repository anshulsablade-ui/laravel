<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use App\Models\Countries;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        // dd(auth()->user());
        if ($request->ajax()) {

            $data = User::select('id', 'photo', 'name', 'email', 'gender')->get();

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

    public function create()
    {
        $countries = Countries::select('country_id', 'country_name')->get();
        return view('profile.create', compact('countries'));
    }

    public function store(Request $request)
    {
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

            session()->flash('message', 'User created successfully.');

            return response()->json(['message' => 'User created successfully.', 'status' => 'success']);
        }
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
            'email' => 'required|email',
            'address' => 'required|string',
            'country_id' => 'nullable|int',
            'city_id' => 'nullable|int',
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
            if (file_exists(public_path('images/' . $user->photo))) {
                unlink(public_path('images/' . $user->photo));
            }

            $file = $request->file('profile_picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('images'), $filename);
            $user->update(['photo' => $filename]);
        }

        session()->flash('message', 'User update successful.');
        return response()->json(['message' => 'User update successful.', 'status' => 'success']);
    }

    public function apiUserUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|int',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'address' => 'required|string',
            'gender' => 'required|in:male,female'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 'errors']);
        }

        User::where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'gender' => $request->gender
        ]);

        return response()->json(['message' => 'User update successful.', 'status' => 'success']);
    }

    public function delete(Request $request, $id)
    {
        $user = User::find($id);
        if ($user->photo && file_exists(public_path('images/' . $user->photo))) {
            unlink(public_path('images/' . $user->photo));
        }

        $user->delete();

        return response()->json(['message' => 'User delete successful.', 'status' => 'success']);
    }

    public function show($id)
    {
        $user = User::with('country', 'city')->find($id);
        return view('profile.show', compact('user'));
    }
    public function loginuserprofileEdit()
    {
        $user = auth()->user();
        $countries = Countries::select('country_id', 'country_name')->get();
        $cities = Cities::select('city_id', 'city_name')->where('country_id', $user->country_id)->get();
        return view('profile.userprofileupdate', compact('user', 'countries', 'cities'));
    }

    public function getusers(Request $request)
    {
        $data = User::query()
            ->select([ 'id', 'name', 'email', 'address', 'country_id', 'city_id', 'created_at', ])
            ->with([
                'country:country_id,country_name',
                'city:city_id,city_name',
            ])
            ->latest()
            ->get();

        return response()->json($data);
    }
}
