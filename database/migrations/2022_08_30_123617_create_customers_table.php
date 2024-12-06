<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('rental_for');
            $table->string('companyname')->nullable();
            $table->string('mobile');
            $table->string('email')->unique();
            $table->enum('status',['Active','Inactive','Cancelled'])->default('Inactive');
            $table->string('email_verified')->nullable();
            $table->string('rand_id')->nullable();
            $table->string('password');
            $table->string('address');
            $table->string('city');
            $table->string('postcode');
            $table->string('state');
            $table->string('country');
            $table->string('adhar')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
