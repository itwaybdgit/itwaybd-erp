<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPasswordToBandwidthCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bandwidth_customers', function (Blueprint $table) {
            $table->string('password')->default('$2y$10$yjSYg.YyHK5PMS.C95uPMeT9/H04hUc4f11YMewlOZ7usQaI.kypO');
            $table->string('m_password')->default('12345678');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bandwidth_customers', function (Blueprint $table) {
            //
        });
    }
}
