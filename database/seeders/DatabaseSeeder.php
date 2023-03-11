<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(EmployeesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(CategoryProductsTableSeeder::class);
        $this->call(BrandsTableSeeder::class);
        $this->call(AttributeTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
    }
}
