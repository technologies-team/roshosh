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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Assuming 'title' is a string field
            $table->string('title_ar')->nullable();// Assuming 'title' is a string field
            $table->unsignedBigInteger('photo_id')->nullable(); // Assuming 'photo_id' is a foreign key referencing another table
            $table->foreign('photo_id')->references('id')->on('attachments')->onDelete('restrict');
            $table->unsignedBigInteger('parent_id')->nullable(); // Assuming 'parent_id' is a foreign key referencing another record in the same table
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
