<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('rental_id')->nullable();
            $table->double('payment', 15, 2);
            $table->enum('payment_status', ['Pending', 'Paid', 'Cancelled'])->default('Pending');
            $table->string('payment_link')->nullable();
            $table->string('payment_link_id')->nullable();
            $table->string('description')->nullable();
            $table->date('payment_paid_date')->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->string('reference_id')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
