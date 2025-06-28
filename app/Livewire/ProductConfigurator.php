<?php

namespace App\Livewire;

use App\Models\Discountable;
use Livewire\Component;
use App\Models\Product;
use App\Models\Attribute;


class ProductConfigurator extends Component
{
    public $products;
    public $selectedProducts = [];
    public $selectedAttributes = [];
    public $userType = 'normal';

    public $priceDetails = [];

    public function mount()
    {
        $this->products = Product::with('attributes')->get();
    }

    public function updated()
    {
        $this->calculatePrice();
    }

    public function calculatePrice()
    {
        $this->priceDetails = [];

        foreach ($this->selectedProducts as $productId) {
            $product = Product::find($productId);
            $basePrice = $product->base_price;
            $attributeAdditions = 0;
            $attributeDescriptions = [];


            $productAttrs = collect($this->selectedAttributes[$productId] ?? []);

            foreach ($productAttrs as $type => $value) {
                $attr = Attribute::where([
                    ['product_id', $productId],
                    ['type', $type],
                    ['value', $value],
                ])->first();

                if ($attr) {
                    $attributeAdditions += $attr->price;
                    $attributeDescriptions[] = "$type: $value (+{$attr->price})";
                }
            }

            $subtotal = $basePrice + $attributeAdditions;
            $discounts = Discountable::all();
            $discountTotal = 0;
            $discountDescriptions = [];

            foreach ($discounts as $rule) {
                if ($rule->type == 'attribute') {
                    parse_str(str_replace(';', '&', $rule->condition), $conds);
                    if (isset($conds['type'], $conds['value']) && ($productAttrs[$conds['type']] ?? null) === $conds['value']) {
                        $amount = $rule->value_type === 'flat' ? $rule->value : $subtotal * ($rule->value / 100);
                        $discountTotal += $amount;
                        $discountDescriptions[] = "{$rule->value}" . ($rule->value_type === 'percent' ? '%' : ' KD') . " off for {$conds['type']} = {$conds['value']}";
                    }
                } elseif ($rule->type == 'total' && $subtotal > (float) filter_var($rule->condition, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION)) {
                    $amount = $rule->value_type === 'flat' ? $rule->value : $subtotal * ($rule->value / 100);
                    $discountTotal += $amount;
                    $discountDescriptions[] = "{$rule->value}" . ($rule->value_type === 'percent' ? '%' : ' KD') . " off for subtotal {$rule->condition}";
                } elseif ($rule->type == 'user_type' && $this->userType === $rule->condition) {
                    $amount = $rule->value_type === 'flat' ? $rule->value : $subtotal * ($rule->value / 100);
                    $discountTotal += $amount;
                    $discountDescriptions[] = "{$rule->value}" . ($rule->value_type === 'percent' ? '%' : ' KD') . " off for user type = {$this->userType}";
                }
            }

            $finalPrice = $subtotal - $discountTotal;

            $this->priceDetails[$productId] = [
                'name' => $product->name,
                'base_price' => $basePrice,
                'attribute_price' => $attributeAdditions,
                'discounts' => $discountDescriptions,
                'final_price' => $finalPrice,
                'attributes' => $attributeDescriptions
            ];
        }
    }

    public function render()
    {
        return view('livewire.product-configurator');
    }
}
