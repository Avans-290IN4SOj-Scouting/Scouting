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
        Schema::create('order_lines', function (Blueprint $table) {
            $table->id();

            $table->integer('amount');
            $table->double('product_price');
            $table->string('product_size');
            $table->foreignId('order_id')->constrained(table: 'orders', indexName:'order_id');
            $table->foreignId('product_id')->constrained(table: 'products', indexName:'product_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_lines');
    }
};
