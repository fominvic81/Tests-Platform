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
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id');
            $table->text('text');
            $table->string('image')->nullable();
            $table->boolean('correct')->nullable();
            $table->integer('group')->nullable();
            $table->integer('variant_id')->nullable();
            $table->bigInteger('match_id')->nullable();
            $table->integer('sequence_index')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('options');
    }
};
