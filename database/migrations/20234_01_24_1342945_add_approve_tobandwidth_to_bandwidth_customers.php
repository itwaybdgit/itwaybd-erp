<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApproveTobandwidthToBandwidthCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bandwidth_customers', function (Blueprint $table) {
            // $table->foreignId('sales_approve_by')->nullable();
            // $table->foreignId('legal_approve_by')->nullable();
            // $table->foreignId('transmission_approve_by')->nullable();
            // $table->foreignId('noc_approve_by')->nullable();
            // $table->foreignId('noc2_approve_by')->nullable();
            // $table->foreignId('billing_approve_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bandwidth_customers', function (Blueprint $table) {
            //
        });
    }
}
