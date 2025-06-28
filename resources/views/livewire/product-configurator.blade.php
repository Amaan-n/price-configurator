@extends('components.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-gray-100 rounded shadow-sm">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">🧮 Product Configurator</h2>

    <!-- User Type Toggle -->
    <div class="mb-6">
        <label class="block font-medium text-gray-700 mb-1">User Type:</label>
        <select wire:model="userType" class="border-gray-300 rounded p-2 w-full shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            <option value="normal">Normal</option>
            <option value="company">Company</option>
        </select>
    </div>

    <!-- Product Selection -->
    <div class="mb-8">
        <label class="block font-medium text-gray-700 mb-2">Select Products:</label>
        @foreach ($products as $product)
            <div class="border p-4 mb-4 bg-white rounded shadow-sm">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" wire:model="selectedProducts" value="{{ $product->id }}" class="form-checkbox text-orange-500">
                    <span class="text-lg font-semibold text-gray-800">{{ $product->name }} <span class="text-sm text-gray-500">(Base: {{ $product->base_price }} KD)</span></span>
                </label>
                
                @if(in_array($product->id, $selectedProducts))
                    <div class="ml-6 mt-4 space-y-4">
                        @foreach (['size', 'color', 'material'] as $type)
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">
                                    {{ ucfirst($type) }}:
                                </label>
                                <select wire:model="selectedAttributes.{{ $product->id }}.{{ $type }}" class="border-gray-300 rounded p-2 w-full shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                                    <option value="">-- Choose {{ $type }} --</option>
                                   @foreach ($product->attributes->where('type', $type) as $attr)
                                        <option value="{{ $attr->value }}">
                                            {{ $attr->value }} (+{{ $attr->price }} KD)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Price Breakdown -->
    @foreach ($priceDetails as $productId => $detail)
        <div class="border-l-4 border-orange-400 bg-white p-6 mb-6 shadow rounded">
            <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $detail['name'] }}</h3>
            <ul class="text-sm text-gray-700 space-y-1">
                <li>💰 Base Price: <strong>{{ $detail['base_price'] }} KD</strong></li>
                <li>➕ Attribute Additions: <strong>{{ $detail['attribute_price'] }} KD</strong></li>
                <li>🎨 Selected Attributes:
                    <ul class="ml-6 list-disc text-gray-600">
                        @foreach ($detail['attributes'] as $attr)
                            <li>{{ $attr }}</li>
                        @endforeach
                    </ul>
                </li>
                <li>🏷️ Discounts:
                    <ul class="ml-6 list-disc text-gray-600">
                        @forelse ($detail['discounts'] as $desc)
                            <li>{{ $desc }}</li>
                        @empty
                            <li>No discounts applied</li>
                        @endforelse
                    </ul>
                </li>
                <li class="text-lg font-bold text-green-600 mt-2">✅ Final Price: {{ $detail['final_price'] }} KD</li>
            </ul>
        </div>
    @endforeach
</div>
@endsection