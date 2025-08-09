<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_requests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('requester_id')->constrained('users');
            $table->foreignId('requested_user_id')->constrained('users');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->enum('priority', ['Low', 'Medium', 'High', 'Critical'])->default('Medium');
            $table->dateTime('due_date');
            $table->foreignId('task_id')->nullable()->constrained('tasks');
            $table->timestamps();
            $table->softDeletes();
            $table->index('status');
            $table->index('requester_id');
            $table->index('requested_user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_requests');
    }
}
