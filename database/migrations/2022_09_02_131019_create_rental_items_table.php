<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category')->nullable();
            $table->string('quantity')->nullable();
            $table->double('amount', 15, 2);
            $table->double('rent_quantity', 15, 2);
            $table->enum('status', [0, 1])->default(1);
            $table->text('description');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('rental_id');
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
        Schema::dropIfExists('rental_items');
    }
}
