<?php

namespace Tests\Unit\Provinces;

use App\Models\Country;
use App\Models\Province;
use App\Repositories\Provinces\ProvinceRepository;
use App\Models\City;
use Tests\TestCase;

class ProvincesUnitTest extends TestCase
{
    /** @test */
    public function it_should_show_the_country_of_the_province()
    {
        $country = Country::factory()->create();
        $province = Province::factory()->create([
            'country_id' => $country->id
        ]);

        $repo = new ProvinceRepository($province);
        $found = $repo->findCountry();

        $this->assertInstanceOf(Country::class, $found);
        $this->assertEquals($country->name, $found->name);
    }

    /** @test */
    public function it_error_updating_the_province_without_the_country()
    {
        $this->expectException(\Exception::class);

        $province = Province::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'country_id' => null
        ];

        $repo = new ProvinceRepository($province);
        $repo->updateProvince($data);
    }

    /** @test */
    public function it_can_list_cities()
    {
        $province = Province::factory()->create();
        $city = City::factory()->create([
            'province_id' => $province->id
        ]);
        $repo = new ProvinceRepository(new Province());
        $collection = $repo->listCities($province->id);

        $collection->each(function ($item) use ($city) {
            $this->assertEquals($item->name, $city->name);
        });
    }

    /** @test */
    public function it_can_update_the_province()
    {
        $province = Province::factory()->create();

        $data = [
            'name' => $this->faker->name
        ];

        $repo = new ProvinceRepository($province);
        $repo->updateProvince($data);

        $this->assertEquals($data['name'], $province->name);
    }

    /** @test */
    public function it_can_show_the_province()
    {
        $province = Province::factory()->create();
        $provinceRepo = new ProvinceRepository(new Province);
        $found = $provinceRepo->findProvinceById($province->id);

        $this->assertEquals($province->name, $found->name);
    }

    /** @test */
    public function it_can_list_all_the_cities_within_the_province()
    {
        $province = Province::factory()->create();

        $city = new City(['name' => $this->faker->city]);
        $city->province()->associate($province);
        $province->cities()->save($city);
        $cities = $province->cities()->get();

        $this->assertCount(1, $cities);
    }

    /** @test */
    public function it_can_list_all_the_provinces()
    {
        Province::factory(5)->create();
        $provinceRepo = new ProvinceRepository(new Province);
        $provinces = $provinceRepo->listProvinces();

        foreach ($provinces as $province) {
            $this->assertDatabaseHas('provinces', ['name' => $province->name]);
        }
    }
}
