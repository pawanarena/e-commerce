<?php
namespace Database\Seeders;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CategoryProductsTableSeeder extends Seeder
{
    public function run()
    {
        Category::factory(2)->create()->each(function (Category $category) {
            Product::factory(6)->make()->each(function(Product $product) use ($category) {
                $category->products()->save($product);
            });
        });
    }
}