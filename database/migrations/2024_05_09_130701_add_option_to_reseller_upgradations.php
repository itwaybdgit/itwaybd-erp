<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOptionToResellerUpgradations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reseller_upgradations', function (Blueprint $table) {
            $table->integer('sale_head_approve')->default(0);
            $table->integer('bill_head_approve')->default(0);
            $table->integer('tx_pluning_head_approve')->default(0);
            $table->integer('transmission_head_approve')->default(0);
            $table->integer('level_3_approve')->default(0);
            $table->integer('confirm_bill_approve')->default(0);
            $table->integer('pending_status')->default(0);

            $table->integer('sale_head_by')->default(0);
            $table->integer('bill_head_by')->default(0);
            $table->integer('tx_pluning_head_by')->default(0);
            $table->integer('transmission_head_by')->default(0);
            $table->integer('level_3_by')->default(0);
            $table->integer('confirm_bill_by')->default(0);
            $table->integer('pending_status_by')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reseller_upgradations', function (Blueprint $table) {
            //
        });
    }
}
