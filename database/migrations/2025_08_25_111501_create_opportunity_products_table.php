<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpportunityProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opportunity_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opportunity_id');
            $table->foreignId('product_category_id');
            $table->foreignId('product_id');
            $table->integer('quantity')->nullable();
            $table->float('unit_price', 12, 2)->nullable();
            $table->float('total_price', 12, 2)->nullable();
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
        Schema::dropIfExists('opportunity_products');
    }
}
