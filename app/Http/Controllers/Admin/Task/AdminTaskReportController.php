<?php

namespace App\Http\Controllers\Admin\Task;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Employee;
use App\Models\Subtask;
use App\Models\TimerLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminTaskReportController extends Controller
{
    /**
     * Display the admin task report dashboard
     */
    public function index()
    {
        return view('admin.pages.reports.task.task');
    }

    /**
     * Get calendar-wise tasks data
     */
    public function getCalendarTasks(Request $request)
    {
        $start = $request->get('start', Carbon::now()->startOfMonth());
        $end = $request->get('end', Carbon::now()->endOfMonth());

        $tasks = Task::with(['subtasks.employee.user', 'project', 'creator'])
            ->whereBetween('start_date_time', [$start, $end])
            ->orWhereBetween('end_date_time', [$start, $end])
            ->get();

        $calendarEvents = $tasks->map(function ($task) {
            return [
                'id' => $task->id,
                'title' => $task->title,
                'start' => $task->start_date_time ? $task->start_date_time->format('Y-m-d H:i:s') : null,
                'end' => $task->end_date_time ? $task->end_date_time->format('Y-m-d H:i:s') : null,
                'color' => $this->getTaskStatusColor($task->status),
                'extendedProps' => [
                    'status' => $task->status,
                    'priority' => $task->priority,
                    'project' => $task->project->name ?? 'No Project',
                    'assigned_users' => $task->subtasks->map(function ($subtask) {
                        return $subtask->employee->user->name ?? 'Unknown';
                    })->unique()->values()->toArray(),
                    'progress' => $this->calculateTaskProgress($task),
                    'is_overdue' => $task->end_date_time ? Carbon::now()->gt($task->end_date_time) && $task->status !== 'Completed' : false
                ]
            ];
        });

        return response()->json($calendarEvents);
    }

    /**
     * Get user daily activity
     */
    public function getUserDailyActivity(Request $request)
    {
        $date = $request->get('date', Carbon::today());
        $userId = $request->get('user_id');

        $query = TimerLog::with(['employee.user', 'task', 'subtask'])
            ->whereDate('started_at', $date);

        if ($userId) {
            $query->whereHas('employee', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            });
        }

        $activities = $query->orderBy('started_at', 'desc')->get();

        $groupedActivities = $activities->groupBy(function ($activity) {
            return $activity->employee->user->name ?? 'Unknown User';
        });

        $result = $groupedActivities->map(function ($userActivities, $userName) {
            $totalTimeLogged = $userActivities->sum('duration_seconds');
            $tasksWorked = $userActivities->unique('task_id')->count();

            return [
                'user_name' => $userName,
                'user_id' => $userActivities->first()->employee->user_id ?? null,
                'total_time_logged' => $totalTimeLogged,
                'formatted_time' => $this->formatDuration($totalTimeLogged),
                'tasks_worked' => $tasksWorked,
                'activities' => $userActivities->map(function ($activity) {
                    return [
                        'id' => $activity->id,
                        'task_title' => $activity->task->title ?? 'Unknown Task',
                        'subtask_title' => $activity->subtask->title ?? 'Unknown Subtask',
                        'started_at' => $activity->started_at->format('H:i:s'),
                        'ended_at' => $activity->ended_at ? $activity->ended_at->format('H:i:s') : null,
                        'duration' => $activity->duration_seconds,
                        'formatted_duration' => $this->formatDuration($activity->duration_seconds),
                        'status' => $activity->status
                    ];
                })
            ];
        });

        return response()->json($result);
    }

    /**
     * Get task overview statistics
     */
    public function getTaskOverview(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth());

        $tasks = Task::with(['subtasks'])
            ->whereBetween('created_at', [$startDate, $endDate]);

        $totalTasks = $tasks->count();
        $completedTasks = $tasks->where('status', 'Completed')->count();
        $inProgressTasks = $tasks->where('status', 'In Progress')->count();
        $pendingTasks = $tasks->where('status', 'Pending')->count();
        $onHoldTasks = $tasks->where('status', 'On Hold')->count();

        $overdueTasks = $tasks->get()->filter(function ($task) {
            return $task->end_date_time ? Carbon::now()->gt($task->end_date_time) && $task->status !== 'Completed' : false;
        })->count();

        // Priority breakdown
        $highPriorityTasks = $tasks->where('priority', 'High')->count();
        $mediumPriorityTasks = $tasks->where('priority', 'Medium')->count();
        $lowPriorityTasks = $tasks->where('priority', 'Low')->count();

        // Calculate average completion time
        $completedTasksData = Task::where('status', 'Completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $avgCompletionTime = 0;
        if ($completedTasksData->count() > 0) {
            $totalCompletionTime = $completedTasksData->sum(function ($task) {
                return $task->updated_at->diffInDays($task->created_at);
            });
            $avgCompletionTime = round($totalCompletionTime / $completedTasksData->count(), 1);
        }

        return response()->json([
            'total_tasks' => $totalTasks,
            'completed_tasks' => $completedTasks,
            'in_progress_tasks' => $inProgressTasks,
            'pending_tasks' => $pendingTasks,
            'on_hold_tasks' => $onHoldTasks,
            'overdue_tasks' => $overdueTasks,
            'completion_rate' => $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 1) : 0,
            'priority_breakdown' => [
                'high' => $highPriorityTasks,
                'medium' => $mediumPriorityTasks,
                'low' => $lowPriorityTasks
            ],
            'avg_completion_days' => $avgCompletionTime
        ]);
    }

    /**
     * Get team performance data
     */
    public function getTeamPerformance(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth());

        $employees = Employee::with(['user', 'subtasks' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }])->get();

        $performance = $employees->map(function ($employee) {
            $subtasks = $employee->subtasks;
            $totalSubtasks = $subtasks->count();
            $completedSubtasks = $subtasks->where('status', 'Completed')->count();
            $totalTimeLogged = $subtasks->sum('time_logged');

            return [
                'employee_id' => $employee->id,
                'name' => $employee->user->name ?? 'Unknown',
                'email' => $employee->user->email ?? 'Unknown',
                'total_subtasks' => $totalSubtasks,
                'completed_subtasks' => $completedSubtasks,
                'completion_rate' => $totalSubtasks > 0 ? round(($completedSubtasks / $totalSubtasks) * 100, 1) : 0,
                'total_time_logged' => $totalTimeLogged,
                'formatted_time' => $this->formatDuration($totalTimeLogged),
                'avg_time_per_task' => $completedSubtasks > 0 ? round($totalTimeLogged / $completedSubtasks, 0) : 0
            ];
        })->sortByDesc('completion_rate');

        return response()->json($performance->values());
    }

    /**
     * Get task progress over time (for charts)
     */
    public function getTaskProgressChart(Request $request)
    {
        $days = $request->get('days', 30);
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subDays($days);

        $dateRange = [];
        $current = $startDate->copy();

        while ($current->lte($endDate)) {
            $dateRange[] = $current->format('Y-m-d');
            $current->addDay();
        }

        $chartData = collect($dateRange)->map(function ($date) {
            $tasksCreated = Task::whereDate('created_at', $date)->count();
            $tasksCompleted = Task::whereDate('updated_at', $date)
                ->where('status', 'Completed')
                ->count();

            return [
                'date' => $date,
                'created' => $tasksCreated,
                'completed' => $tasksCompleted
            ];
        });

        return response()->json($chartData);
    }

    /**
     * Get all users for dropdown
     */
    public function getUsers()
    {
        $users = Employee::with('user')->get()->map(function ($employee) {
            return [
                'id' => $employee->user_id,
                'name' => $employee->user->name ?? 'Unknown',
                'employee_id' => $employee->id
            ];
        });

        return response()->json($users);
    }

    /**
     * Export task report
     */
    public function exportReport(Request $request)
    {
        // Implementation for exporting reports (CSV/Excel)
        // This would typically use Laravel Excel package
        return response()->json(['message' => 'Export functionality to be implemented']);
    }

    /**
     * Helper method to get task status color
     */
    private function getTaskStatusColor($status)
    {
        $colors = [
            'Pending' => '#f59e0b',      // amber
            'In Progress' => '#3b82f6',  // blue
            'Completed' => '#10b981',    // green
            'On Hold' => '#ef4444',      // red
        ];

        return $colors[$status] ?? '#6b7280'; // gray for unknown status
    }

    /**
     * Helper method to calculate task progress
     */
    private function calculateTaskProgress($task)
    {
        $subtasks = $task->subtasks;
        if ($subtasks->count() === 0) return 0;

        $completedSubtasks = $subtasks->where('status', 'Completed')->count();
        return round(($completedSubtasks / $subtasks->count()) * 100);
    }

    /**
     * Helper method to format duration
     */
    private function formatDuration($seconds)
    {
        if (!$seconds) return '00:00:00';

        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }
}
