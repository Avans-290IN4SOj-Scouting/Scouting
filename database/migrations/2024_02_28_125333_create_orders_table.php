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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->dateTime('order_date');
            $table->string('email');
            $table->string('lid_name');
            $table->string('postal_code');
            $table->integer('house_number');
            $table->string('house_number_addition')->nullable();
            $table->string('streetname');
            $table->string('cityname');

            $table->unsignedBigInteger('group_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
