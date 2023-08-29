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
        Schema::create('products', function (Blueprint $table) {
            $table->id();            
            $table->unsignedBigInteger('links_id')->unique();
            $table->string('name')->nullable();
            $table->mediumText('description')->nullable();
            $table->string('price')->nullable();
            $table->string('image')->nullable();
            $table->string('image_link')->nullable();
            $table->unsignedBigInteger('website_id');
            $table->timestamps();


            // Foreign key constraints
            $table->foreign('website_id')->references('id')->on('websites')->onDelete('cascade');
            $table->foreign('links_id')->references('id')->on('scraped_links')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
