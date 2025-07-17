<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssignByToBandwidthCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bandwidth_customers', function (Blueprint $table) {
            $table->string('assign_to')->nullable();
            $table->foreignId('assign_by')->nullable();
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
