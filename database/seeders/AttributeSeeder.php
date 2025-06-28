<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Attribute;
use App\Models\Product;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { {
            $car = Product::where('name', 'Toy Car')->first();
            $truck = Product::where('name', 'Toy Truck')->first();

            $attributes = [
                ['type' => 'size', 'value' => 'Small', 'price' => 0],
                ['type' => 'size', 'value' => 'Big', 'price' => 20],
                ['type' => 'color', 'value' => 'Black', 'price' => 0],
                ['type' => 'color', 'value' => 'White', 'price' => 0],
                ['type' => 'color', 'value' => 'Navy', 'price' => 10],
                ['type' => 'color', 'value' => 'Cyan', 'price' => 10],
                ['type' => 'color', 'value' => 'Red', 'price' => 10],
                ['type' => 'material', 'value' => 'Plastic', 'price' => 0],
                ['type' => 'material', 'value' => 'Aluminium', 'price' => 20],
            ];

            foreach ($attributes as $attr) {
                Attribute::create(array_merge($attr, ['product_id' => $car->id]));
                Attribute::create(array_merge($attr, ['product_id' => $truck->id]));
            }
        }
    }
}
