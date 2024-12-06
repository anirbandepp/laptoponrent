<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->date('subscription_date');
            $table->date('subscription_date_end')->nullable();
            $table->string('time_period');
            $table->unsignedBigInteger('customer_id');
            $table->double('total_amount', 15,2);
            $table->enum('status', ['Pending', 'Active', 'Cancelled', 'Suspended'])->default('Pending');
            $table->double('deposit_amount', 15, 2)->nullable();
            $table->string('unique_rental_id')->nullable();
            $table->string('agreement_sign')->nullable();
            $table->string('agreement_doc')->nullable();
            $table->string('agreement_status')->nullable();
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
        Schema::dropIfExists('rentals');
    }
}
