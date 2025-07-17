<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBandwidthCustomersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bandwidth_customers', function (Blueprint $table) {
            $table->id();
            $table->string('company_name', 100)->nullable();
            $table->string('company_owner_name', 100)->nullable();
            $table->string('company_owner_phone', 14)->nullable();
            $table->longText('contact_person_name', 100)->nullable();
            $table->longText('contact_person_phone', 14)->nullable();
            $table->longText('contact_person_email', 14)->nullable();
            $table->string('customer_address', 250)->nullable();
            $table->string('license_type', 25)->nullable();
            $table->foreignId('division_id')->nullable();
            $table->foreignId('district_id')->nullable();
            $table->foreignId('upazila_id')->nullable();
            $table->longText('road')->nullable();
            $table->longText('house')->nullable();
            $table->string('vat_check')->nullable()->default('yes');
            $table->string('license_no')->nullable();
            $table->date('license_date')->nullable();
            $table->longText('latitude')->nullable();
            $table->longText('longitude')->nullable();
            $table->string('admin_name')->nullable();
            $table->string('admin_designation')->nullable();
            $table->string('admin_cell')->nullable();
            $table->string('admin_email')->nullable();
            $table->string('billing_name')->nullable();
            $table->string('billing_designation')->nullable();
            $table->string('billing_cell')->nullable();
            $table->longText('billing_email')->nullable();
            $table->string('technical_name')->nullable();
            $table->string('technical_designation')->nullable();
            $table->string('technical_cell')->nullable();
            $table->string('technical_email')->nullable();
            $table->string('installment')->nullable();
            $table->string('installment_date')->nullable();
            $table->tinyInteger('otc')->nullable();
            $table->string('customer_priority', 10)->nullable();
            $table->foreignId('data_source')->nullable();
            $table->foreignId('connection_path_id')->nullable();
            $table->double('commission', 2)->nullable();

            $table->foreignId('team_id')->nullable();

            $table->longText('remark')->nullable();
            $table->string('provider')->nullable();
            $table->integer('status')->nullable()->default(0);
            $table->foreignId('business_id')->nullable();
            $table->integer('sales_approve')->default(0);
            $table->integer('legal_approve')->default(0);
            $table->integer('transmission_approve')->default(0);
            $table->integer('noc_approve')->default(0);
            $table->integer('noc2_approve')->default(0);
            $table->integer('billing_approve')->default(0);
            $table->integer('reject_sales_approve')->default(0);
            $table->integer('reject_legal_approve')->default(0);
            $table->integer('reject_transmission_approve')->default(0);
            $table->integer('reject_noc_approve')->default(0);
            $table->integer('reject_noc2_approve')->default(0);
            $table->integer('reject_billing_approve')->default(0);
            $table->string('level_confirm')->nullable();
            $table->foreignId('level_confirm_by')->nullable();
            $table->foreignId('sales_approve_by')->nullable();
            $table->foreignId('legal_approve_by')->nullable();
            $table->foreignId('transmission_approve_by')->nullable();
            $table->foreignId('noc_approve_by')->nullable();
            $table->foreignId('noc2_approve_by')->nullable();
            $table->foreignId('billing_approve_by')->nullable();
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
        Schema::dropIfExists('bandwidth_customers');
    }
}
