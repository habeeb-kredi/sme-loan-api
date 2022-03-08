<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditCustomerKycAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_kycs', function (Blueprint $table) {
            $table->string('nuban')->nullable()->unique()->index();
            $table->integer('client_id')->nullable();
            $table->integer('savings_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_kycs', function (Blueprint $table) {
            $table->dropColumn('nuban');
            $table->dropColumn('client_id');
            $table->dropColumn('savings_id');
        });
    }
}
