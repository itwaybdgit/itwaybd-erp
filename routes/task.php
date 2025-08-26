<?php

use App\Http\Controllers\Admin\Task\MytaskController;
use App\Http\Controllers\Admin\TaskSummary\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->middleware(['auth'])->group(function () {
    Route::get('/my-tasks', [MytaskController::class, 'getMyTasksJson']);

    // Get task statistics
    Route::get('/my-task-stats', [MytaskController::class, 'getTaskStats']);

    // Timer management
    Route::post('/tasks/{taskId}/start-timer', [MytaskController::class, 'startTimer']);
    Route::post('/tasks/{taskId}/log-time', [MytaskController::class, 'logTime']);

    // Subtask management
    Route::post('/subtasks/store', [MytaskController::class, 'storeSubtask']);
    Route::post('/subtasks/{subtaskId}/status', [MytaskController::class, 'updateSubtaskStatus']);
    Route::post('/subtasks/{subtaskId}/start-timer', [MytaskController::class, 'startTimer']);
    Route::post('/subtasks/{subtaskId}/log-time', [MytaskController::class, 'logTime']);

    // Support requests (if you want to implement this)
    Route::post('/support-requests', [MytaskController::class, 'createSupportRequest']);

    // Timer management routes
    Route::post('/subtasks/{subtaskId}/start-timer', [MytaskController::class, 'startTimer']);
    Route::post('/subtasks/{subtaskId}/pause-timer', [MytaskController::class, 'pauseTimer']);
    Route::get('/my-active-timer', [MytaskController::class, 'getActiveTimer']);
    Route::post('/subtasks/{subtaskId}/auto-save-timer', [MytaskController::class, 'autoSaveTimer']);
    Route::get('/my-timer-history', [MytaskController::class, 'getTimerHistory']);
});


Route::middleware(['web', 'auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/summary/dashboard', [DashboardController::class, 'index'])->name('task.dashboard');
    Route::get('summary/dashboard/filter', [DashboardController::class, 'filter'])->name('summary.dashboard.filter');
    Route::get('employee-tasks/{id}', [DashboardController::class, 'employeeTaskDetail'])->name('employee.tasks.detail');


    Route::get('/active-timers', [DashboardController::class, 'getActiveTimers'])->name('activeTimers');
    Route::get('/calendar-data', [DashboardController::class, 'calendarData'])->name('calendarData');




    Route::get('/projects/ongoing', [DashboardController::class, 'ongoingProjects'])->name('project.ongoing');
});




require __DIR__ . '/auth.php';
