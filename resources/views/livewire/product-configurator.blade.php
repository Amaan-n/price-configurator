@extends('components.layouts.app')

@section('content')
<div>
    <h2 class="text-xl font-bold mb-4">Product Configurator</h2>

    <!-- User Type Toggle -->
    <div class="mb-4">
        <label>User Type:</label>
        <select wire:model="userType" class="border p-2">
            <option value="normal">Normal</option>
            <option value="company">Company</option>
        </select>
    </div>

    <!-- Product Selection -->
    <div class="mb-6">
        <label>Select Products:</label>
        @foreach ($products as $product)
            <div class="border p-3 my-2">
                <label>
                    <input type="checkbox" wire:model="selectedProducts" value="{{ $product->id }}">
                    {{ $product->name }} (Base: {{ $product->base_price }} KD)
                </label>

                @if(in_array($product->id, $selectedProducts))
                    <div class="ml-4 mt-2">
                        @foreach (['size', 'color', 'material'] as $type)
                            <label class="block">
                                {{ ucfirst($type) }}:
                                <select wire:model="selectedAttributes.{{ $product->id }}.{{ $type }}" class="border p-1">
                                    <option value="">-- Choose {{ $type }} --</option>
                                    @foreach ($product->attributes->where('type', $type) as $attr)
                                        <option value="{{ $attr->value }}">
                                            {{ $attr->value }} (+{{ $attr->price }} KD)
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>

        
    @foreach ($priceDetails as $productId => $detail)
        <div class="border p-4 mb-4 bg-white shadow">
            <h3 class="font-semibold">{{ $detail['name'] }}</h3>
            <ul class="text-sm">
                <li>Base Price: {{ $detail['base_price'] }} KD</li>
                <li>Attribute Additions: {{ $detail['attribute_price'] }} KD</li>
                <li>Selected Attributes:
                    <ul class="ml-4 list-disc">
                        @foreach ($detail['attributes'] as $attr)
                            <li>{{ $attr }}</li>
                        @endforeach
                    </ul>
                </li>
                <li>Discounts:
                    <ul class="ml-4 list-disc">
                        @forelse ($detail['discounts'] as $desc)
                            <li>{{ $desc }}</li>
                        @empty
                            <li>No discounts applied</li>
                        @endforelse
                    </ul>
                </li>
                <li><strong>Final Price: {{ $detail['final_price'] }} KD</strong></li>
            </ul>
        </div>
    @endforeach
</div>
@endsection