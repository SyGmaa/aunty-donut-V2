<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained(); // Keep history even if product deleted? Maybe nullOnDelete or just constrained.
            $table->string('product_name'); // Snapshot of name
            $table->integer('quantity');
            $table->decimal('price_at_time', 10, 2);
            $table->decimal('total_price', 10, 2); // Calculated from qty * price_at_time usually
            $table->json('selected_variants')->nullable()->comment('For bundles: stores list of selected flavors');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
