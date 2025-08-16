<?php

namespace App\Http\Controllers\Public;

use Illuminate\Http\Request;

class HomeController {

    public function index()
    {
        return view('index');
    }
}