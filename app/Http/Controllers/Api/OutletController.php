<?php

namespace App\Http\Controllers\Api;

use App\Outlet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OutletCollection;
use App\Http\Resources\Outlet as OutletResource;

class OutletController extends Controller
{
    public function index(Request $request)
    {
        $outlets = Outlet::all();

        return new OutletCollection($outlets);
    }

    public function geoJSON(Request $request)
    {
        $outlets = Outlet::all();

        $geoJSONdata = $outlets->map(function ($outlet) {
            return [
                'type'       => 'Feature',
                'properties' => new OutletResource($outlet),
                'geometry'   => [
                    'type'        => 'Point',
                    'coordinates' => [
                        $outlet->longitude,
                        $outlet->latitude,
                    ],
                ],
            ];
        });

        return response()->json([
            'type'     => 'FeatureCollection',
            'features' => $geoJSONdata,
        ]);
    }
}
