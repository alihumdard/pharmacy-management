<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('purchase_order_item_variants', function (Blueprint $table) {
        $table->id();
        $table->foreignId('purchase_order_item_id')->constrained()->onDelete('cascade');
        $table->string('sku');
        $table->string('batch_no')->nullable();
        $table->date('expiry_date')->nullable();
        $table->decimal('purchase_price', 15, 2);
        $table->integer('quantity');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_order_item_variants');
    }
};
