<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory 
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Gear',
            'Clothing',
            'Shoes',
            'Diapering',
            'Feeding',
            'Bath',
            'Toys',
            'Nursery',
            'Household',
            'Grocery'
        ]);
    
        $file = UploadedFile::fake()->image('category.png', 600, 600);
    
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraph,
            'cover' => $file->store('categories', ['disk' => 'public']),
            'status' => 1
        ];
    }
}
