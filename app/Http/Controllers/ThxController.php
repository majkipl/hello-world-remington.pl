<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThxController extends Controller
{
    public function form(Request $request)
    {
        $id = $request->session()->get('application_id');
        $request->session()->forget('application_id');
        return view('thx/form', [
            'id' => $id
        ]);
    }
}
