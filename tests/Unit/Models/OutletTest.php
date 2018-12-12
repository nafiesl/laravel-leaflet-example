<?php

namespace Tests\Unit\Models;

use App\User;
use App\Outlet;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\BrowserKitTest as TestCase;

class OutletTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_outlet_has_name_link_attribute()
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
    public function a_outlet_has_belongs_to_creator_relation()
    {
        $outlet = factory(Outlet::class)->make();

        $this->assertInstanceOf(User::class, $outlet->creator);
        $this->assertEquals($outlet->creator_id, $outlet->creator->id);
    }
}
