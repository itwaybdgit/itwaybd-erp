<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBandwidthCustomerPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bandwidth_customer_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bandwidht_customer_id');
            $table->foreignId('item_id')->nullable();
            $table->longText('description')->nullable();
            $table->string('unit')->nullable();
            $table->string('qty')->nullable();
            $table->string('rate')->nullable();
            $table->string('vat')->nullable();
            $table->enum('status',[0,1]);
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
        Schema::dropIfExists('bandwidth_customer_packages');
    }
}
