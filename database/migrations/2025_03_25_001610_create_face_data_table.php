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
        Schema::create('face_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('angle')->comment('0=front, 1=left, 2=right, 3=up, 4=down');
            $table->string('image_path');
            $table->decimal('quality_score', 5, 2);
            $table->json('descriptor')->comment('Face descriptor data for recognition');
            $table->timestamps();

            // Indexes
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('face_data');
    }
};
