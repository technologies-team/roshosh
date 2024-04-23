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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Assuming 'title' is a string field
            $table->string('title_ar')->nullable(); // Assuming 'title_ar' is a string field for Arabic title
            $table->text('description')->nullable(); // Assuming 'description' is a text field
            $table->text('description_ar')->nullable(); // Assuming 'description_ar' is a text field for Arabic description
            $table->decimal('price', 10, 2); // Assuming 'price' is a decimal field
            $table->unsignedBigInteger('category_id'); // Assuming 'category_id' is a foreign key referencing another table
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->unsignedBigInteger('parent_id')->nullable(); // Assuming 'category_id' is a foreign key referencing another table
            $table->foreign('parent_id')->references('id')->on('services')->onDelete('cascade');
            $table->integer('rewards')->nullable(); // Assuming 'rewards' is an integer field
            $table->unsignedBigInteger('photo_id')->nullable(); // Assuming 'photo_id' is a foreign key referencing another table
            $table->foreign('photo_id')->references('id')->on('attachments')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
