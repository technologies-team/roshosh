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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('total_price');
            $table->string('total_rewards')->nullable();
            $table->string('total_discount')->default(0);
            $table->string('total_fee')->default(0);
            $table->unsignedBigInteger("user_id");
            $table->string('status')->default('initial');
            $table->string('notes')->default('');
            $table->string('payment_method');
            $table->timestamps();
            $table->foreign("user_id")->references("id")->on("users")->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
