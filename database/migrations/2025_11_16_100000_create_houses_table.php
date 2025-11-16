<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('house_type_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->decimal('price', 12, 2);
            $table->string('address');
            $table->unsignedInteger('bedrooms');
            $table->decimal('size', 8, 2);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('house_type_id');
            $table->index('price');
            $table->index('bedrooms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};
