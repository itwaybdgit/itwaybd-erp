<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subtask_id')->nullable()->constrained('subtasks')->cascadeOnDelete();
            $table->string('subtask_title')->nullable();
            $table->foreignId('requester_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('supporter_id')->constrained('users')->cascadeOnDelete();
            $table->string('support_type');
            $table->text('message');
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('support_requests');
    }
}
