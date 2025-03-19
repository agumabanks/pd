<?php

 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Adjust to your table name (it’s "orders" in your DB).
        Schema::table('orders', function (Blueprint $table) {
            // If you already have a status column that’s a string, you can skip this.
            // Otherwise, add if needed:
            $table->string('status')->default('Draft')->change();
        });
    }

    public function down()
    {
        // You could revert the column here if needed
    }
};

