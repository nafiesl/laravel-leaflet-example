<?php

namespace Tests\Feature;

use App\Outlet;
use Tests\BrowserKitTest as TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ManageOutletTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_see_outlet_list_in_outlet_index_page()
    {
        $outlet = factory(Outlet::class)->create();

        $this->loginAsUser();
        $this->visitRoute('outlets.index');
        $this->see($outlet->name);
    }

    private function getCreateFields(array $overrides = [])
    {
        return array_merge([
            'name'      => 'Outlet 1 name',
            'address'   => 'Outlet 1 address',
            'latitude'  => '-3.333333',
            'longitude' => '114.583333',
        ], $overrides);
    }

    /** @test */
    public function user_can_create_a_outlet()
    {
        $this->loginAsUser();
        $this->visitRoute('outlets.index');

        $this->click(__('outlet.create'));
        $this->seeRouteIs('outlets.create');

        $this->submitForm(__('outlet.create'), $this->getCreateFields());

        $this->seeRouteIs('outlets.show', Outlet::first());

        $this->seeInDatabase('outlets', $this->getCreateFields());
    }

    /** @test */
    public function validate_outlet_name_is_required()
    {
        $this->loginAsUser();

        // name empty
        $this->post(route('outlets.store'), $this->getCreateFields(['name' => '']));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_outlet_name_is_not_more_than_60_characters()
    {
        $this->loginAsUser();

        // name 70 characters
        $this->post(route('outlets.store'), $this->getCreateFields([
            'name' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_outlet_address_is_not_more_than_255_characters()
    {
        $this->loginAsUser();

        // address 256 characters
        $this->post(route('outlets.store'), $this->getCreateFields([
            'address' => str_repeat('Long outlet address', 16),
        ]));
        $this->assertSessionHasErrors('address');
    }

    private function getEditFields(array $overrides = [])
    {
        return array_merge([
            'name'      => 'Outlet 1 name',
            'address'   => 'Outlet 1 address',
            'latitude'  => '-3.333333',
            'longitude' => '114.583333',
        ], $overrides);
    }

    /** @test */
    public function user_can_edit_a_outlet()
    {
        $this->loginAsUser();
        $outlet = factory(Outlet::class)->create(['name' => 'Testing 123']);

        $this->visitRoute('outlets.show', $outlet);
        $this->click('edit-outlet-'.$outlet->id);
        $this->seeRouteIs('outlets.edit', $outlet);

        $this->submitForm(__('outlet.update'), $this->getEditFields());

        $this->seeRouteIs('outlets.show', $outlet);

        $this->seeInDatabase('outlets', $this->getEditFields([
            'id' => $outlet->id,
        ]));
    }

    /** @test */
    public function validate_outlet_name_update_is_required()
    {
        $this->loginAsUser();
        $outlet = factory(Outlet::class)->create(['name' => 'Testing 123']);

        // name empty
        $this->patch(route('outlets.update', $outlet), $this->getEditFields(['name' => '']));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_outlet_name_update_is_not_more_than_60_characters()
    {
        $this->loginAsUser();
        $outlet = factory(Outlet::class)->create(['name' => 'Testing 123']);

        // name 70 characters
        $this->patch(route('outlets.update', $outlet), $this->getEditFields([
            'name' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_outlet_address_update_is_not_more_than_255_characters()
    {
        $this->loginAsUser();
        $outlet = factory(Outlet::class)->create(['name' => 'Testing 123']);

        // address 256 characters
        $this->patch(route('outlets.update', $outlet), $this->getEditFields([
            'address' => str_repeat('Long outlet address', 16),
        ]));
        $this->assertSessionHasErrors('address');
    }

    /** @test */
    public function user_can_delete_a_outlet()
    {
        $this->loginAsUser();
        $outlet = factory(Outlet::class)->create();
        factory(Outlet::class)->create();

        $this->visitRoute('outlets.edit', $outlet);
        $this->click('del-outlet-'.$outlet->id);
        $this->seeRouteIs('outlets.edit', [$outlet, 'action' => 'delete']);

        $this->press(__('app.delete_confirm_button'));

        $this->dontSeeInDatabase('outlets', [
            'id' => $outlet->id,
        ]);
    }
}
