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
        Schema::table('orders', function (Blueprint $table) {
            // Change order_status from enum to string to avoid truncation issues
            $table->string('order_status', 20)->change();
            // Change payment_status from enum to string as well
            $table->string('payment_status', 20)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('order_status', ['pending', 'diproses', 'done', 'cancelled'])->default('pending')->change();
            $table->enum('payment_status', ['unpaid', 'paid', 'expired', 'failed'])->default('unpaid')->change();
        });
    }
};
