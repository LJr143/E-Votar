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
        Schema::create('backup_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('backup_schedule_id')->constrained('backup_schedules')->onDelete('cascade');
            $table->string('file_path');
            $table->unsignedBigInteger('file_size');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backup_files');
    }
};
