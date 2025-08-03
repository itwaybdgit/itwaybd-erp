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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Task::with(['project', 'assignedUsers', 'subtasks'])
            ->orderBy('created_at', 'desc');

        // Apply filters
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


    // public function index()
    // {
    //     $tasks = Task::get();


    
    //     return view('admin.pages.ProjectManagement.task.index', get_defined_vars());
    // }

    public function getProjectUsers($projectId)
{
    try {
        $projectMembers = ProjectMember::where('project_id', $projectId)->get();

        // Extract all member_ids
        $memberIds = $projectMembers->pluck('member_id');

        // Get users with those IDs
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


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::get();
        $users = User::get();
        return view('admin.pages.ProjectManagement.task.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

 public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date_time' => 'required|date',
            'end_date_time' => 'required|date|after:start_date_time',
            'status' => 'required|in:Pending,In Progress,Completed',
            'priority' => 'required|in:Low,Medium,High',
            'project_id' => 'required|exists:projects,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'subtasks.*.title' => 'required|string|max:255',
            'subtasks.*.user_id' => 'required',
            'subtasks.*.description' => 'nullable|string',
            'subtasks.*.priority' => 'nullable|in:Low,Medium,High,Critical',
            'subtasks.*.status' => 'nullable|in:Pending,In Progress,Completed',
        ]);

        DB::beginTransaction();

        try {
            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('tasks', 'public');
            }

            // Create the main task
            $task = Task::create([
                'title' => $request->title,
                'description' => $request->description,
                'start_date_time' => $request->start_date_time,
                'end_date_time' => $request->end_date_time,
                'status' => $request->status,
                'priority' => $request->priority,
                'project_id' => $request->project_id,
                'image' => $imagePath,
                'created_by' => Auth::id(),
            ]);

            // Create subtasks if provided
            if ($request->has('subtasks') && is_array($request->subtasks)) {
                foreach ($request->subtasks as $subtaskData) {
                    Subtask::create([
                        'task_id' => $task->id,
                        'title' => $subtaskData['title'],
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
            
            // Delete uploaded image if exists
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            return back()->withErrors(['error' => 'Failed to create task: ' . $e->getMessage()])
                ->withInput();
        }
    }
    // public function store(Request $request)
    // {
      
    //     $task = new Task();
    //     $task->title = $request->title;
    //     $task->description = $request->description;
    //     $task->start_date_time = $request->start_date_time;
    //     $task->end_date_time = $request->end_date_time;
    //     $task->status = $request->status;
    //     $task->priority = $request->priority;
    //     $task->project_id = $request->project_id;
    //     $task->user_id = $request->user_id;
    //     $task->userStatus = 'acitve';


    //     if ($request->hasFile('image')) {
    //         $task->image_path = $request->file('image')->store('tasks', 'public');
    //     }

    //     $task->save();

    
    //     $messageIds = [];
    //     if ($request->has('messages') && is_array($request->messages)) {
    //         foreach ($request->messages as $message) {
    //             if (!empty(trim($message))) {
    //                 $taskMessage = TaskMessage::create([
    //                     'task_id' => $task->id,
    //                     'message' => $message,
    //                 ]);
    //                 $messageIds[] = $taskMessage->id;
    //             }
    //         }
    //     }

  
    //     if (!empty($messageIds)) {
    //         $task->message_ids = $messageIds;
    //         $task->save();
    //     }

    //     return redirect()->route('task.index')->with('success', 'Task created successfully!');
    // }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {

    //     $task = Task::findOrFail($id);
    //     $projects = Project::all();
    //     $users = User::all();
    //     $taskMessages = TaskMessage::where('task_id', $task->id)->get();


    //     return view('admin.pages.ProjectManagement.task.edit', get_defined_vars());
    // }

     public function edit($id =null)
    {
       

           $task = Task::with('subtasks')->findOrFail($id);
    
        // $task->load(['subtasks']);
        
        $projects = Project::get();
        
        return view('admin.pages.ProjectManagement.task.edit', get_defined_vars());
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {

    //     $task = Task::findOrFail($id);


    //     $task->title = $request->title;
    //     $task->description = $request->description;
    //     $task->start_date_time = $request->start_date_time;
    //     $task->end_date_time = $request->end_date_time;
    //     $task->status = $request->status;
    //     $task->priority = $request->priority;
    //     $task->project_id = $request->project_id;
    //     $task->user_id = $request->user_id;
    //      $task->userStatus = 'acitve';


    //     if ($request->hasFile('image')) {

          
    //         $task->image_path = $request->file('image')->store('tasks', 'public') ?? '';
    //     }


    //     $messageIds = [];

    //     if ($request->has('messages') && is_array($request->messages)) {
    //         foreach ($request->messages as $message) {
    //             $message = trim($message);
    //             if (!empty($message)) {
    //                 $taskMessage = TaskMessage::create([
    //                     'task_id' => $task->id,
    //                     'message' => $message,
    //                 ]);
    //                 $messageIds[] = $taskMessage->id;
    //             }
    //         }
    //     }

    //     $task->message_ids = $messageIds;
    //     $task->save();

    //     return redirect()->route('task.index')->with('success', 'Task updated successfully!');
    // }

      public function update(Request $request, $id = null)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date_time' => 'required|date',
            'end_date_time' => 'required|date|after:start_date_time',
            'status' => 'required|in:Pending,In Progress,Completed',
            'priority' => 'required|in:Low,Medium,High',
            'project_id' => 'required|exists:projects,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'subtasks.*.title' => 'required|string|max:255',
            'subtasks.*.user_id' => 'required',
            'subtasks.*.description' => 'nullable|string',
            'subtasks.*.priority' => 'nullable|in:Low,Medium,High,Critical',
            'subtasks.*.status' => 'nullable|in:Pending,In Progress,Completed',
        ]);
        //    dd($request->all());
        DB::beginTransaction();

        try {
            // Handle image upload
            $task = Task::find($id);
            if ($request->hasFile('image')) {
                // Delete old image
                if ($task->image && Storage::disk('public')->exists($task->image)) {
                    Storage::disk('public')->delete($task->image);
                }
                
                $imagePath = $request->file('image')->store('tasks', 'public');
                $task->image = $imagePath;
            }

            // Update the main task
            $task->update([
                'title' => $request->title,
                'description' => $request->description,
                'start_date_time' => $request->start_date_time,
                'end_date_time' => $request->end_date_time,
                'status' => $request->status,
                'priority' => $request->priority,
                'project_id' => $request->project_id,
                'updated_by' => Auth::id(),
            ]);

            // Update subtasks
            if ($request->has('subtasks') && is_array($request->subtasks)) {
                // Delete existing subtasks
                $task->subtasks()->delete();

                // Create new subtasks
                foreach ($request->subtasks as $subtaskData) {
                    Subtask::create([
                        'task_id' => $task->id,
                        'title' => $subtaskData['title'],
                        'description' => $subtaskData['description'] ?? '',
                        'user_id' => $subtaskData['user_id'],
                        'priority' => $subtaskData['priority'] ?? 'Medium',
                        'status' => $subtaskData['status'] ?? 'Pending',
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('task.index')
                ->with('success', 'Task updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update task: ' . $e->getMessage()])
                ->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {

    //     $task = Task::findOrFail($id);
    //     $task->delete();
    //     return view('admin.pages.ProjectManagement.task.index');
    // }



     public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $task = Task::find($id);
            // Delete associated image
            if ($task->image && Storage::disk('public')->exists($task->image)) {
                Storage::disk('public')->delete($task->image);
            }

            // Delete task (subtasks and messages will be deleted via cascade)
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
