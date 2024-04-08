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
        Schema::create('enter_warehouse', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->index();
            $table->integer('warehouse_id')->index();
            $table->integer('supplier_id')->index();
            $table->string('code_receipt', 255)->nullable()->index();
            $table->string('shipment', 255)->nullable()->index();
            $table->date('purchase_date')->nullable();
            $table->date('expired_date')->nullable();
            $table->date('receipt_created_date')->nullable()->index();
            $table->boolean('status')->default(1);
            $table->text('note')->nullable()->default(null);;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enter_warehouse');
    }
};
