<?php

namespace Tests\Feature\Api;

use App\Outlet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BrowserKitTest as TestCase;

class OutletListingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_retrieve_outlet_list()
    {
        $outlet = factory(Outlet::class)->create();

        $this->getJson(route('api.outlets.index'));

        $this->seeJsonContains([
            'type'     => 'FeatureCollection',
            'features' => [
                [
                    'type'       => 'Feature',
                    'properties' => [
                        'name'              => $outlet->name,
                        'address'           => $outlet->address,
                        'coordinate'        => $outlet->coordinate,
                        'latitude'          => (string) $outlet->latitude,
                        'longitude'         => (string) $outlet->longitude,
                        'map_popup_content' => $outlet->map_popup_content,
                        'creator_id'        => (string) $outlet->creator_id,
                        'id'                => $outlet->id,
                        'created_at'        => $outlet->created_at,
                        'updated_at'        => $outlet->updated_at,
                    ],
                    'geometry'   => [
                        'type'        => 'Point',
                        'coordinates' => [
                            (string) $outlet->longitude,
                            (string) $outlet->latitude,
                        ],
                    ],
                ],
            ],
        ]);
    }
}
