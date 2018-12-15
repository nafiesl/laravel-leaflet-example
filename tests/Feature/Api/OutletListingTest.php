<?php

namespace Tests\Feature\Api;

use App\Outlet;
use Tests\BrowserKitTest as TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OutletListingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_retrieve_outlet_list()
    {
        $outlet = factory(Outlet::class)->create();

        $this->getJson(route('api.outlets.index'));

        $this->seeJsonSubset([
            'type'     => 'FeatureCollection',
            'features' => [
                [
                    'type'       => 'Feature',
                    'properties' => [
                        'name'       => $outlet->name,
                        'address'    => $outlet->address,
                        'coordinate' => $outlet->coordinate,
                    ],
                    'geometry'   => [
                        'type'        => 'Point',
                        'coordinates' => [
                            $outlet->longitude,
                            $outlet->latitude,
                        ],
                    ],
                ],
            ],
        ]);
    }
}
