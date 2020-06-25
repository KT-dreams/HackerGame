<?php

namespace App\Http\Controllers;

class CommandController extends Controller
{
    public function login()
    {
        $data =  request()->json()->all();
        return 'Hello ' . $data['value'];
    }
}