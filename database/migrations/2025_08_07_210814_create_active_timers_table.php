<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('active_timers', function (Blueprint $table) {
            $table->id();

            // User who owns this timer
            $table->unsignedBigInteger('user_id');

            // Task and subtask references
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('subtask_id');

            // Timer information
            $table->string('title'); // Subtask title for display
            $table->bigInteger('start_time'); // JavaScript timestamp in milliseconds
            $table->bigInteger('saved_at'); // When timer state was last saved (milliseconds)

            // Optional tracking fields
            $table->integer('elapsed_time')->default(0); // Elapsed seconds at last sync
            $table->timestamp('last_sync')->nullable(); // Last server sync time

            // Timestamps
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('subtask_id')->references('id')->on('subtasks')->onDelete('cascade');

            // Indexes for better performance
            $table->index(['user_id', 'subtask_id']);
            $table->index('start_time');

            // Only one active timer per user
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('active_timers');
    }
};
