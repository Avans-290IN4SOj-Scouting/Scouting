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
            $table->timestamp('order_date')->nullable();
            $table->string('email');
            $table->string('lid_name');
            $table->foreignId('order_status_id')->constrained(table:'order_statuses', indexName:'order_status_id');
            $table->foreignId('user_id')->constrained(table: 'users', indexName:'user_id');
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
