<?php

namespace App\Http\Controllers\MultipleInsert;

use App\Http\Controllers\Controller;
use App\Models\Users_bulk;
use Illuminate\Http\Request;

class BulkController extends Controller
{
    public function index()
    {
        return view('multipleinsert.users_bulk');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name.*'  => 'required|string|max:100',
            'email.*' => 'required|email|distinct'
        ]);

        $data = [];

        foreach ($request->name as $key => $name) {
            $data[] = [
                'name' => $name,
                'email' => $request->email[$key],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Users_bulk::insert($data);

        return response()->json([
            'status' => true,
            'message' => 'Records inserted successfully'
        ]);
    }
}
