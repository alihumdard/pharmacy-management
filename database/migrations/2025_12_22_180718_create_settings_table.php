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
    Schema::create('settings', function (Blueprint $table) {
        $table->id();
        $table->string('pharmacy_name')->nullable();
        $table->string('user_name')->nullable(); // Sidebar ke liye
        $table->string('phone_number')->nullable();
        $table->string('email')->nullable();
        $table->string('tax_id')->nullable();
        $table->text('address')->nullable();
        $table->string('logo')->nullable(); // Image path
        $table->string('currency', 10)->default('PKR');
        $table->integer('tax_rate')->default(17);
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
        Schema::dropIfExists('settings');
    }
};
