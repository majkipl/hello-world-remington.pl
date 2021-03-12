<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return view('panel/product/index');
    }

    public function create()
    {
        return view('panel/product/form', []);
    }

    public function show(Product $product)
    {
        return view('panel/product/show', [
            'product' => $product
        ]);
    }

    public function edit(Product $product)
    {
        return view('panel/product/form', [
            'product' => $product
        ]);
    }
}
