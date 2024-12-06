<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('adhar_card')->nullable();
            $table->string('adhar_card_flag')->nullable();
            $table->string('pan_card')->nullable();
            $table->string('pan_card_flag')->nullable();
            $table->string('electricity_bill')->nullable();
            $table->string('electricity_bill_flag')->nullable();
            $table->string('property_tax_bill')->nullable();
            $table->string('property_tax_bill_flag')->nullable();
            $table->string('gst_certificate')->nullable();
            $table->string('corporate_pan_card')->nullable();
            $table->string('office_rental_agreement')->nullable();
            $table->string('incorporation_certificate')->nullable();
            // $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
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
        Schema::dropIfExists('documents');
    }
}
