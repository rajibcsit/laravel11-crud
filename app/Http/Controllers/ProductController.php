<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //this method show products page
    public function index()
    {
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

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('products.create')->withInput()->withErrors($validator);
        }
        // Insert product in db 
    }

    //this method edit a product 
    public function edit()
    {
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
