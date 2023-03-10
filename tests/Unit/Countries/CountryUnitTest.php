<?php

namespace Tests\Unit\Countries;

use App\Repositories\Countries\CountryRepository;
use App\Models\Province;
use App\Models\Country;
use App\Models\State;
use Illuminate\Support\Collection;
use Tests\TestCase;

class CountryUnitTest extends TestCase
{
    /** @test */
    public function it_can_list_states()
    {
        $country = Country::factory()->create([
            'iso' => 'US'
        ]);

        $usState = State::factory()->create([
            'country_id' => $country->id
        ]);

        $countryRepo = new CountryRepository($country);
        $states = $countryRepo->listStates();

        $this->assertInstanceOf(Collection::class, $states);

        $states->each(function ($state) use ($usState) {
            $this->assertEquals($state->state, $usState->state);
        });

    }

    /** @test */
    public function it_can_create_the_country()
    {
        $data = [
            'name' => fake()->unique()->country,
            'iso' => fake()->unique()->countryISOAlpha3,
            'iso3' => fake()->unique()->countryISOAlpha3,
            'numcode' => fake()->randomDigit,
            'phonecode' => fake()->randomDigit,
            'status' => 1
        ];

        $countryRepo = new CountryRepository(new Country);
        $country = $countryRepo->createCountry($data);

        $this->assertEquals($data['name'], $country->name);
        $this->assertEquals($data['iso'], $country->iso);
        $this->assertEquals($data['iso3'], $country->iso3);
        $this->assertEquals($data['numcode'], $country->numcode);
        $this->assertEquals($data['phonecode'], $country->phonecode);
        $this->assertEquals($data['status'], $country->status);
    }
    
    /** @test */
    public function it_errors_when_updating_the_country()
    {
        $country = Country::factory()->create();
        $this->expectException(\Exception::class);

        $countryRepo = new CountryRepository($country);
        $countryRepo->updateCountry(['name' => null]);
    }
    
    /** @test */
    public function it_can_update_the_country()
    {
        $country = Country::factory()->create();

        $countryRepo = new CountryRepository($country);

        $update = ['name' => 'Zimbabwe'];
        $countryRepo->updateCountry($update);

        $this->assertEquals('Zimbabwe', $country->name);
    }
    
    /** @test */
    public function it_can_find_the_provinces_associated_with_the_country()
    {
        $country = Country::factory()->create();
        $prov = Province::factory()->create(['country_id' => $country->id]);
        $country->provinces()->save($prov);

        $countryRepo = new CountryRepository($country);
        $provinces = $countryRepo->findProvinces();

        foreach ($provinces as $province) {
            $this->assertEquals($prov->id, $province->id);
        }
    }
    
    /** @test */
    public function it_errors_when_the_country_is_not_found()
    {
        $this->expectException(\Exception::class);

        $countryRepo = new CountryRepository(new Country);
        $countryRepo->findCountryById(999);
    }
    
    /** @test */
    public function it_can_find_the_country()
    {
        $country = Country::factory()->create();
        $countryRepo = new CountryRepository($country);

        $found = $countryRepo->findCountryById($country->id);

        $this->assertEquals($country->name, $found->name);
    }

    /** @test */
    public function it_can_list_all_countries()
    {
        $country = Country::factory()->create();

        $countryRepo = new CountryRepository($country);
        $this->assertCount(1, $countryRepo->listCountries());
    }
}
