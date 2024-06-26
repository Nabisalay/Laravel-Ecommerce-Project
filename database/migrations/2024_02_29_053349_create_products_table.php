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
            $table->string('description', 255);
            $table->decimal('price', 10, 2);
            $table->string('warrenty', 50);
            $table->string('prodImg', 255);
            $table->string('prodCode', 5);
            $table->string('CategoryNo', 2);
            $table->string('prodId', 7);
            $table->boolean('status')->default(true);
            $table->timestamps();
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
