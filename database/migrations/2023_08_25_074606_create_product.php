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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->index();
            $table->string('parent', 255)->nullable();
            $table->boolean('status')->default(1);
            $table->string('sku', 25)->nullable();
            $table->string('barcode', 255)->nullable();
            $table->string('weight', 10);
            $table->integer('category_id')->nullable();
            $table->integer('unit_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('user_id')->nullable()->index();
            $table->integer('cost')->index();
            $table->integer('price')->index();
            $table->text('description')->nullable();
            $table->text('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
