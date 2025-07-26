<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->nullable();
            $table->string('name');
            $table->string('description')->nullable();
            $table->date('starting_date');
            $table->date('ending_date');
            $table->string('priority')->nullable();
            $table->double('estimated_hours')->nullable();
            $table->double('progress')->nullable();
            $table->double('budget')->nullable();
            $table->json('tags')->nullable();
            $table->longText('notes')->nullable();
            $table->string('status')->nullable();
            $table->integer('hypercare_months')->nullable();
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
        Schema::dropIfExists('projects');
    }
}
