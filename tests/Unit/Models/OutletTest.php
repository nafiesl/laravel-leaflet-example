<?php

namespace Tests\Unit\Models;

use App\Outlet;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BrowserKitTest as TestCase;

class OutletTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_outlet_has_name_link_attribute()
    {
        $outlet = factory(Outlet::class)->create();

        $title = __('app.show_detail_title', [
            'name' => $outlet->name, 'type' => __('outlet.outlet'),
        ]);
        $link = '<a href="'.route('outlets.show', $outlet).'"';
        $link .= ' title="'.$title.'">';
        $link .= $outlet->name;
        $link .= '</a>';

        $this->assertEquals($link, $outlet->name_link);
    }

    /** @test */
    public function an_outlet_has_belongs_to_creator_relation()
    {
        $outlet = factory(Outlet::class)->make();

        $this->assertInstanceOf(User::class, $outlet->creator);
        $this->assertEquals($outlet->creator_id, $outlet->creator->id);
    }

    /** @test */
    public function an_outlet_has_coordinate_attribute()
    {
        $outlet = factory(Outlet::class)->make(['latitude' => '-3.333333', 'longitude' => '114.583333']);
        $this->assertEquals($outlet->latitude.', '.$outlet->longitude, $outlet->coordinate);

        $outlet = factory(Outlet::class)->make(['latitude' => null, 'longitude' => null]);
        $this->assertNull($outlet->coordinate);

        $outlet = factory(Outlet::class)->make(['latitude' => null, 'longitude' => '114.583333']);
        $this->assertNull($outlet->coordinate);
    }

    /** @test */
    public function an_outlet_has_map_popup_content_attribute()
    {
        $outlet = factory(Outlet::class)->create(['latitude' => '-3.333333', 'longitude' => '114.583333']);

        $mapPopupContent = '';
        $mapPopupContent .= '<div class="my-2"><strong>'.__('outlet.name').':</strong><br>'.$outlet->name_link.'</div>';
        $mapPopupContent .= '<div class="my-2"><strong>'.__('outlet.coordinate').':</strong><br>'.$outlet->coordinate.'</div>';

        $this->assertEquals($mapPopupContent, $outlet->map_popup_content);
    }
}
