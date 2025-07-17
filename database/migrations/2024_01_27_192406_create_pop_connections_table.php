<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePopConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pop_connections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bandwidth_customer_id');
            $table->string('pop_id')->nullable();
            $table->string('port')->nullable();
            $table->string('port_type')->nullable();
            $table->string('device_id')->nullable();
            $table->string('device_name')->nullable();
            $table->string('rj45')->nullable();
            $table->string('fiber')->nullable();
            $table->string('patched')->nullable();
            $table->string('sfp')->nullable();
            $table->string('customer_sfp')->nullable();
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
        Schema::dropIfExists('pop_connections');
    }
}
