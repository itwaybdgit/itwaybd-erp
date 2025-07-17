<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResellerUpgradationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reseller_upgradations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->json('package')->nullable();
            $table->date('apply_date')->nullable();
            $table->enum('status', ['approve', 'reject', 'pending'])->default('pending')->nullable();
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
        Schema::dropIfExists('reseller_upgradations');
    }
}
