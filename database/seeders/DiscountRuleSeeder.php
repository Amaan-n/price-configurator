<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Discountable;


class DiscountRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { {
            Discountable::insert([
                ['type' => 'attribute', 'condition' => 'size=Small', 'value' => 5, 'value_type' => 'percent'],
                ['type' => 'total', 'condition' => '>200', 'value' => 10, 'value_type' => 'flat'],
                ['type' => 'user_type', 'condition' => 'company', 'value' => 20, 'value_type' => 'percent'],
                ['type' => 'attribute', 'condition' => 'color=Black', 'value' => 10, 'value_type' => 'percent'],
            ]);
        }
    }
}
