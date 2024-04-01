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
        Schema::create('cust_receives', function (Blueprint $table) {
            $table->id()->autoIncrement()->unique();
            $table->unsignedBigInteger('cust_id');
            $table->foreign('cust_id')->references('id')->on('users');
            $table->string('cust_name')->nullable();
            $table->string('amount');
            $table->string('transaction_type')->nullable();
            $table->string('transaction_id')->nullable()->unique();
            $table->string('transDate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cust_receives');
    }
};
