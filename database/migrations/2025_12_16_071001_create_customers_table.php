<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('phone_number')->unique();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->decimal('credit_balance', 10, 2)->default(0.00); // PKR 5,000.00 in the example
            $table->integer('total_purchases')->default(0); // For the '10 Orders' example
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};