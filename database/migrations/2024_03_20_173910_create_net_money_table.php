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
        Schema::create('netMoneys', function (Blueprint $table) {
            $table->id()->autoIncrement()->unique();
            $table->unsignedBigInteger('agent_id');
            $table->foreign('agent_id')->references('id')->on('users');
            $table->string('agent_name');
            $table->string('amount');
            $table->string('transaction_type')->nullable();
            $table->string('transaction_id')->nullable()->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('netMoneys');
    }
};
