<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGatewayNocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gateway_nocs', function (Blueprint $table) {
            $table->id();
            $table->string('bandwidth_customer_id')->nullable();
            $table->string('item_for_vlan')->nullable();
            $table->string('vlan')->nullable();
            $table->string('ip')->nullable();
            $table->string('item_id')->nullable();
            $table->string('remote_asn')->nullable();
            $table->string('client_asn')->nullable();
            $table->string('ip_lease')->nullable();
            $table->string('router_id')->nullable();
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
        Schema::dropIfExists('gateway_nocs');
    }
}
