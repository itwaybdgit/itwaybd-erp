<?php

namespace App\Http\Controllers\Admin\Task;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use App\Models\TaskMessage;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::get();


        // $totalTasks = $project->tasks->count();
        // $completedTasks = $project->tasks->where('status', 'Completed')->count();
        // $completionPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

        return view('admin.pages.ProjectManagement.task.index', get_defined_vars());
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
        // Create a new task instance
        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->start_date_time = $request->start_date_time;
        $task->end_date_time = $request->end_date_time;
        $task->status = $request->status;
        $task->priority = $request->priority;
        $task->project_id = $request->project_id;
        $task->user_id = $request->user_id;

        // Handle image upload if exists
        if ($request->hasFile('image')) {
            $task->image_path = $request->file('image')->store('tasks', 'public');
        }

        $task->save();

        // Save messages and collect their IDs
        $messageIds = [];
        if ($request->has('messages') && is_array($request->messages)) {
            foreach ($request->messages as $message) {
                if (!empty(trim($message))) {
                    $taskMessage = TaskMessage::create([
                        'task_id' => $task->id,
                        'message' => $message,
                    ]);
                    $messageIds[] = $taskMessage->id;
                }
            }
        }

        // Update task with message_ids JSON column if messages exist
        if (!empty($messageIds)) {
            $task->message_ids = $messageIds;
            $task->save();
        }

        return redirect()->route('task.index')->with('success', 'Task created successfully!');
    }


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
    public function edit($id)
    {

        $task = Task::findOrFail($id);
        $projects = Project::all();
        $users = User::all();
        $taskMessages = TaskMessage::where('task_id', $task->id)->get();


        return view('admin.pages.ProjectManagement.task.edit', get_defined_vars());
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $task = Task::findOrFail($id);


        $task->title = $request->title;
        $task->description = $request->description;
        $task->start_date_time = $request->start_date_time;
        $task->end_date_time = $request->end_date_time;
        $task->status = $request->status;
        $task->priority = $request->priority;
        $task->project_id = $request->project_id;
        $task->user_id = $request->user_id;


        if ($request->hasFile('image')) {

            // Storage::disk('public')->delete($task->image_path);
            $task->image_path = $request->file('image')->store('tasks', 'public') ?? '';
        }


        $messageIds = [];

        if ($request->has('messages') && is_array($request->messages)) {
            foreach ($request->messages as $message) {
                $message = trim($message);
                if (!empty($message)) {
                    $taskMessage = TaskMessage::create([
                        'task_id' => $task->id,
                        'message' => $message,
                    ]);
                    $messageIds[] = $taskMessage->id;
                }
            }
        }

        $task->message_ids = $messageIds;
        $task->save();

        return redirect()->route('task.index')->with('success', 'Task updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $task = Task::findOrFail($id);
        $task->delete();
        return view('admin.pages.ProjectManagement.task.index');
    }

    public function taskmessage_destory($id)
    {

        TaskMessage::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
