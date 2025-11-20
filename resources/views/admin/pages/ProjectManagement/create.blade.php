@extends('admin.master')

<style>
    .module-card {
        border: none;
        margin-bottom: 30px;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border-radius: 8px;
        overflow: hidden;
    }

    .module-card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 20px 25px;
        color: white;
    }

    .module-left, .module-right {
        padding: 25px;
    }

    .module-right {
        background: #f8f9fc;
    }

    .submodule-item {
        padding: 18px;
        margin-bottom: 12px;
        border: 1px solid #e3e6f0;
        background: #fff;
        border-radius: 6px;
        transition: all 0.2s;
    }

    .submodule-item:hover {
        border-color: #667eea;
        box-shadow: 0 2px 6px rgba(102, 126, 234, 0.1);
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #5568d3 0%, #6a3f92 100%);
        transform: translateY(-1px);
    }

    .empty-submodules {
        text-align: center;
        padding: 50px 20px;
        color: #8492a6;
        background: linear-gradient(135deg, #f5f7fa 0%, #f8f9fc 100%);
        border-radius: 6px;
    }

    .empty-submodules i {
        font-size: 40px;
        margin-bottom: 15px;
        opacity: 0.5;
    }
</style>

@section('content')
    <section id="project-create-section">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-primary">Create New Project</h4>
                        <a href="{{ route('project.index') }}" class="btn btn-outline-secondary">
                            <i class="fa fa-arrow-left me-1"></i> Back
                        </a>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('project.store') }}" method="POST" id="projectForm">
                            @csrf

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Project Name <span class="text-danger">*</span></label>
                                <input type="text" name="project_name" id="project_name"
                                       class="form-control form-control-lg"
                                       placeholder="Enter your project name" required>
                            </div>

                            <div class="border-top pt-4 mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0 text-secondary">Project Modules</h5>
                                    <button type="button" class="btn btn-primary" onclick="addModule()">
                                        <i class="fa fa-plus me-2"></i>Add Module
                                    </button>
                                </div>
                            </div>

                            <div id="modules-container"></div>

                            <div class="mt-4 pt-4 border-top">
                                <button type="submit" class="btn btn-primary btn-lg px-4">
                                    <i class="fa fa-check me-2"></i>Create Project
                                </button>
                                <button type="reset" class="btn btn-outline-secondary btn-lg px-4" onclick="resetForm()">
                                    <i class="fa fa-redo me-2"></i>Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        let moduleCounter = 0;

        function addModule() {
            moduleCounter++;
            const moduleId = moduleCounter;

            const moduleHTML = `
            <div class="module-card p-1" id="module_${moduleId}">
                <div class="module-card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fa fa-cube me-2"></i>Module ${moduleId}
                        </h5>
                        <button type="button" class="btn btn-light btn-sm" onclick="removeModule(${moduleId})">
                            <i class="fa fa-trash me-1"></i>Remove
                        </button>
                    </div>
                </div>

                <div class="row g-0">
                    <div class="col-md-6 module-left">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Module Name <span class="text-danger">*</span></label>
                            <input type="text" name="modules[${moduleId}][name]"
                                   class="form-control"
                                   placeholder="e.g., User Management, Dashboard, Reports" required>
                        </div>

                        <div>
                            <label class="form-label fw-semibold">Module Description</label>
                            <textarea name="modules[${moduleId}][description]"
                                      class="form-control"
                                      rows="5"
                                      placeholder="Describe what this module does..."></textarea>
                        </div>
                    </div>

                    <div class="col-md-6 module-right">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <label class="form-label fw-semibold mb-0">Sub-modules</label>
                            <button type="button" class="btn btn-sm btn-primary" onclick="addSubModule(${moduleId})">
                                <i class="fa fa-plus me-1"></i>Add Sub-module
                            </button>
                        </div>

                        <div id="submodules-${moduleId}">
                            <div class="empty-submodules">
                                <i class="fa fa-layer-group"></i>
                                <p class="mb-0">No sub-modules yet</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

            document.getElementById('modules-container').insertAdjacentHTML('beforeend', moduleHTML);
        }

        function removeModule(moduleId) {
            if (confirm('Remove this module and all its sub-modules?')) {
                document.getElementById(`module_${moduleId}`).remove();
            }
        }

        function addSubModule(moduleId) {
            const submodulesContainer = document.getElementById(`submodules-${moduleId}`);

            const emptyMsg = submodulesContainer.querySelector('.empty-submodules');
            if (emptyMsg) emptyMsg.remove();

            const submoduleCount = submodulesContainer.querySelectorAll('.submodule-item').length + 1;
            const submoduleId = `submodule_${moduleId}_${submoduleCount}`;

            const submoduleHTML = `
            <div class="submodule-item" id="${submoduleId}">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge bg-primary">Sub-module ${submoduleCount}</span>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeSubModule('${submoduleId}', ${moduleId})">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div class="mb-2">
                    <input type="text" name="modules[${moduleId}][submodules][${submoduleCount}][name]"
                           class="form-control"
                           placeholder="Sub-module name" required>
                </div>
                <div>
                    <input type="text" name="modules[${moduleId}][submodules][${submoduleCount}][description]"
                           class="form-control"
                           placeholder="Description (optional)">
                </div>
            </div>
        `;

            submodulesContainer.insertAdjacentHTML('beforeend', submoduleHTML);
        }

        function removeSubModule(submoduleId, moduleId) {
            document.getElementById(submoduleId).remove();

            const submodulesContainer = document.getElementById(`submodules-${moduleId}`);
            if (submodulesContainer.querySelectorAll('.submodule-item').length === 0) {
                submodulesContainer.innerHTML = `
                <div class="empty-submodules">
                    <i class="fa fa-layer-group"></i>
                    <p class="mb-0">No sub-modules yet</p>
                </div>
            `;
            }
        }

        function resetForm() {
            if (confirm('Are you sure you want to reset the entire form?')) {
                document.getElementById('modules-container').innerHTML = '';
                moduleCounter = 0;
                document.getElementById('project_name').value = '';
            }
        }

        document.getElementById('projectForm').addEventListener('submit', function(e) {
            const modules = document.querySelectorAll('.module-card');
            if (modules.length === 0) {
                e.preventDefault();
                alert('Please add at least one module to the project.');
            }
        });
    </script>

@endsection
