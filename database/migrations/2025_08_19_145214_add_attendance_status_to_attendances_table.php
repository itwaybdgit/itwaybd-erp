<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttendanceStatusToAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('attendances', 'attendanceStatus')) {
            $table->enum('attendanceStatus', ['present', 'absent', 'late', 'leave'])
                  ->nullable();
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
        Schema::table('attendances', function (Blueprint $table) {
            //
             $table->dropColumn('attendanceStatus');
        });
    }
}
