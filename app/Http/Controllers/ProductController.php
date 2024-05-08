<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //this method show products page
    public function index()
    {
        $products = Product::orderBy('created_at', 'DESC')->get();

        return view('products.list', [
            'products' => $products
        ]);
    }

    //this method create a product 
    public function create()
    {
        return view('products.create');
    }

    //this method store a product 
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:5',
            'sku' => 'required|min:3',
            'price' => 'required|numeric'

        ];

        if ($request->image != '') {
            $rules['image'] = 'image';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('products.create')->withInput()->withErrors($validator);
        }
        // Insert product in db
        $product = new Product();
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();

        if ($request->image != '') {
            //here we will store image
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext; //unique image name

            //Save image to products directory
            $image->move(public_path('uploads/products'), $imageName);

            //Save image  is database
            $product->image = $imageName;
            $product->save();
        }

        return redirect()->route('products.index')->with('success', 'Product added successfully');
    }

    //this method edit a product 
    public function edit($id)
    {   
        $product = Product::findOrFail($id);
        return view('products.edit',[
            'product' => $product
        ]);
    }

    //this method update a product 
    public function update()
    {
    }

    //this method delete a product 
    public function destroy()
    {
    }
}
