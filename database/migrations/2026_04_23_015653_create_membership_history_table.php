<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gym_member_id')->constrained()->onDelete('cascade');
            $table->string('previous_plan')->nullable();
            $table->string('new_plan');
            $table->decimal('previous_price', 8, 2)->nullable();
            $table->decimal('new_price', 8, 2);
            $table->date('effective_date');
            $table->text('notes')->nullable();
            $table->enum('change_type', ['upgrade', 'downgrade', 'renewal', 'new']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_history');
    }
};
