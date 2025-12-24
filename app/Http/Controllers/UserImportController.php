<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserImportController extends Controller
{
    public function index()
    {
        return view('csv_upload.csv-upload');
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|mimes:csv',
        ], 
        [
            'csv_file.required' => 'Please upload a CSV file.',
            'csv_file.mimes' => 'The file must be a CSV format.',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'errors', 'errors' => $validator->errors()]);
        }

        $file = fopen($request->file('csv_file'), 'r');
        fgetcsv($file);
        // dd((fgetcsv($file)) !== false);

        while (($row = fgetcsv($file)) !== false) {
            User::create([
                'name' => $row[0],
                'email' => $row[1],
                'password' => Hash::make($row[2]),
                'address' => $row[3],
                'gender' => $row[4]
            ]);
        }

        fclose($file);

        session()->flash('success', 'CSV Data Imported Successfully!');
        return response()->json(['status' => 'success', 'message' => 'CSV Data Imported Successfully!']);
    }
}

