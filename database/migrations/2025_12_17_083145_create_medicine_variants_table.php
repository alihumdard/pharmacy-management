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
       Schema::create('medicine_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_id')->constrained()->onDelete('cascade');
            $table->string('sku')->unique();
            $table->string('strength')->nullable();
            $table->string('pack_size')->nullable();
            $table->string('barcode')->nullable();
            $table->decimal('purchase_price', 12, 2)->default(0);
            $table->decimal('sale_price', 12, 2)->default(0);
            $table->integer('stock_level')->default(0);
            $table->integer('reorder_level')->default(5);
            $table->string('batch_no')->nullable();
            $table->date('expiry_date')->nullable();
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
       Schema::dropIfExists('medicine_variants');
    }
};
