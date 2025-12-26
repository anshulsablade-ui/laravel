<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        
        return response()->json(['data' => $products, 'status' => 'success']);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 'errors']);
        }

        $insert = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('product'), $filename);

            $insert->image = $filename;
            $insert->save();
        }

        return response()->json(['message' => 'Product created successfully.', 'status' => 'success', 'product' => $insert]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 'errors']);
        }

        Product::where('id', $id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price
        ]);

        $product = Product::find($id);

        if ($request->hasFile('image')) {

            if (file_exists(public_path('product/' . $product->image))) {
                unlink(public_path('product/' . $product->image));
            }

            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('product'), $filename);

            $product->image = $filename;
            $product->save();
        }

        return response()->json(['message' => 'Product updated successfully.', 'status' => 'success']);
    }

    public function delete($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['errors' => 'Product not found.', 'status' => 'errors']);
        }

        if (file_exists(public_path('product/' . $product->image))) {
            unlink(public_path('product/' . $product->image));
        }

        $product->delete();
        return response()->json(['message' => 'Product deleted successfully.', 'status' => 'success']);

    }
}
