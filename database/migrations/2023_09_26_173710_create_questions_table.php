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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->text('text');
            $table->string('image')->nullable();
            $table->integer('type')->unsigned();
            $table->integer('points')->unsigned();
            $table->text('explanation')->nullable();
            $table->json('data');
            $table->foreignId('test_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question');
    }
};
