<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $countries = Countries::select('country_id', 'country_name')->limit(10)->get();
            return DataTables::of($countries)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                $btn = '<a href="' . route('edit.country', $row->country_id) . '" class="edit btn btn-primary btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" data-id="' . $row->country_id . '">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('country.index');
    }
    public function showCountryForm(Request $request)
    {
        return view('country.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_name' => 'required|string|unique:countries,country_name'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 'errors']);
        }
        $insert = Countries::create([
            'country_name' => $request->country_name
        ]);
        return response()->json(['success' => 'Country name add successful.', 'status' => 'success']);
    }

    public function edit($id)
    {
        $countries = Countries::select('country_id', 'country_name')->where('country_id', $id)->first();
        return view('country.update', compact('countries'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_name' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 'errors']);
        }
        $insert = Countries::where('country_id', $request->country_id)->update([
            'country_name' => $request->country_name
        ]);
        return response()->json(['success' => 'Country name update successful.', 'status' => 'success']);
    }

    public function delete($id)
    {
        // dd($request->all());
        $countries = Countries::where('country_id', $id)->first();
        if ($countries) {
            Countries::where('country_id', $id)->delete();
            return response()->json(['success' => 'Country name delete successful.', 'status' => 'success']);
        }
        if ($countries = null) {
            return response()->json(['errors' => 'Country not found.', 'status' => 'errors']);
        }
    }
}
