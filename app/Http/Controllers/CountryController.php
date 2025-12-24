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
            $countries = Countries::select('country_id', 'country_name')->get();
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
        session()->flash('message', 'Country name add successful.');
        return response()->json(['message' => 'Country name add successful.', 'status' => 'success']);
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
        session()->flash('message', 'Country name update successful.');
        return response()->json(['message' => 'Country name update successful.', 'status' => 'success']);
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

    public function showBulkCountryForm()
    {
        return view('country.country_bulk');
    }

    public function bulkStore(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'country_names.*' => 'required|string|distinct|unique:countries,country_name'
        ],
        [
            'country_names.*.required' => 'The country name field is required.',
            'country_names.*.distinct' => 'The country name field has a duplicate value.',
            'country_names.*.unique' => 'The country name has already been taken.'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 'errors']);
        }

        $bulkData = [];
        foreach ($request->country_names as $countryName) {
            $bulkData[] = [
                'country_name' => $countryName,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        Countries::insert($bulkData);

        session()->flash('message', 'Bulk country names added successfully.');
        return response()->json(['message' => 'Bulk country names added successfully.', 'status' => 'success']);
    }
}
