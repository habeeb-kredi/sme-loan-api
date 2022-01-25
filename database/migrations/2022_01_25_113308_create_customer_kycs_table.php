<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerKycsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_kycs', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('phone');
            $table->date('date_of_incorporation')->nullable();
            $table->string('address');
            $table->string('nationality');
            $table->string('rc_number')->nullable();
            $table->string('business_type');
            $table->string('CAC')->nullable();
            $table->string('utility')->nullable();
            $table->string('bank_statement')->nullable();
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
        Schema::dropIfExists('customer_kycs');
    }
}
