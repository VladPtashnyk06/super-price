<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('order_status_id')->constrained('order_statuses');
            $table->foreignId('delivery_method_id')->constrained('delivery_methods');
            $table->foreignId('payment_method_id')->constrained('payment_methods');
            $table->foreignId('delivery_address_id')->constrained('delivery_addresses');
            $table->integer('total_price');
            $table->text('comment');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};