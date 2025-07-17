<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtracolumnToBandwidthCustomerPackages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bandwidth_customer_packages', function (Blueprint $table) {
            $table->string('title_onetime')->nullable();
            $table->string('title_monthly')->nullable();
            $table->string('title_yearly')->nullable();
            $table->string('payment_date_monthly')->nullable();
            $table->string('payment_date_yearly')->nullable();
            $table->string('billing_frequency')->nullable();
            $table->string('installment')->nullable();
            $table->string('installment_date')->nullable();
            $table->foreignId('category_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bandwidth_customer_packages', function (Blueprint $table) {
            //
        });
    }
}
