<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResellerCapuncapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reseller_capuncaps', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->json('package')->nullable();
            $table->dateTime('apply_date')->nullable();
            $table->enum('status', ['approve', 'reject', 'pending'])->default('pending')->nullable();
            $table->foreignId('created_by');
            $table->foreignId('approve_by');
            $table->foreignId('reject_by');

            $table->integer('sale_head')->default(0);
            $table->integer('billing_approve')->default(0);
            $table->integer('level4_approve')->default(0);
            $table->integer('level3_approve')->default(0);

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
        Schema::dropIfExists('reseller_capuncaps');
    }
}
