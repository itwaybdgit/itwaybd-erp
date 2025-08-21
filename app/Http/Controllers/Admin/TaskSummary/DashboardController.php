<?php

namespace App\Http\Controllers\Admin\TaskSummary;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $todayTasks = Task::whereDate('created_at', Carbon::today())->count();

        $ongoingTasks = Task::where('status', 'In Progress')->count();

        $pendingTasks = Task::where('status', 'Pending')->count();

        $delayedTasks = Task::where('end_date_time', '<', now())
                            ->where('status', '!=', 'Completed')
                            ->count();

        return view('admin.pages.admin-dashboard.index', compact(
            'todayTasks',
            'ongoingTasks',
            'pendingTasks',
            'delayedTasks'
        ));
    }

    public function today()
    {
        $tasks = Task::whereDate('created_at', Carbon::today())->get();
        return view('admin.tasks.today', compact('tasks'));
    }

    public function ongoing()
    {
        $tasks = Task::where('status', 'In Progress')->get();
        return view('admin.tasks.ongoing', compact('tasks'));
    }

    public function pending()
    {
        $tasks = Task::where('status', 'Pending')->get();
        return view('admin.tasks.pending', compact('tasks'));
    }

    public function delayed()
    {
        $tasks = Task::where('end_date_time', '<', now())
                     ->where('status', '!=', 'Completed')
                     ->get();
        return view('admin.tasks.delayed', compact('tasks'));
    }
}
