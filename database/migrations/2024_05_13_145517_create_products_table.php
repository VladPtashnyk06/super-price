<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('producer_id')->constrained('producers');
            $table->foreignId('status_id')->constrained('statuses');
            $table->foreignId('package_id')->nullable()->constrained('packages');
            $table->foreignId('material_id')->nullable()->constrained('materials');
            $table->foreignId('characteristic_id')->nullable()->constrained('characteristics');
            $table->string('title');
            $table->text('description');
            $table->integer('code')->unique();
            $table->string('model')->nullable();
            $table->boolean('product_promotion')->default(false);
            $table->boolean('top_product')->default(false);
            $table->integer('rating')->default(5);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
