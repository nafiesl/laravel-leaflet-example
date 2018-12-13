<?php

namespace App\Http\Controllers\Api;

use App\Outlet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OutletCollection;

class OutletController extends Controller
{
    public function index(Request $request)
    {
        $outlets = Outlet::all();

        return new OutletCollection($outlets);
    }
}
