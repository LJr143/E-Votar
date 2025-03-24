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
        Schema::create('council_position_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('council_id')->constrained('councils');
            $table->foreignId('position_id')->constrained('positions');
            $table->boolean('separate_by_major')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('council_position_settings');
    }
};
