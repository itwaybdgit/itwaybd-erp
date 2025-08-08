<?php

namespace App\Http\Controllers\Admin\Task;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\Subtask;
use App\Models\User;
use App\Models\Employee;
use App\Models\TaskMessage;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{

    public function index(Request $request)
    {
        $query = Task::with(['project', 'assignedUsers', 'subtasks'])
            ->orderBy('created_at', 'desc');

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('priority') && $request->priority != '') {
            $query->where('priority', $request->priority);
        }

        if ($request->has('project_id') && $request->project_id != '') {
            $query->where('project_id', $request->project_id);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $tasks = $query->paginate(15);
        $projects = Project::all();

        return view('admin.pages.ProjectManagement.task.index', get_defined_vars());
    }


    public function getProjectUsers($projectId)
    {
        try {
            $projectMembers = ProjectMember::where('project_id', $projectId)->get();

            $memberIds = $projectMembers->pluck('member_id');

            $users = Employee::whereIn('id', $memberIds)
                ->select('id', 'name', 'email')
                ->get();

            return response()->json([
                'success' => true,
                'users' => $users,
                'message' => 'Users fetched successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching users: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getTeamUsers($teamId)
    {
        try {
            $employees = Employee::whereHas('teams', function ($query) use ($teamId) {
                $query->where('team', $teamId);
            })->get(['id', 'name']);

            return response()->json([
                'success' => true,
                'employees' => $employees
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch team employees' . $e->getMessage()
            ], 500);
        }
    }

    public function getTeamProjects($teamId)
    {
        try {
            $projects = Project::orderBy('name')
                ->get(['id', 'name']);

            return response()->json([
                'success' => true,
                'projects' => $projects
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch projects: ' . $e->getMessage()
            ], 500);
        }
    }

    public function create()
    {
        $projects = Project::get();
        $users = User::get();
        $teams = Team::get();
        return view('admin.pages.ProjectManagement.task.create', get_defined_vars());
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'team_id' => 'required',
            'start_date_time' => 'required|date',
            'end_date_time' => 'required|date|after:start_date_time',
            // 'status' => 'required|in:Pending,In Progress,Completed',
            // 'priority' => 'required|in:Low,Medium,High',
            // 'project_id' => 'required|exists:projects,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'subtasks.*.title' => 'required|string|max:255',
            'subtasks.*.user_id' => 'required',
            'subtasks.*.description' => 'nullable|string',
            'subtasks.*.priority' => 'nullable|in:Low,Medium,High,Critical',
            'subtasks.*.status' => 'nullable|in:Pending,In Progress,Completed',
        ]);
        DB::beginTransaction();

        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('tasks', 'public');
            }

            $task = Task::create([
                'title' => $request->title,
                'description' => $request->description,
                'start_date_time' => $request->start_date_time,
                'end_date_time' => $request->end_date_time,
                'status' => $request->status,
                'team_id' => $request->team_id,
                'priority' => $request->priority,
                'project_id' => $request->project_id,
                'image' => $imagePath,
                'created_by' => Auth::id(),
            ]);

            if ($request->has('subtasks') && is_array($request->subtasks)) {
                foreach ($request->subtasks as $subtaskData) {
                    Subtask::create([
                        'task_id' => $task->id,
                        'title' => $subtaskData['title'],
                        'project_id' => $subtaskData['project_id'],
                        'description' => $subtaskData['description'] ?? '',
                        'user_id' => $subtaskData['user_id'],
                        'priority' => $subtaskData['priority'] ?? 'Medium',
                        'status' => $subtaskData['status'] ?? 'Pending',
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('task.index')
                ->with('success', 'Task created successfully with ' . count($request->subtasks ?? []) . ' subtasks!');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            return back()->withErrors(['error' => 'Failed to create task: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function show($id) {}



    public function edit($id = null)
    {

        $task = Task::with(['subtasks', 'team', 'project'])->findOrFail($id);

        $teams = Team::select('id', 'name')->get();

        $projects = Project::select('id', 'name')->get();
        $teamEmployees = [];
        if ($task->team_id) {
            $teamEmployees = Employee::where('team', $task->team_id)
            ->select('id', 'name')
            ->get();
        }

        $teamProjects = [];
        if ($task->team && $this->isTechTeam($task->team)) {
            $teamProjects = Project::select('id', 'name')->get();
        }

        return view('admin.pages.ProjectManagement.task.edit', get_defined_vars());
    }

    public function update(Request $request, $id = null)
    {
        $task = Task::with('subtasks')->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'team_id' => 'required',
            'start_date_time' => 'required|date',
            'end_date_time' => 'required|date|after:start_date_time',
            // 'status' => 'required|in:Pending,In Progress,Completed',
            // 'priority' => 'required|in:Low,Medium,High',
            // 'project_id' => 'required|exists:projects,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'subtasks.*.title' => 'required|string|max:255',
            'subtasks.*.user_id' => 'required',
            'subtasks.*.description' => 'nullable|string',
            'subtasks.*.priority' => 'nullable|in:Low,Medium,High,Critical',
            'subtasks.*.status' => 'nullable|in:Pending,In Progress,Completed',
        ]);

        DB::beginTransaction();

        try {
            $imagePath = $task->image;

            if ($request->hasFile('image')) {
                if ($task->image && Storage::disk('public')->exists($task->image)) {
                    Storage::disk('public')->delete($task->image);
                }

                $imagePath = $request->file('image')->store('tasks', 'public');
            }

            $task->update([
                'title' => $request->title,
                'description' => $request->description,
                'start_date_time' => $request->start_date_time,
                'end_date_time' => $request->end_date_time,
                'status' => $request->status,
                'team_id' => $request->team_id,
                'priority' => $request->priority,
                'project_id' => $request->project_id,
                'image' => $imagePath,
                'updated_by' => Auth::id(),
            ]);

            $existingSubtaskIds = $task->subtasks->pluck('id')->toArray();
            $submittedSubtaskIds = [];

            if ($request->has('subtasks') && is_array($request->subtasks)) {
                foreach ($request->subtasks as $index => $subtaskData) {
                    if (isset($subtaskData['id']) && !empty($subtaskData['id'])) {
                        $subtask = Subtask::find($subtaskData['id']);
                        if ($subtask && $subtask->task_id == $task->id) {
                            $subtask->update([
                                'title' => $subtaskData['title'],
                                'project_id' => $subtaskData['project_id'] ?? 0,
                                'description' => $subtaskData['description'] ?? '',
                                'user_id' => $subtaskData['user_id'],
                                'priority' => $subtaskData['priority'] ?? 'Medium',
                                'status' => $subtaskData['status'] ?? 'Pending',
                            ]);
                            $submittedSubtaskIds[] = $subtask->id;
                        }
                    } else {
                        $newSubtask = Subtask::create([
                            'task_id' => $task->id,
                            'title' => $subtaskData['title'],
                            'project_id' => $subtaskData['project_id'] ?? 0,
                            'description' => $subtaskData['description'] ?? '',
                            'user_id' => $subtaskData['user_id'],
                            'priority' => $subtaskData['priority'] ?? 'Medium',
                            'status' => $subtaskData['status'] ?? 'Pending',
                        ]);
                        $submittedSubtaskIds[] = $newSubtask->id;
                    }
                }
            }

            $subtasksToDelete = array_diff($existingSubtaskIds, $submittedSubtaskIds);
            if (!empty($subtasksToDelete)) {
                Subtask::whereIn('id', $subtasksToDelete)->delete();
            }

            DB::commit();

            $subtaskCount = count($request->subtasks ?? []);
            return redirect()->route('task.index')
                ->with('success', "Task updated successfully with {$subtaskCount} subtasks!");
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->hasFile('image') && $imagePath && $imagePath !== $task->image) {
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }

            return back()->withErrors(['error' => 'Failed to update task: ' . $e->getMessage()])
                ->withInput();
        }
    }


    private function isTechTeam($team)
    {
        if (!$team || !$team->name) return false;

        $teamName = strtolower(trim($team->name));
        return $teamName === 'tech' || $teamName === 'tech team' || strpos($teamName, 'tech') !== false;
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $task = Task::find($id);
            if ($task->image && Storage::disk('public')->exists($task->image)) {
                Storage::disk('public')->delete($task->image);
            }

            $task->delete();
            DB::commit();

            return redirect()->route('task.index')
                ->with('success', 'Task deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to delete task: ' . $e->getMessage()]);
        }
    }


    public function taskmessage_destory($id)
    {

        TaskMessage::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
