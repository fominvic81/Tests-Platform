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
        Schema::create('testing_session_settings', function (Blueprint $table) {
            $table->id();
            $table->time('time');
            $table->boolean('shuffle_questions');
            $table->boolean('shuffle_options');
            $table->boolean('show_result');
            $table->integer('points_min');
            $table->integer('points_max');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_settings');
    }
};
