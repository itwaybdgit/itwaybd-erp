<?php

namespace App\Http\Controllers\Admin\ProjectManager;

use App\Http\Controllers\Controller;
use App\Models\BandwidthCustomer;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\Task;
use App\Models\TaskMessage;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $projects = Project::with('getTasks')->get();

        return view('admin.pages.ProjectManagement.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $users = Employee::get();
         $clients = BandwidthCustomer::get();
        return view('admin.pages.ProjectManagement.create', compact('users','clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'starting_date' => 'required|date',
        'ending_date' => 'required|date|after_or_equal:starting_date',
        'description' => 'nullable|string',
        'hypercare_months' => 'required_if:hypercare,1|nullable|integer|min:1',
        'client_id' => 'nullable',
        'status' => 'required|in:planning,in_progress,on_hold,completed,cancelled',
        'priority' => 'required|in:low,medium,high,urgent',
        'estimated_hours' => 'nullable|numeric|min:0',
        'progress' => 'nullable|numeric|min:0|max:100',
        'budget' => 'nullable|numeric|min:0',
        'tags' => 'nullable|array',
        'tags.*' => 'string|max:50',
        'notes' => 'nullable|string',
        'team_members' => 'nullable|array',
        'team_members.*' => 'integer|exists:users,id',
    ]);

    // Convert status to boolean for database storage
    $validatedData['status'] = ($validatedData['status'] === 'completed');
    
    // Convert tags array to JSON
    if (isset($validatedData['tags'])) {
        $validatedData['tags'] = json_encode($validatedData['tags']);
    }

    DB::transaction(function () use ($validatedData) {
        // Extract team members before creating project
        $teamMembers = $validatedData['team_members'] ?? [];
        unset($validatedData['team_members']);
        
        // Create project
        $project = Project::create($validatedData);
        
        // Add team members to project_members table
        foreach ($teamMembers as $memberId) {
            ProjectMember::create([
                'project_id' => $project->id,
                'member_id' => $memberId,
            ]);
        }
    });

    return redirect()->route('project.index')->with('success', 'Project created successfully!');
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
        dd('show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $users = Employee::get();
         $clients = BandwidthCustomer::get();
         $teamMember = ProjectMember::where('project_id',$id)->get();
         $selectedMemberIds = $teamMember->pluck('member_id')->toArray();
        //  dd($teamMember);
        return view('admin.pages.ProjectManagement.edit', get_defined_vars());
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
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'starting_date' => 'required|date',
        'ending_date' => 'required|date|after_or_equal:starting_date',
        'description' => 'nullable|string',
        'hypercare_months' => 'required_if:hypercare,1|nullable|integer|min:1',
        'client_id' => 'nullable',
        'status' => 'required|in:planning,in_progress,on_hold,completed,cancelled',
        'priority' => 'required|in:low,medium,high,urgent',
        'estimated_hours' => 'nullable|numeric|min:0',
        'progress' => 'nullable|numeric|min:0|max:100',
        'budget' => 'nullable|numeric|min:0',
        'tags' => 'nullable|array',
        'tags.*' => 'string|max:50',
        'notes' => 'nullable|string',
        'team_members' => 'nullable|array',
        'team_members.*' => 'integer|exists:users,id',
    ]);

    // Convert status to boolean
    $validatedData['status'] = ($validatedData['status'] === 'completed');

    // Convert tags to JSON
    if (isset($validatedData['tags'])) {
        $validatedData['tags'] = json_encode($validatedData['tags']);
    }

    DB::transaction(function () use ($validatedData, $id) {
        // Get project instance
        $project = Project::findOrFail($id);

        // Extract team members
        $teamMembers = $validatedData['team_members'] ?? [];
        unset($validatedData['team_members']);

        // Update the project
        $project->update($validatedData);

        // Remove old team members
        ProjectMember::where('project_id', $project->id)->delete();

        // Add new team members
        foreach ($teamMembers as $memberId) {
            ProjectMember::create([
                'project_id' => $project->id,
                'member_id' => $memberId,
            ]);
        }
    });

    return redirect()->route('project.index')->with('success', 'Project updated successfully!');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return redirect()->route('project.index')->with('success', 'Project deleted successfully!');
    }
}
