<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLegalInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legal_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bandwidth_customer_id')->nullable();
            $table->string('agreement')->nullable();
            $table->string('cheque')->nullable();
            $table->string('cheque_authorization')->nullable();
            $table->string('cash')->nullable();
            $table->string('noc_payment_clearance')->nullable();
            $table->string('isp_license')->nullable();
            $table->string('conversion')->nullable();
            $table->string('renewal')->nullable();
            $table->string('trade')->nullable();
            $table->string('nid')->nullable();
            $table->string('photo')->nullable();
            $table->string('tin')->nullable();
            $table->string('bin')->nullable();
            $table->string('authorization_letter')->nullable();
            $table->string('partnership_deed_org')->nullable();
            $table->string('partnership_deed')->nullable();
            $table->string('power_of_attorney')->nullable();
            $table->string('cert_of_incorporation')->nullable();
            $table->string('form_xii')->nullable();
            $table->string('moa_aoa')->nullable();
            $table->string('utility_bill')->nullable();
            $table->string('user_list')->nullable();
            $table->string('rent_agreement')->nullable();
            $table->string('equipment_agreement')->nullable();
            $table->string('iP_lease_agreement')->nullable();
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
        Schema::dropIfExists('legal_infos');
    }
}
