<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Customer;
use App\Models\Province;
use App\Models\Country;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customer = Customer::factory()->create();
        $province = Province::factory()->create();
        $country = Country::factory()->create();
        return [
            'alias' => fake()->word,
            'address_1' => fake()->streetAddress,
            'address_2' => null,
            'zip' => fake()->postcode,
            'city' => fake()->city,
            'province_id' => $province->id,
            'country_id' => $country->id,
            'customer_id' => $customer->id,
            'status' => 1
        ];
    }
}
