<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holidays', function (Blueprint $table) {
            $table->id(); // id (primary key, auto-increment)
            $table->date('date'); // date column
            $table->string('title'); // title column
            $table->string('status'); // status column (you can change type if needed)
            $table->string('type'); // type column
            $table->unsignedBigInteger('create_by'); // create_by column (assuming user id)
            $table->unsignedBigInteger('update_by')->nullable(); // update_by column (nullable)
            $table->timestamps(); // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('holidays');
    }
};
