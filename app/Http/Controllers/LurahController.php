<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LurahController extends Controller
{
    public function dashboard()
    {
        return view('lurah.dashboard');
    }
}
