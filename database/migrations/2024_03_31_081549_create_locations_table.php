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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('street1');
            $table->string('street2')->nullable();
            $table->string('country');
            $table->string('city');
            $table->decimal('latitude', 10, 8); // Latitude field
            $table->decimal('longitude', 11, 8); // Longitude field
            $table->unsignedBigInteger('user_id');
            $table->string('parking_type');
            $table->timestamps();

            // Foreign key constraints

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
