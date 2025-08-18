<?php

namespace App\Http\Controllers\Admin\Task;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Subtask;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TimerLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MytaskController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee = Employee::where('user_id', Auth::id())->first();
        if (!$employee) {
            return back();
        }

        $tasks = Task::whereHas('subtasks', function ($query) use ($employee) {
            $query->where('user_id', $employee->id);
        })
            ->with([
                'subtasks' => function ($query) use ($employee) {
                    $query->with('employee.user');
                },
                'project',
                'team.employees.user',
                'creator'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        $tasks->transform(function ($task) use ($employee) {
            $userSubtasks = $task->subtasks->where('user_id', $employee->id);

            $totalUserSubtasks = $userSubtasks->count();
            $completedUserSubtasks = $userSubtasks->where('status', 'Completed')->count();
            $userProgress = $totalUserSubtasks > 0 ? round(($completedUserSubtasks / $totalUserSubtasks) * 100) : 0;

            $userTimeLogged = $userSubtasks->sum('time_logged') ?? 0;

            $task->user_progress = $userProgress;
            $task->user_time_logged = $userTimeLogged;
            $task->user_subtasks = $userSubtasks;
            $task->total_user_subtasks = $totalUserSubtasks;
            $task->completed_user_subtasks = $completedUserSubtasks;

            // Check if task is overdue
            $task->is_overdue = now()->gt($task->end_date_time) && $task->status !== 'Completed';

            return $task;
        });

        return view('admin.pages.ProjectManagement.mytask.mytask', get_defined_vars());
    }
    public function getMyTasksJson()
    {
        $employee = Employee::where('user_id', Auth::id())->first();

        if (!$employee) {
            return response()->json(['tasks' => []]);
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
                'title' => $task->title,
                'description' => $task->description,
                'priority' => $task->priority ? $task->priority : 'normal',
                'status' => $task->status? $task->status : 'pending',
                'project_id' => $task->project_id,
                'team_id' => $task->team_id,
                'start_date_time' => optional($task->start_date_time)->format('Y-m-d\TH:i:s'),
                'end_date_time' => optional($task->end_date_time)->format('Y-m-d\TH:i:s'),
                'created_by' => $task->created_by,
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
                        'user_id' => $subtask->user_id,
                        'priority' => strtolower($subtask->priority),
                        'time_logged' => $subtask->time_logged ?? 0,
                        'user_name' => optional($subtask->employee?->user)->name ?? 'Unknown'
                    ];
                })->values(),

                'team_members' => Employee::all()->map(function ($emp) {
                    if ($emp->user) {
                        return [
                            'id' => $emp->id,
                            'name' => optional($emp->user)->name ?? 'Unknown',
                            'role' => optional($emp->designations)->name ?? 'Employee',
                        ];
                    }
                    return null;
                })->filter()->values(),

            ];
        });

        return response()->json(['tasks' => $formattedTasks]);
    }


    public function storeSubtask(Request $request)
    {
        $request->validate([
            'task_id' => 'required|integer|exists:tasks,id',
            'subtasks' => 'required|array',
            'subtasks.*.title' => 'required|string|max:255',
            'subtasks.*.priority' => 'required|string',
            'subtasks.*.status' => 'required|string',
            'subtasks.*.description' => 'nullable|string',
        ]);
        $savedSubtasks = [];

        $task = Task::findOrFail($request->task_id);
        $employee_id = Employee::where('user_id', Auth::id())->value('id');

        foreach ($request->subtasks as $subtaskData) {
            $subtask = Subtask::create([
                'task_id' => $request->task_id,
                'title' => $subtaskData['title'],
                'project_id' => $task->project_id,
                'user_id' => $employee_id,
                'description' => $subtaskData['description'],
                'priority' => $subtaskData['priority'],
                'status' => $subtaskData['status'],
            ]);
            $savedSubtasks[] = $subtask;
        }

        return response()->json([
            'message' => 'Subtasks saved successfully',
            'data' => $savedSubtasks
        ], 201);
    }



    private function calculateUserProgress($userSubtasks)
    {
        $total = $userSubtasks->count();
        if ($total === 0) return 0;

        $completed = $userSubtasks->where('status', 'Completed')->count();
        return round(($completed / $total) * 100);
    }


    public function startTimer(Request $request, $subtaskId)
    {
        $employee = Employee::where('user_id', Auth::id())->first();

        $subtask = Subtask::where('id', $subtaskId)
            ->where('user_id', $employee->id)
            ->first();

        if (!$subtask) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $existingTimer = TimerLog::getActiveTimerForEmployee($employee->id);
        if ($existingTimer) {
            $duration = $existingTimer->stop();

            if ($existingTimer->subtask_id) {
                $previousSubtask = Subtask::find($existingTimer->subtask_id);
                if ($previousSubtask) {
                    $previousSubtask->increment('time_logged', $duration);
                }
            }
        }

        $timerLog = TimerLog::create([
            'employee_id' => $employee->id,
            'task_id' => $subtask->task_id,
            'subtask_id' => $subtask->id,
            'title' => $subtask->title,
            'started_at' => Carbon::now(),
            'status' => 'active'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Timer started',
            'timer_id' => $timerLog->id,
            'started_at' => $timerLog->started_at->toISOString()
        ]);
    }

    public function pauseTimer(Request $request, $subtaskId)
    {
        $employee = Employee::where('user_id', Auth::id())->first();

        $timerLog = TimerLog::where('employee_id', $employee->id)
            ->where('subtask_id', $subtaskId)
            ->where('status', 'active')
            ->first();

        if (!$timerLog) {
            return response()->json(['error' => 'No active timer found'], 404);
        }

        $duration = $timerLog->stop();

        $subtask = Subtask::find($subtaskId);
        if ($subtask) {
            $subtask->increment('time_logged', $duration);

            if ($subtask->task) {
                $subtask->task->increment('time_logged', $duration);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Timer stopped and time logged',
            'duration' => $duration,
            'formatted_duration' => $timerLog->getFormattedDuration()
        ]);
    }

    public function getActiveTimer(Request $request)
    {
        $employee = Employee::where('user_id', Auth::id())->first();

        $activeTimer = TimerLog::getActiveTimerForEmployee($employee->id);

        if (!$activeTimer) {
            return response()->json(['active_timer' => null]);
        }

        return response()->json([
            'active_timer' => [
                'id' => $activeTimer->id,
                'subtask_id' => $activeTimer->subtask_id,
                'task_id' => $activeTimer->task_id,
                'title' => $activeTimer->title,
                'started_at' => $activeTimer->started_at->toISOString(),
                'current_duration' => $activeTimer->getCurrentDuration(),
                'formatted_duration' => $activeTimer->getFormattedDuration(),
                'status' => $activeTimer->status
            ]
        ]);
    }

    public function logTime(Request $request, $taskId)
    {
        $employee = Employee::where('user_id', Auth::id())->first();
        $request->validate([
            'time' => 'required|integer|min:0',
            'subtask_id' => 'nullable|exists:subtasks,id'
        ]);

        if ($request->subtask_id) {
            $subtask = Subtask::where('id', $request->subtask_id)
                ->where('user_id', $employee->id)
                ->first();

            if ($subtask) {
                $subtask->increment('time_logged', $request->time);

                TimerLog::create([
                    'employee_id' => $employee->id,
                    'task_id' => $subtask->task_id,
                    'subtask_id' => $subtask->id,
                    'title' => $subtask->title,
                    'started_at' => Carbon::now()->subSeconds($request->time),
                    'ended_at' => Carbon::now(),
                    'duration_seconds' => $request->time,
                    'status' => 'completed',
                    'notes' => 'Manual time entry'
                ]);

                return response()->json(['success' => true, 'message' => 'Time logged to subtask']);
            }
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }

    public function getTimerHistory(Request $request)
    {
        $employee = Employee::where('user_id', Auth::id())->first();

        $timers = TimerLog::where('employee_id', $employee->id)
            ->with(['task', 'subtask'])
            ->orderBy('started_at', 'desc')
            ->paginate(20);

        return response()->json($timers);
    }

    public function autoSaveTimer(Request $request, $subtaskId)
    {
        $employee = Employee::where('user_id', Auth::id())->first();

        $timerLog = TimerLog::where('employee_id', $employee->id)
            ->where('subtask_id', $subtaskId)
            ->where('status', 'active')
            ->first();

        if ($timerLog) {
            $currentDuration = $timerLog->getCurrentDuration();

            return response()->json([
                'success' => true,
                'current_duration' => $currentDuration,
                'formatted_duration' => $timerLog->getFormattedDuration()
            ]);
        }

        return response()->json(['error' => 'No active timer found'], 404);
    }
    public function updateSubtaskStatus(Request $request, $subtaskId)
    {
        $employee = Employee::where('user_id', Auth::id())->first();

        $request->validate([
            'status' => 'required|in:Pending,In Progress,Completed,On Hold'
        ]);

        $subtask = Subtask::with('task')->where('id', $subtaskId)
            ->where('user_id', $employee->id)
            ->first();

        if (!$subtask) {
            return response()->json(['error' => 'Subtask not found or unauthorized'], 404);
        }

        $subtask->update(['status' => $request->status]);

        if ($subtask->task && $subtask->task->areAllSubtasksComplete()) {
            $subtask->task->update(['status' => 'Completed']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Subtask status updated',
            'subtask' => $subtask
        ]);
    }

    public function getTaskStats()
    {
        $employee = Employee::where('user_id', Auth::id())->first();

        if (!$employee) {
            return response()->json([
                'totalTasks' => 0,
                'activeTasks' => 0,
                'completedTasks' => 0,
                'overdueTasks' => 0
            ]);
        }

        $tasks = Task::whereHas('subtasks', function ($query) use ($employee) {
            $query->where('user_id', $employee->id);
        })->get();

        $stats = [
            'totalTasks' => $tasks->count(),
            'activeTasks' => $tasks->where('status', 'In Progress')->count(),
            'completedTasks' => $tasks->where('status', 'Completed')->count(),
            'overdueTasks' => $tasks->filter(function ($task) {
                return now()->gt($task->end_date_time) && $task->status !== 'Completed';
            })->count()
        ];

        return response()->json($stats);
    }

    function createSupportRequest(Request $request)
    {
        dd($request->all());
        return response()->json(['message' => 'Support request created successfully']);
    }
}
