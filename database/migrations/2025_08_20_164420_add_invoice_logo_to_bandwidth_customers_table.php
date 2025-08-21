<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvoiceLogoToBandwidthCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bandwidth_customers', function (Blueprint $table) {
            $table->string('invoice_logo')->nullable()->after('customer_address');
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
            $table->dropColumn('invoice_logo');
        });
    }
}
