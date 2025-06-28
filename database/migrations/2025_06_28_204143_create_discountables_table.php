<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('discountables', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['attribute', 'total', 'user_type']);
            $table->string('condition'); // e.g., size=small
            $table->decimal('value', 8, 2); // 10 for flat, 0.05 for 5%
            $table->enum('value_type', ['flat', 'percent']);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discountables');
    }
};
