<?php

namespace Tests\Feature\Admin\Cities;

use App\Models\City;
use App\Models\Country;
use App\Models\Province;
use App\Models\State;
use Tests\TestCase;

class CityFeatureTest extends TestCase
{
    /** @test */
    public function it_can_show_the_edit_page()
    {
        $this->markTestSkipped('Check for L8 compatibility.');

        $country = Country::factory()->create();

        $province = Province::factory()->create([
            'country_id' => $country->id
        ]);

        $state = State::factory()->create();

        $city = City::factory()->create([
            'province_id' => $province->id,
            'state_code' => $state->state_code
        ]);

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.countries.provinces.cities.edit', [$country->id, $province->id, $city->name]))
            ->assertStatus(200)
            ->assertSee($city->name);
    }
    
    /** @test */
    public function it_error_when_the_city_name_is_already_existing()
    {
        $country = Country::factory()->create();
        $province = Province::factory()->create();
        $city = City::factory()->create();
        $city2 = City::factory()->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->put(route('admin.countries.provinces.cities.update', [$country->id, $province->id, $city->id]), ['name' => $city2->name])
            ->assertSessionHasErrors();
    }
}
