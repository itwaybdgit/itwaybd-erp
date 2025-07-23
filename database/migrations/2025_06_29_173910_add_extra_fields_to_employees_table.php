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
        Schema::table('employees', function (Blueprint $table) {

            if (!Schema::hasColumn('employees', 'guardian_number')) {
                $table->string('guardian_number')->nullable()->after('blood_group');
            }

            if (!Schema::hasColumn('employees', 'guardian_nid')) {
                $table->string('guardian_nid')->nullable()->after('guardian_number');
            }

            if (!Schema::hasColumn('employees', 'employee_status')) {
                $table->string('employee_status')->nullable()->after('guardian_nid');
            }

            if (!Schema::hasColumn('employees', 'am_name')) {
                $table->string('am_name')->nullable()->after('employee_status');
            }

            if (!Schema::hasColumn('employees', 'area')) {
                $table->string('area')->nullable()->after('am_name');
            }

            if (!Schema::hasColumn('employees', 'device_id')) {
                $table->string('device_id')->nullable()->after('area');
            }

            if (!Schema::hasColumn('employees', 'attendanceBonus')) {
                $table->decimal('attendanceBonus', 8, 2)->nullable()->after('device_id');
            }

            if (!Schema::hasColumn('employees', 'zone_id')) {
                $table->unsignedBigInteger('zone_id')->nullable()->after('attendanceBonus');
            }

            if (!Schema::hasColumn('employees', 'subzone_id')) {
                $table->unsignedBigInteger('subzone_id')->nullable()->after('zone_id');
            }

            if (!Schema::hasColumn('employees', 'branch_id')) {
                $table->unsignedBigInteger('branch_id')->nullable()->after('subzone_id');
            }

            if (!Schema::hasColumn('employees', 'is_login')) {
                $table->boolean('is_login')->default(false)->after('branch_id');
            }
        });
    }

    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'guardian_number',
                'guardian_nid',
                'employee_status',
                'am_name',
                'area',
                'device_id',
                'attendanceBonus',
                'zone_id',
                'subzone_id',
                'branch_id',
                'is_login',
            ]);
        });
    }
};
