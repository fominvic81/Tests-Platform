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
            $table->time('time')->nullable();
            $table->boolean('shuffle_questions');
            $table->boolean('shuffle_options');
            $table->boolean('show_result');
            $table->boolean('show_answers');
            $table->integer('points_min')->unsigned();
            $table->integer('points_max')->unsigned();
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
