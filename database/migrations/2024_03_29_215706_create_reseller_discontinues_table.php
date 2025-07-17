<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResellerDiscontinuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reseller_discontinues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->longText('reason')->nullable();
            $table->date('apply_date')->nullable();
            $table->enum('status', ['approve', 'reject', 'pending'])->default('pending')->nullable();
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

            $table->foreignId('created_by');
            $table->foreignId('approve_by');
            $table->foreignId('reject_by');
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
        Schema::dropIfExists('reseller_discontinues');
    }
}
