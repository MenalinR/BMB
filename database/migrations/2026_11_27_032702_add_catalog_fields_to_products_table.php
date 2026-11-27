<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('category_id')->after('id')->constrained()->cascadeOnDelete();
            $table->string('name')->after('category_id');
            $table->text('description')->nullable()->after('name');
            // Leave empty to show "Ask for price"
            $table->decimal('price', 10, 2)->nullable()->after('description');
            // For rentals, e.g. "per day" or "per event"
            $table->string('price_unit')->nullable()->after('price');
            // Path under public/, e.g. "images/products/guitar.jpg"
            $table->string('image')->nullable()->after('price_unit');
            $table->boolean('is_available')->default(true)->after('image');
            $table->unsignedInteger('sort_order')->default(0)->after('is_available');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
            $table->dropColumn(['name', 'description', 'price', 'price_unit', 'image', 'is_available', 'sort_order']);
        });
    }
};
