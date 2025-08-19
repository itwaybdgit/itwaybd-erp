<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDepartmentIdToLeaveApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leave_applications', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('leave_applications', 'department_id')) {
            $table->unsignedBigInteger('department_id')->nullable()->after('employee_id');
        }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leave_applications', function (Blueprint $table) {
            //
            $table->dropColumn('department_id');
        });
    }
}
