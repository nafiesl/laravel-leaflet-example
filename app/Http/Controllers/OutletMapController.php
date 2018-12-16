<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OutletMapController extends Controller
{
    public function index(Request $request)
    {
        return view('outlets.map');
    }
}
