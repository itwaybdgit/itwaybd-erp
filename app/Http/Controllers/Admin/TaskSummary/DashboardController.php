<?php

namespace App\Http\Controllers\Admin\TaskSummary;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $projects = [
            'totalProjects' => Project::count(),
            'ongoingProjects' => Project::wherehas('tasks')->count(),
            'completedProjects' => Project::where('status', 'Completed')->count(),
            'pendingProjects' => Project::where('status', 'Pending')->count()
        ];

        $tasks = $this->getTaskData();

        return view('admin.pages.admin-dashboard.index', compact('projects', 'tasks'));
    }

    public function filter(Request $request)
    {
        $tasks = $this->getTaskData($request);
        return response()->json($tasks);
    }

    private function getTaskData($request = null)
    {
        $range = $request->range ?? null;
        $start = $request->start ?? null;
        $end = $request->end ?? null;

        // Date range calculation
        if ($range == 'today') {
            $from = now('Asia/Dhaka')->startOfDay();
            $to = now('Asia/Dhaka')->endOfDay();
        } elseif ($range == '7days') {
            $from = now('Asia/Dhaka')->subDays(7)->startOfDay();
            $to = now('Asia/Dhaka')->endOfDay();
        } elseif ($range == '30days') {
            $from = now('Asia/Dhaka')->subDays(30)->startOfDay();
            $to = now('Asia/Dhaka')->endOfDay();
        } elseif ($start && $end) {
            $from = Carbon::parse($start)->startOfDay();
            $to = Carbon::parse($end)->endOfDay();
        } else {
            $from = now('Asia/Dhaka')->startOfDay();
            $to = now('Asia/Dhaka')->endOfDay();
        }

        // Task counts
        $todayTasks = Task::whereBetween('created_at', [$from, $to])->count();
        $ongoingTasks = Task::where('status', 'In Progress')->whereBetween('created_at', [$from, $to])->count();
        $pendingTasks = Task::where('status', 'Pending')->whereBetween('created_at', [$from, $to])->count();
        $delayedTasks = Task::where('end_date_time', '<', now('Asia/Dhaka'))
                            ->where('status', '!=', 'Completed')
                            ->whereBetween('created_at', [$from, $to])->count();

        // Priority counts
        $priorityLow = Task::where('priority', 'Low')->whereBetween('created_at', [$from, $to])->count();
        $priorityMedium = Task::where('priority', 'Medium')->whereBetween('created_at', [$from, $to])->count();
        $priorityHigh = Task::where('priority', 'High')->whereBetween('created_at', [$from, $to])->count();
        $priorityCritical = Task::where('priority', 'Critical')->whereBetween('created_at', [$from, $to])->count();

        return [
            'todayTasks' => $todayTasks,
            'ongoingTasks' => $ongoingTasks,
            'pendingTasks' => $pendingTasks,
            'delayedTasks' => $delayedTasks,
            'priorityLow' => $priorityLow,
            'priorityMedium' => $priorityMedium,
            'priorityHigh' => $priorityHigh,
            'priorityCritical' => $priorityCritical
        ];
    }

    public function ongoingProjects()
    {
        $ongoingProjects = Project::whereHas('tasks')
            ->with(['tasks.subtasks'])
            ->get();

        $projectsData = $ongoingProjects->map(function($project) {
            // $totalTasks = $project->tasks->count();
            // $completedTasks = $project->tasks->where('status', 'completed')->count();
            // $progress = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;



            $tasks = $project->tasks->map(function($task){
                $subtasks = $task->subtasks->map(function($subtask){
                    $assignedUser = DB::table('subtasks')
                        ->join('employees', 'subtasks.user_id', '=', 'employees.id')
                        ->join('users', 'employees.user_id', '=', 'users.id')
                        ->where('subtasks.id', $subtask->id)
                        ->select('users.id', 'users.name', 'users.email')
                        ->first();

                    return [
                        'id' => $subtask->id,
                        'title' => $subtask->title,
                        'status' => $subtask->status,
                        'assigned_user' => $assignedUser ? [
                            'id' => $assignedUser->id,
                            'name' => $assignedUser->name,
                            'email' => $assignedUser->email,
                        ] : null,
                    ];
                });

                $subtaskCount = $subtasks->count();
                $completedSubtasks = $subtasks->filter(function($subtask) {
                    return strtolower($subtask['status']) === 'completed';
                })->count();

                $taskProgress = $subtaskCount > 0 ? round(($completedSubtasks / $subtaskCount) * 100, 2) : 0;

                return [
                    'id' => $task->id,
                    'title' => $task->title,
                    'status' => $task->status,
                    'subtasks' => $subtasks,
                    'progress' => $taskProgress,
                ];
            });
            
            $totalTasks = $tasks->count();
            $completedTasks = $tasks->where('status', 'Completed')->count();
            $projectProgress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 2) : 0;

            return [
                'id' => $project->id,
                'name' => $project->name,
                'description' => $project->description,
                'total_tasks' => $totalTasks,
                'completed_tasks' => $completedTasks,
                'progress' => $projectProgress,
                'tasks' => $tasks,
            ];
        });
        return view('admin.pages.admin-dashboard.ongoing-project', compact('projectsData'));
    }








    public function today()
    {
        $tasks = Task::whereDate('created_at', Carbon::today())->get();
        return view('admin.tasks.today', compact('tasks'));
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
