<?php

namespace App\Http\Controllers\Admin\ProjectManager;

use App\Http\Controllers\Controller;
use App\Models\BandwidthCustomer;
use App\Models\Employee;
use App\Models\Modules;
use App\Models\Submodules;
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

        $projects = Project::orderby('id','desc')->get();

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
//   public function store(Request $request)
//{
//    $validatedData = $request->validate([
//        'name' => 'required|string|max:255',
//        'starting_date' => 'required|date',
//        'ending_date' => 'required|date|after_or_equal:starting_date',
//        'description' => 'nullable|string',
//        'hypercare_months' => 'required_if:hypercare,1|nullable|integer|min:1',
//        'client_id' => 'nullable',
//        'status' => 'required|in:planning,in_progress,on_hold,completed,cancelled',
//        'priority' => 'required|in:low,medium,high,urgent',
//        'estimated_hours' => 'nullable|numeric|min:0',
//        'progress' => 'nullable|numeric|min:0|max:100',
//        'budget' => 'nullable|numeric|min:0',
//        'tags' => 'nullable|array',
//        'tags.*' => 'string|max:50',
//        'notes' => 'nullable|string',
//        'team_members' => 'nullable|array',
//        'team_members.*' => 'integer|exists:users,id',
//    ]);
//
//    // Convert status to boolean for database storage
//    $validatedData['status'] = ($validatedData['status'] === 'completed');
//
//    // Convert tags array to JSON
//    if (isset($validatedData['tags'])) {
//        $validatedData['tags'] = json_encode($validatedData['tags']);
//    }
//
//    DB::transaction(function () use ($validatedData) {
//        // Extract team members before creating project
//        $teamMembers = $validatedData['team_members'] ?? [];
//        unset($validatedData['team_members']);
//
//        // Create project
//        $project = Project::create($validatedData);
//
//        // Add team members to project_members table
//        foreach ($teamMembers as $memberId) {
//            ProjectMember::create([
//                'project_id' => $project->id,
//                'member_id' => $memberId,
//            ]);
//        }
//    });
//
//    return redirect()->route('project.index')->with('success', 'Project created successfully!');
//}

    public function store(Request $request)
    {
        //dd($request->all());
        $rr =$request->validate([
            'project_name' => 'required|string|max:255',
            'modules' => 'required|array|min:1',
            'modules.*.name' => 'required|string|max:255',
            'modules.*.description' => 'nullable|string',
            'modules.*.submodules' => 'nullable|array',
            'modules.*.submodules.*.name' => 'required|string|max:255',
            'modules.*.submodules.*.description' => 'nullable|string',
        ]);
        //dd($rr);

        try {
            DB::beginTransaction();

            // Create the project
            $project = Project::create([
                'name' => $request->project_name
            ]);

            // Loop through modules
            if ($request->has('modules')) {
                foreach ($request->modules as $moduleData) {
                    // Create module
                    $module = $project->modules()->create([
                        'name' => $moduleData['name'],
                        'description' => $moduleData['description'] ?? null
                    ]);

                    // Create sub-modules if they exist
                    if (isset($moduleData['submodules']) && is_array($moduleData['submodules'])) {
                        foreach ($moduleData['submodules'] as $subModuleData) {
                            $module->subModules()->create([
                                'name' => $subModuleData['name'],
                                'description' => $subModuleData['description'] ?? null
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return redirect()->route('project.index')
                ->with('success', 'Project created successfully with modules and sub-modules!');

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage().'-'.$e->getLine());

//            return redirect()->back()
//                ->withInput()
//                ->with('error', 'Failed to create project: ' . $e->getMessage());
        }
    }
    public function storeAjax(Request $request)
    {
        $request->validate([
            'project_name' => 'required|string|max:255'
        ]);

        try {
            DB::beginTransaction();

            // Create the project
            $project = Project::create([
                'name' => $request->project_name
            ]);

            // Loop through modules
            if ($request->has('modules')) {
                foreach ($request->modules as $moduleData) {
                    // Create module
                    $module = $project->modules()->create([
                        'name' => $moduleData['name'],
                        'description' => $moduleData['description'] ?? null
                    ]);

                    // Create sub-modules if they exist
                    if (isset($moduleData['submodules']) && is_array($moduleData['submodules'])) {
                        foreach ($moduleData['submodules'] as $subModuleData) {
                            $module->subModules()->create([
                                'name' => $subModuleData['name'],
                                'description' => $subModuleData['description'] ?? null
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'project' => $project
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage().'-'.$e->getLine());

//            return redirect()->back()
//                ->withInput()
//                ->with('error', 'Failed to create project: ' . $e->getMessage());
        }
    }
    public function storeModuleAjax(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $module = Modules::create([
            'project_id' => $request->project_id,
            'name' => $request->name,
            'description' => $request->description
        ]);

        return response()->json([
            'success' => true,
            'module' => $module
        ]);
    }
    public function storeSubmoduleAjax(Request $request)
    {

        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);
        //dd( $request->module_id);

        $submodule = Submodules::create([
            'modules_id' => $request->module_id,
            'name' => $request->name,
            'description' => $request->description
        ]);

        return response()->json([
            'success' => true,
            'submodule' => $submodule
        ]);
    }
    public function getModules($projectId)
    {
        $modules = Modules::where('project_id', $projectId)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json([
            'success' => true,
            'modules' => $modules
        ]);
    }
    public function getSubModules($moduleId)
    {
        $submodules = Submodules::where('modules_id', $moduleId)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json([
            'success' => true,
            'submodules' => $submodules
        ]);
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
        'team_members.*' => 'integer',
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
