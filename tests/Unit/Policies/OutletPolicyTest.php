<?php

namespace Tests\Unit\Policies;

use App\Outlet;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\BrowserKitTest as TestCase;

class OutletPolicyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_create_outlet()
    {
        $user = $this->createUser();
        $this->assertTrue($user->can('create', new Outlet));
    }

    /** @test */
    public function user_can_view_outlet()
    {
        $user = $this->createUser();
        $outlet = factory(Outlet::class)->create();
        $this->assertTrue($user->can('view', $outlet));
    }

    /** @test */
    public function user_can_update_outlet()
    {
        $user = $this->createUser();
        $outlet = factory(Outlet::class)->create();
        $this->assertTrue($user->can('update', $outlet));
    }

    /** @test */
    public function user_can_delete_outlet()
    {
        $user = $this->createUser();
        $outlet = factory(Outlet::class)->create();
        $this->assertTrue($user->can('delete', $outlet));
    }
}
