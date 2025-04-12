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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->nullOnDelete();
            $table->foreignId('election_id')->constrained('elections')->cascadeOnDelete()->nullOnDelete();
            $table->foreignId('election_position_id')->constrained('election_positions')->cascadeOnDelete();
            $table->foreignId('party_list_id')->constrained('party_lists')->cascadeOnDelete();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
