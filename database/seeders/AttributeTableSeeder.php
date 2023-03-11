<?php
namespace Database\Seeders;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Database\Seeder;

class AttributeTableSeeder extends Seeder
{
    public function run()
    {
        $sizeAttr = Attribute::factory()->create(['name' => 'Size']);
        AttributeValue::factory()->create([
            'value' => 'small',
            'attribute_id' => $sizeAttr->id
        ]);

        AttributeValue::factory()->create([
            'value' => 'medium',
            'attribute_id' => $sizeAttr->id
        ]);

        AttributeValue::factory()->create([
            'value' => 'large',
            'attribute_id' => $sizeAttr->id
        ]);

        $colorAttr = Attribute::factory()->create(['name' => 'Color']);

        AttributeValue::factory()->create([
            'value' => 'red',
            'attribute_id' => $colorAttr->id
        ]);

        AttributeValue::factory()->create([
            'value' => 'yellow',
            'attribute_id' => $colorAttr->id
        ]);

        AttributeValue::factory()->create([
            'value' => 'blue',
            'attribute_id' => $colorAttr->id
        ]);
    }
}