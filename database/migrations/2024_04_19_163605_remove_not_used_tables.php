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
        Schema::dropIfExists('order_statuses');
        Schema::dropIfExists('delivery_statuses');
        Schema::dropIfExists('delivery_states');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
