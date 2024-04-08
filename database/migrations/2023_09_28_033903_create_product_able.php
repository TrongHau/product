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
        Schema::create('product_able', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->index();
            $table->string('product_able_type', 255);
            $table->integer('product_ables_id')->index();
            $table->integer('cost');
            $table->integer('price');
            $table->integer('price_floor')->nullable();
            $table->integer('count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_able');
    }
};
