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
        Schema::create('testing_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('student_name');
            $table->foreignId('exam_id');
            $table->foreignId('test_id');
            $table->foreignId('testing_session_settings_id');
            $table->foreignId('user_id')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testing_sessions');
    }
};
