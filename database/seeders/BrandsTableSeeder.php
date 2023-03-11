<?php
namespace Database\Seeders;
use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    public function run()
    {
        Brand::factory()->create([
            'name' => 'Apple'
        ]);
    }
}