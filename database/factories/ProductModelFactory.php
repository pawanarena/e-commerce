<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = $faker->unique()->sentence;
        $file = UploadedFile::fake()->image('product.png', 600, 600);
        return [
            'sku' => fake()->numberBetween(1111111, 999999),
            'name' => $product,
            'slug' => Str::slug($product),
            'description' => fake()->paragraph,
            'quantity' => 10,
            'price' => 5.00,
            'status' => 1,
            'weight' => 5,
            'cover' => $file->getFilename() . '.'. $file->getClientOriginalExtension(),
            'mass_unit' => config('shop.weight', 'gms')
        ];
    }
}
