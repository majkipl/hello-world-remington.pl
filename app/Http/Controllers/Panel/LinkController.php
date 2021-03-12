<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Link;
use App\Models\Product;

class LinkController extends Controller
{
    public function index()
    {
        return view('panel/link/index');
    }

    public function create()
    {
        return view('panel/link/form', [
            'products' => Product::all()
        ]);
    }

    public function show(Link $link)
    {
        return view('panel/link/show', [
            'link' => $link
        ]);
    }

    public function edit(Link $link)
    {
        return view('panel/link/form', [
            'link' => $link,
            'products' => Product::all(),

        ]);
    }
}
