<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For MySQL, we need to modify the enum to include 'client'
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'staff', 'client') DEFAULT 'client'");
        } else {
            // For other databases, you might need different logic
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['admin', 'staff', 'client'])->default('client')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'staff') DEFAULT 'staff'");
        } else {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['admin', 'staff'])->default('staff')->change();
            });
        }
    }
};
