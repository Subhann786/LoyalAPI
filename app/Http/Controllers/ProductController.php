<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required',
            'name' => 'required',
            'price' => 'required|numeric',
            'points' => 'required|integer',
            'description' => 'required',
        ]);

        $product = Product::create($request->all());

        return response()->json($product, 201);
    }

    public function show($id)
    {
        $product = Product::find($id);
    
        if (!$product) {
            return response()->json(['message' => 'No ID found'], 404);
        }
    
        return response()->json($product);
    }
    
    public function update(Request $request ,$id)
    {
        $product = Product::find($request->id);

        if (!$product) {
            return response()->json(['message' => 'No ID found'], 404);
        }
        // $request->validate([
        //     'image' => 'required',
        //     'name' => 'required',
        //     'price' => 'required|numeric',
        //     'points' => 'required|integer',
        //     'description' => 'required',
        // ]);
    

        $product->image = $request->input('image');
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->points = $request->input('points');
        $product->description = $request->input('description');
    
        $product->save();

        return response()->json($product);
    }
     
    public function delete(Request $request)
{
    $product = Product::find($request->id);

    if (!$product) {
        return response()->json(['message' => 'No ID found'], 404);
    }

    $product->delete();

    return response()->json(['message' => 'Product deleted successfully']);
}

}

