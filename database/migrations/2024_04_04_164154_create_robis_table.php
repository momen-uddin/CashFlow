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
        Schema::create('robis', function (Blueprint $table) {
            $table->id();
            $table->string('packName');
            $table->string('title');
            $table->integer('price');
            $table->integer('validity');
            $table->integer('offerEndsIn')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('robis');
    }
};
