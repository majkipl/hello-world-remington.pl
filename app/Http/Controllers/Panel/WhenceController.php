<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Whence;

class WhenceController extends Controller
{
    public function index()
    {
        return view('panel/whence/index');
    }

    public function create()
    {
        return view('panel/whence/form', []);
    }

    public function show(Whence $whence)
    {
        return view('panel/whence/show', [
            'whence' => $whence
        ]);
    }

    public function edit(Whence $whence)
    {
        return view('panel/whence/form', [
            'whence' => $whence
        ]);
    }
}
