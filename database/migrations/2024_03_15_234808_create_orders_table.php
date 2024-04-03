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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id', 8);
            $table->string('email', 255);
            $table->string('payment_method', 255);
            $table->string('order_number', 16);
            $table->decimal('total', 10, 1);
            $table->boolean('delivery_type');
            $table->boolean('payment_done')->default(false);
            $table->boolean('has_dispatched')->default(false);
            $table->boolean('has_completed')->default(false);
            $table->boolean('has_cancle')->default(false);
            $table->timestamp('completed_on')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
