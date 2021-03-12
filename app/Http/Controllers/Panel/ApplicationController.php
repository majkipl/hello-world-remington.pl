<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index()
    {
        return view('panel/application/index');
    }

    public function show(Request $request, int $id)
    {
        $application = Application::with(['whence','shop','product'])->where('id','=',$id)->first();

        return view('panel/application/show', [
            'application' => $application
        ]);
    }
}
