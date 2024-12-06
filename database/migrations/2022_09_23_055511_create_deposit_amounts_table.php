<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposit_amounts', function (Blueprint $table) {
            $table->id();
            $table->double('deposit_amount', 15, 2)->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('invoice_id');
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
        Schema::dropIfExists('deposit_amounts');
    }
}
