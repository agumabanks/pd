<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->date('requested_date');
            $table->date('promised_date')->nullable();
            
            // You can store statuses like "Pending", "Acknowledged", "Partially Fulfilled", etc.
            $table->string('status')->default('Pending');  

            // Optional fields
            $table->string('remarks')->nullable();
            $table->integer('quantity')->nullable(); // If relevant
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};
