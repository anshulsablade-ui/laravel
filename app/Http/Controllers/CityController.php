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
            $cities = Cities::select('city_id', 'city_name', 'city_id')->limit(10)->get();
            return DataTables::of($cities)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="' . route('edit.city', $row->city_id) . '" class="edit btn btn-primary btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" data-id="' . $row->city_id . '">Delete</a>';

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
            'city_name' => 'required|string|unique:cities,city_name',
            'country_id' => 'required|int'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 'errors']);
        }
        $insert = Cities::create([
            'city_name' => $request->city_name,
            'country_id' => $request->country_id
        ]);
        return response()->json(['success' => 'Country name add successful.', 'status' => 'success']);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request)
    {
        //
    }

    public function delete($id)
    {
        //
    }
}
