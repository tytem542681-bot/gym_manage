<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gym_member_id')->constrained()->onDelete('cascade');
            $table->date('check_in_date');
            $table->time('check_in_time');
            $table->date('check_out_date')->nullable();
            $table->time('check_out_time')->nullable();
            $table->decimal('duration_hours', 4, 2)->nullable();
            $table->string('activity_type')->default('workout');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};
