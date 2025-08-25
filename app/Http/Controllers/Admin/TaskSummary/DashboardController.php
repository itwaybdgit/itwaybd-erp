<?php

namespace App\Http\Controllers\Admin\TaskSummary;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Project;
use App\Models\Task;
use App\Models\TimerLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $employees = Employee::get()->map(function ($user) {
            $stats = $this->getTaskStats($user->id);
            return [
                'id'             => $user->id,
                'name'           => $user->name,
                'totalTasks'     => $stats['totalTasks'],
                'completedTasks' => $stats['completedTasks'],
                'activeTasks'    => $stats['activeTasks'],
                'overdueTasks'   => $stats['overdueTasks'],
            ];
        });

        $activeTimers = TimerLog::where('status', 'active')
            ->with(['employee.user', 'task', 'subtask'])
            ->get()
            ->map(function ($timer) {
                return [
                    'employee_name' => optional($timer->employee->user)->name ?? 'Unknown',
                    'task_title'    => optional($timer->task)->title ?? 'N/A',
                    'subtask_title' => optional($timer->subtask)->title ?? '-',
                    'started_at'    => $timer->started_at->format('Y-m-d H:i:s'),
                    'duration'      => $timer->getFormattedDuration(),
                ];
            });
        
        return view('admin.pages.admin-dashboard.index', compact('projects', 'tasks', 'employees', 'activeTimers'));
    }

    public function getActiveTimers()
    {
        $activeTimers = TimerLog::active()
            ->with(['employee.user', 'task', 'subtask'])
            ->get()
            ->map(function ($timer) {
                return [
                    'id' => $timer->id,
                    'employee_name' => optional($timer->employee->user)->name ?? 'Unknown',
                    'task_title' => optional($timer->task)->title ?? 'N/A',
                    'subtask_title' => optional($timer->subtask)->title ?? '-',
                    'started_at' => $timer->started_at->format('Y-m-d H:i:s'),
                    'duration' => $timer->getCurrentDuration(),
                ];
            });

        return response()->json($activeTimers);
    }

    public function calendarData()
    {
        $tasks = Task::with(['project', 'subtasks.employee.user'])->get();

            $events = $tasks->map(function ($task) {
                $employees = $task->subtasks
                    ->map(fn($s) => optional(optional($s->employee)->user)->name)
                    ->filter()
                    ->unique()
                    ->values()
                    ->all();
                switch ($task->status) {
                    case \App\Models\Task::STATUS_PENDING:
                        $color = '#ffc107';
                        break;

                    case \App\Models\Task::STATUS_IN_PROGRESS:
                        $color = '#0d6efd';
                        break;

                    case \App\Models\Task::STATUS_COMPLETED:
                        $color = '#28a745';
                        break;

                    default:
                        $color = '#6c757d';
                }

                return [
                    'id'    => $task->id,
                    'title' => $task->title,
                    'start' => optional($task->start_date_time)?->toIso8601String(),
                    'end'   => optional($task->end_date_time)?->toIso8601String(),
                    'color' => $color,
                    'extendedProps' => [
                        'project'   => $task->project->name ?? 'N/A',
                        'employee' => implode(', ', $employees) ?: 'N/A',
                        'status'    => $task->status,
                        'priority'  => $task->priority,
                    ],
                ];
            })->values();

            return response()->json($events);
    }




    public function getTaskStats($employeeId = null)
    {
        $employee = Employee::where('id', $employeeId)->first();

        if (!$employee) {
            return [
                'totalTasks' => 0,
                'activeTasks' => 0,
                'completedTasks' => 0,
                'overdueTasks' => 0
            ];
        }

        $tasks = Task::whereHas('subtasks', function ($query) use ($employee) {
            $query->where('user_id', $employee->id);
        })->get();

        return [
            'totalTasks'     => $tasks->count(),
            'activeTasks'    => $tasks->where('status', 'In Progress')->count(),
            'completedTasks' => $tasks->where('status', 'Completed')->count(),
            'overdueTasks'   => $tasks->filter(function ($task) {
                return now()->gt($task->end_date_time) && $task->status !== 'Completed';
            })->count(),
        ];
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
        $completedTasks = Task::where('status', 'Completed')->whereBetween('created_at', [$from, $to])->count();
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
            'completedTasks' => $completedTasks,
            'pendingTasks' => $pendingTasks,
            'delayedTasks' => $delayedTasks,
            'priorityLow' => $priorityLow,
            'priorityMedium' => $priorityMedium,
            'priorityHigh' => $priorityHigh,
            'priorityCritical' => $priorityCritical
        ];
    }

    public function employeeTaskDetail($empId)
    {
        $employee = Employee::findOrFail($empId);

        if (!$employee) {
            return view('tasks.my_tasks', ['tasks' => collect([])]);
        }

        $tasks = Task::whereHas('subtasks', function ($query) use ($employee) {
            $query->where('user_id', $employee->id);
        })
            ->with([
                'subtasks.employee.user',
                'project',
                'team.employees.user',
                'creator'
            ])
            ->get();

        $formattedTasks = $tasks->map(function ($task) use ($employee) {
            $userSubtasks = $task->subtasks->where('user_id', $employee->id);

            return [
                'id' => $task->id,
                'project' => optional($task->project)->name ?? 'N/A',
                'title' => $task->title,
                'description' => $task->description,
                'priority' => $task->priority ? $task->priority : 'normal',
                'status' => $task->status ? $task->status : 'pending',
                'project' => optional($task->project)->name ?? 'N/A',
                'team' => optional($task->team)->name ?? 'N/A',
                'start_date_time' => optional($task->start_date_time)->format('Y-m-d H:i'),
                'end_date_time' => optional($task->end_date_time)->format('Y-m-d H:i'),
                'created_by' => optional($task->creator)->name ?? 'Unknown',
                'assigned_to' => $employee->id,
                'progress' => $this->calculateUserProgress($userSubtasks),
                'time_logged' => $userSubtasks->sum('time_logged') ?? 0,
                'is_overdue' => now()->gt($task->end_date_time) && $task->status !== 'Completed',

                'subtasks' => $userSubtasks->map(function ($subtask) {
                    return [
                        'id' => $subtask->id,
                        'title' => $subtask->title,
                        'description' => $subtask->description,
                        'status' => strtolower($subtask->status),
                        'priority' => strtolower($subtask->priority),
                        'time_logged' => $subtask->time_logged ?? 0,
                        'user_name' => optional($subtask->employee?->user)->name ?? 'Unknown'
                    ];
                })->values(),

                'team_members' => Employee::all()->map(function ($emp) {
                    return [
                        'id' => $emp->id,
                        'name' => optional($emp->user)->name ?? 'Unknown',
                        'role' => optional($emp->designations)->name ?? 'Employee',
                    ];
                })->values() ?? [],
            ];
        });

        return view('admin.pages.admin-dashboard.employee-task-detail', ['tasks' => $formattedTasks, 'employee' => $employee]);
    }

    private function calculateUserProgress($userSubtasks)
    {
        $total = $userSubtasks->count();
        if ($total === 0) return 0;

        $completed = $userSubtasks->where('status', 'Completed')->count();
        return round(($completed / $total) * 100);
    }


    public function ongoingProjects()
    {
        $ongoingProjects = Project::whereHas('tasks')
            ->with(['tasks.subtasks'])
            ->get();

        $projectsData = $ongoingProjects->map(function($project) {
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
