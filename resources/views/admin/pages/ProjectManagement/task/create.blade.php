@extends('admin.master')

{{-- jQuery & Select2 --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />--}}

<style>
    .input-group-append {
        margin-left: -1px;
    }

    .btn-icon {
        width: 38px;
        height: 38px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .select2-container {
        width: 100% !important;
    }

    .select2-container .select2-selection--single {
        height: 38px !important;
        padding: 4px 12px;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        line-height: 28px !important;
    }

    .form-section {
        background: #f8f9fc;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
</style>

@section('content')
    <section id="task-create-section">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-primary">Create New Task</h4>
                        <a href="{{ route('task.index') }}" class="btn btn-outline-secondary">
                            <i class="fa fa-arrow-left mr-1"></i> Back
                        </a>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('task.store') }}" method="POST" id="taskForm">
                        @csrf

                        <!-- Project Selection -->
                            <div class="form-section">
                                <h5 class="mb-3 text-secondary">Project Association</h5>

                                <div class="form-group">
                                    <label class="form-label font-weight-semibold">Project <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select name="project_id" id="project_id" class="form-control select2" required>
                                            <option value="">Select Project</option>
                                            @foreach($projects as $project)
                                                <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                                    {{ $project->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary btn-icon" data-toggle="modal" data-target="#addProjectModal" title="Add New Project">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @error('project_id')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label font-weight-semibold">Module <span class="text-muted">(Optional)</span></label>
                                    <div class="input-group">
                                        <select name="module_id" id="module_id" class="form-control select2" disabled>
                                            <option value="">Select Module</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary btn-icon" id="addModuleBtn" data-toggle="modal" data-target="#addModuleModal" title="Add New Module" disabled>
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @error('module_id')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group mb-0">
                                    <label class="form-label font-weight-semibold">Sub-module <span class="text-muted">(Optional)</span></label>
                                    <div class="input-group">
                                        <select name="sub_module_id" id="sub_module_id" class="form-control select2" disabled>
                                            <option value="">Select Sub-module</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary btn-icon" id="addSubModuleBtn" data-toggle="modal" data-target="#addSubModuleModal" title="Add New Sub-module" disabled>
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @error('sub_module_id')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Task Details -->
                            <div class="form-section">
                                <h5 class="mb-3 text-secondary d-flex justify-content-between align-items-center">
                                    <span>Task Details</span>
                                    <button type="button" class="btn btn-success btn-sm" onclick="addTaskRow()">
                                        <i class="fa fa-plus mr-1"></i>Add Task
                                    </button>
                                </h5>

                                <div id="taskRowsContainer">
                                    <!-- Initial Task Row -->
                                    <div class="task-row mb-3" data-row="1">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-2">
                                                    <label class="form-label font-weight-semibold">Task Name <span class="text-danger">*</span></label>
                                                    <input type="text" name="task_name[]" class="form-control"
                                                           placeholder="Enter task name" required>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="form-group mb-2">
                                                    <label class="form-label font-weight-semibold">Task Details <span class="text-danger">*</span></label>
                                                    <textarea name="task_details[]" class="form-control" rows="2"
                                                              placeholder="Enter task details and requirements..." required></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-1 d-flex align-items-end">
                                                <div class="form-group mb-2">
                                                    <button type="button" class="btn btn-danger btn-icon" onclick="removeTaskRow(this)" disabled>
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary btn-lg px-4">
                                    <i class="fa fa-check mr-2"></i>Create Task
                                </button>
                                <button type="reset" class="btn btn-outline-secondary btn-lg px-4">
                                    <i class="fa fa-redo mr-2"></i>Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Add Project Modal -->
    <div class="modal fade" id="addProjectModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Project</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Project Name <span class="text-danger">*</span></label>
                        <input type="text" id="new_project_name" class="form-control" placeholder="Enter project name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveProject()">Save Project</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Module Modal -->
    <div class="modal fade" id="addModuleModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Module</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Module Name <span class="text-danger">*</span></label>
                        <input type="text" id="new_module_name" class="form-control" placeholder="Enter module name">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea id="new_module_description" class="form-control" rows="3" placeholder="Module description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveModule()">Save Module</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Sub-module Modal -->
    <div class="modal fade" id="addSubModuleModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Sub-module</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Sub-module Name <span class="text-danger">*</span></label>
                        <input type="text" id="new_submodule_name" class="form-control" placeholder="Enter sub-module name">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <input type="text" id="new_submodule_description" class="form-control" placeholder="Sub-module description">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveSubModule()">Save Sub-module</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Bootstrap 4 & Select2 JS --}}
{{--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>--}}

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                placeholder: function() {
                    return $(this).find('option:first').text();
                },
                allowClear: true
            });

            // Project change event
            $('#project_id').on('change', function() {
                const projectId = $(this).val();
                $('#module_id').html('<option value="">Select Module</option>').prop('disabled', true).trigger('change');
                $('#sub_module_id').html('<option value="">Select Sub-module</option>').prop('disabled', true).trigger('change');
                $('#addModuleBtn').prop('disabled', true);
                $('#addSubModuleBtn').prop('disabled', true);

                if (projectId) {
                    $('#addModuleBtn').prop('disabled', false);
                    $.ajax({
                        url: `/admin/project/${projectId}/modules`,
                        method: 'GET',
                        success: function(response) {
                            let options = '<option value="">Select Module</option>';
                            response.modules.forEach(function(module) {
                                options += `<option value="${module.id}">${module.name}</option>`;
                            });
                            $('#module_id').html(options).prop('disabled', false);
                        },
                        error: function() {
                            alert('Failed to load modules');
                        }
                    });
                }
            });

            // Module change event
            $('#module_id').on('change', function() {
                const moduleId = $(this).val();
                $('#sub_module_id').html('<option value="">Select Sub-module</option>').prop('disabled', true).trigger('change');
                $('#addSubModuleBtn').prop('disabled', true);

                if (moduleId) {
                    $('#addSubModuleBtn').prop('disabled', false);
                    $.ajax({
                        url: `/admin/module/${moduleId}/submodules`,
                        method: 'GET',
                        success: function(response) {
                            let options = '<option value="">Select Sub-module</option>';
                            response.submodules.forEach(function(submodule) {
                                options += `<option value="${submodule.id}">${submodule.name}</option>`;
                            });
                            $('#sub_module_id').html(options).prop('disabled', false);
                        },
                        error: function() {
                            alert('Failed to load sub-modules');
                        }
                    });
                }
            });
        });

        // Save new project
        function saveProject() {
            const projectName = $('#new_project_name').val().trim();
            if (!projectName) {
                alert('Please enter project name');
                return;
            }
            $.ajax({
                url: '{{ route("project.store.ajax") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    project_name: projectName
                },
                success: function(response) {
                    const newOption = new Option(response.project.name, response.project.id, true, true);
                    $('#project_id').append(newOption).trigger('change');
                    $('#addProjectModal').modal('hide');
                    $('#new_project_name').val('');
                    alert('Project added successfully!');
                },
                error: function(xhr) {
                    alert('Failed to create project: ' + (xhr.responseJSON?.message || 'Unknown error'));
                }
            });
        }

        // Save new module
        function saveModule() {
            const projectId = $('#project_id').val();
            const moduleName = $('#new_module_name').val().trim();
            const moduleDescription = $('#new_module_description').val().trim();

            if (!projectId) {
                alert('Please select a project first');
                return;
            }
            if (!moduleName) {
                alert('Please enter module name');
                return;
            }

            $.ajax({
                url: '{{ route("module.store.ajax") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    project_id: projectId,
                    name: moduleName,
                    description: moduleDescription
                },
                success: function(response) {
                    const newOption = new Option(response.module.name, response.module.id, true, true);
                    $('#module_id').append(newOption).trigger('change');
                    $('#addModuleModal').modal('hide');
                    $('#new_module_name').val('');
                    $('#new_module_description').val('');
                    alert('Module added successfully!');
                },
                error: function(xhr) {
                    alert('Failed to create module: ' + (xhr.responseJSON?.message || 'Unknown error'));
                }
            });
        }

        // Save new sub-module
        function saveSubModule() {
            const moduleId = $('#module_id').val();
            const submoduleName = $('#new_submodule_name').val().trim();
            const submoduleDescription = $('#new_submodule_description').val().trim();

            if (!moduleId) {
                alert('Please select a module first');
                return;
            }
            if (!submoduleName) {
                alert('Please enter sub-module name');
                return;
            }

            $.ajax({
                url: '{{ route("submodule.store.ajax") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    module_id: moduleId,
                    name: submoduleName,
                    description: submoduleDescription
                },
                success: function(response) {
                    const newOption = new Option(response.submodule.name, response.submodule.id, true, true);
                    $('#sub_module_id').append(newOption).trigger('change');
                    $('#addSubModuleModal').modal('hide');
                    $('#new_submodule_name').val('');
                    $('#new_submodule_description').val('');
                    alert('Sub-module added successfully!');
                },
                error: function(xhr) {
                    alert('Failed to create sub-module: ' + (xhr.responseJSON?.message || 'Unknown error'));
                }
            });
        }
        let taskRowCount = 1;

        function addTaskRow() {
            taskRowCount++;
            const container = $('#taskRowsContainer');

            const newRow = `
        <div class="task-row mb-3" data-row="${taskRowCount}">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label class="form-label font-weight-semibold">Task Name <span class="text-danger">*</span></label>
                        <input type="text" name="task_name[]" class="form-control"
                               placeholder="Enter task name" required>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="form-group mb-2">
                        <label class="form-label font-weight-semibold">Task Details <span class="text-danger">*</span></label>
                        <textarea name="task_details[]" class="form-control" rows="2"
                                  placeholder="Enter task details and requirements..." required></textarea>
                    </div>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <div class="form-group mb-2">
                        <button type="button" class="btn btn-danger btn-icon" onclick="removeTaskRow(this)">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;

            container.append(newRow);
            updateRemoveButtons();
        }

        function removeTaskRow(button) {
            $(button).closest('.task-row').remove();
            updateRemoveButtons();
        }

        function updateRemoveButtons() {
            const rows = $('.task-row');
            if (rows.length === 1) {
                rows.find('.btn-danger').prop('disabled', true);
            } else {
                rows.find('.btn-danger').prop('disabled', false);
            }
        }
    </script>
@endsection
