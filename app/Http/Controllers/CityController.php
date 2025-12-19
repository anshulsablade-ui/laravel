<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use App\Models\Countries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class CityController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $cities = Cities::select('city_id', 'city_name', 'country_id')
                ->with(['country' => function ($query) {
                    $query->select('country_id', 'country_name');
                }])
                ->get();

            // dd($cities->toArray());
            return DataTables::of($cities)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="' . route('edit.city', $row->city_id) . '" class="edit btn btn-primary btn-sm">Edit</a> 
                    <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" data-id="' . $row->city_id . '">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('city.index');
    }

    public function showCityForm()
    {
        $countries = Countries::select('country_id', 'country_name')->get();
        return view('city.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'city_name' => 'required|string',
            'country_id' => 'required|int'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 'errors']);
        }
        $insert = Cities::create([
            'city_name' => $request->city_name,
            'country_id' => $request->country_id
        ]);
        return response()->json(['message' => 'Country name add successful.', 'status' => 'success']);
    }

    public function edit($id)
    {
        $cities = Cities::select('city_id', 'city_name', 'country_id')->where('city_id', $id)->first();
        $countries = Countries::select('country_id', 'country_name')->get();
        return view('city.update', compact('cities', 'countries'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'city_name' => 'required|string',
            'country_id' => 'required|int'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 'errors']);
        }
        $insert = Cities::where('city_id', $request->city_id)->update([
            'city_name' => $request->city_name,
            'country_id' => $request->country_id
        ]);
        return response()->json(['message' => 'City name update successful.', 'status' => 'success']);
    }

    public function delete($id)
    {
        // dd($request->all());
        $cities = Cities::where('city_id', $id)->first();
        if ($cities) {
            Cities::where('city_id', $id)->delete();
            return response()->json(['message' => 'City name delete successful.', 'status' => 'success']);
        }
        if ($cities = null) {
            return response()->json(['errors' => 'City not found.', 'status' => 'errors']);
        }
    }

    public function getCities(Request $request)
    {
        $cities = Cities::select('city_id', 'city_name')->where('country_id', $request->country_id)->with('country')->get();
        return response()->json($cities);
    }
}
