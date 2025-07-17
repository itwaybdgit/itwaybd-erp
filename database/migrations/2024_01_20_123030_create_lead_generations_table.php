<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadGenerationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_generations', function (Blueprint $table) {
            $table->id();
            $table->string('company_name', 100)->nullable();
            $table->string('company_owner_name', 100)->nullable();
            $table->string('company_owner_phone', 14)->nullable();
            $table->longText('contact_person_name', 100)->nullable();
            $table->longText('contact_person_email', 14)->nullable();
            $table->longText('contact_person_phone', 14)->nullable();
            $table->string('customer_address', 250)->nullable();
            $table->foreignId('license_type')->nullable();
            $table->foreignId('division_id')->nullable();
            $table->foreignId('district_id')->nullable();
            $table->foreignId('upazila_id')->nullable();
            $table->longText('road')->nullable();
            $table->longText('house')->nullable();
            $table->string('item_id')->nullable();
            $table->string('quantity')->nullable();
            $table->string('asking_price')->nullable();
            $table->tinyInteger('otc')->nullable();
            $table->string('customer_priority', 10)->nullable();
            $table->foreignId('data_source')->nullable();
            $table->foreignId('connected_path')->nullable();
            $table->double('commission', 2)->nullable();
            $table->longText('remark')->nullable();
            $table->enum('status',[0,1]);
            $table->longText('latitude')->nullable();
            $table->longText('longitude')->nullable();
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->foreignId('approved_by')->nullable();
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
        Schema::dropIfExists('lead_generations');
    }
}
