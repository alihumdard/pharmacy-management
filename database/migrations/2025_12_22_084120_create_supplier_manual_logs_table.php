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
      Schema::create('supplier_manual_logs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
    $table->string('reference_no');
    $table->decimal('amount', 15, 2);
    $table->enum('type', ['debit', 'credit']); // debit = payment sent, credit = new debt
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
        Schema::dropIfExists('supplier_manual_logs');
    }
};
