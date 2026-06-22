<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update any existing 'owner' roles to 'admin'
        DB::table('users')->where('role', 'owner')->update(['role' => 'admin']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This is a data migration, reverse is not practical
    }
};
