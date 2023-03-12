<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Country>
 */
class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => Str::random(),
            'iso' => fake()->unique()->countryISOAlpha3,
            'iso3' => fake()->unique()->countryISOAlpha3,
            'numcode' => fake()->randomDigit,
            'phonecode' => fake()->randomDigit,
            'status' => 1
        ];
    }
}
