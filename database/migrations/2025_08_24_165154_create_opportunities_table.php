<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpportunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('lead_generation_id')->nullable();
            $table->string('category_id')->nullable();
            $table->string('item_id')->nullable();
            $table->string('quantity')->nullable();
            $table->string('asking_price')->nullable();
            $table->tinyInteger('otc')->nullable();
            $table->foreignId('connected_path')->nullable();
            $table->double('commission', 2)->nullable();
            $table->longText('remark')->nullable();
            $table->enum('status',[0,1]);
            $table->longText('latitude')->nullable();
            $table->longText('longitude')->nullable();
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->foreignId('approved_by')->nullable();
            $table->string('recurring_type')->nullable();
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
        Schema::dropIfExists('opportunities');
    }
}
