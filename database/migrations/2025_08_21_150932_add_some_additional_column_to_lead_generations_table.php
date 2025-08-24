<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeAdditionalColumnToLeadGenerationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lead_generations', function (Blueprint $table) {
            $table->string('group_name', 100)->nullable();
            $table->string('group_owner_name', 100)->nullable();
            $table->string('group_owner_phone', 14)->nullable();
            $table->bigInteger('branch_id')->nullable();
            $table->string('purpose')->nullable();
            $table->boolean('is_company_group')->default(false);
            $table->string('lead_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lead_generations', function (Blueprint $table) {
            $table->dropColumn('group_name');
            $table->dropColumn('group_owner_name');
            $table->dropColumn('group_owner_phone');
            $table->dropColumn('branch_id');
            $table->dropColumn('purpose');
            $table->dropColumn('is_company_group');
            $table->dropColumn('lead_type');
        });
    }
}
