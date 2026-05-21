<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // No-op.
        // Attendance table schema is defined in:
        //  - 2026_04_23_020000_create_attendance_table.php
        // This migration file exists in the repo historically but creating the
        // table again causes errors like:
        //   SQLSTATE[HY000]: General error: 1 table "attendance" already exists
    }

    public function down(): void
    {
        // No-op.
    }
};

