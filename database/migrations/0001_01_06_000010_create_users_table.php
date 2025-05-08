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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->longText('first_name');
            $table->longText('last_name');
            $table->string('middle_initial')->nullable();
            $table->string('extension')->nullable();
            $table->string('gender');
            $table->date('birth_date');
            $table->string('email', 512)->unique();
            $table->longText('google_id')->nullable();
            $table->string('phone_number', 512)->unique();
            $table->string('year_level');
            $table->string('student_id', 512)->unique();
            $table->foreignId('campus_id')->constrained('campuses');
            $table->foreignId('college_id')->constrained('colleges');
            $table->foreignId('program_id')->constrained('programs');
            $table->foreignId('program_major_id')->nullable()->constrained('program_majors');
            $table->string('username', 512)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->string('account_status')->default('Pending Verification');
            $table->string('face_descriptor')->nullable();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
