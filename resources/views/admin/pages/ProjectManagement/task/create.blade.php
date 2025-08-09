@extends('admin.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-body shadow d-flex justify-content-between align-items-center mb-2">
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-task me-2"></i>Create New Task
                </h1>
                <a href="{{ route('task.index') }}" class="btn btn-rounded btn-info">
                    <span class="btn-icon-start text-white">
                        <i class="fa fa-arrow-left"></i>
                    </span>
                    Back to List
                </a>
            </div>

            <!-- Task Form -->
            <div class="card shadow">
                <div class="card-body">
                    <div class="container task-form-container">
                        <x-alert type="info" message="Please fill out the form below to create a new task." />
                        <form action="{{ route('task.store') }}" method="POST" id="taskForm"
                            enctype="multipart/form-data">
                            @csrf
                            <!-- Task Title -->
                            <div class="mb-3">
                                <label for="taskTitle" class="form-label">Task Title</label>
                                <input type="text" class="form-control" id="taskTitle" name="title"
                                    placeholder="Enter task title" required />
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Task Description -->
                            <div class="mb-3">
                                <label for="taskDescription" class="form-label">Task Description</label>
                                <textarea class="form-control" id="taskDescription" name="description" rows="4"
                                    placeholder="Enter task description" required></textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Start Date and Time -->
                            <div class="row mb-3">
                                @php
                                    $now = now()->format('Y-m-d\TH:i');
                                @endphp
                                <div class="col-md-6">
                                    <label for="startDateTime" class="form-label">Start Date & Time</label>
                                    <input type="datetime-local" class="form-control" id="startDateTime"
                                        name="start_date_time" value="{{ $now }}" required />
                                    @error('start_date_time')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- End Date and Time -->
                                <div class="col-md-6">
                                    <label for="endDateTime" class="form-label">End Date & Time</label>
                                    <input type="datetime-local" class="form-control" id="endDateTime" name="end_date_time"
                                        required />
                                    @error('end_date_time')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Status and Priority -->
                            <div class="row mb-3 d-none">
                                <div class="col-md-6">
                                    <label for="taskStatus" class="form-label">Status</label>
                                    <select class="form-select form-control" id="taskStatus" name="status" required>
                                        <option value="" disabled selected>Select status</option>
                                        <option selected value="Pending">Pending</option>
                                        <option value="In Progress">In Progress</option>
                                        <option value="Completed">Completed</option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 d-none">
                                    <label for="taskPriority" class="form-label d-none">Priority</label>
                                    <select class="form-select form-control" id="taskPriority" name="priority" required>
                                        <option value="" disabled selected>Select priority</option>
                                        <option value="Low">Low</option>
                                        <option value="Medium">Medium</option>
                                        <option selected value="High">High</option>
                                    </select>
                                    @error('priority')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Team and Project Selection -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="teamSelect" class="form-label">Team</label>
                                    <select class="form-select form-control" id="teamSelect" name="team_id" required>
                                        <option value="" disabled selected>Select team</option>
                                        @foreach ($teams as $team)
                                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('team_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="imageUpload" class="form-label">Upload Image</label>
                                    <input type="file" class="form-control" id="imageUpload" name="image"
                                        accept="image/*">
                                    <div class="file-preview-section mt-2" id="imagePreview"></div>
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Hidden Project Field (Always 0) -->
                            {{-- <input type="hidden" name="project_id" value="0"> --}}

                            <!-- Dynamic Subtasks Section -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-label mb-0">
                                        <i class="fas fa-tasks me-2"></i>Subtasks
                                    </label>
                                    <button type="button" class="btn btn-outline-primary btn-sm" id="addSubtaskBtn"
                                        disabled>
                                        <i class="fas fa-plus me-1"></i>Add Subtask
                                    </button>
                                </div>
                                <div class="alert alert-info" id="teamWarning">
                                    <i class="fas fa-info-circle me-2"></i>Please select a team first to add subtasks.
                                </div>
                                <div id="subtasksContainer" class="subtasks-container" style="display: none;">
                                    <!-- Subtasks will be added dynamically here -->
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary">Create Task</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let subtaskCounter = 0;
        let teamEmployees = []; // Store employees for the selected team
        let selectedTeam = null;
        let mainTaskTitle = '';
        let teamProjects = [];

        // Task title change handler
        document.getElementById('taskTitle').addEventListener('input', function() {
            mainTaskTitle = this.value.trim();
            updateSubtaskTitles();
        });

        function isTechTeam(team) {
            if (!team || !team.name) return false;
            const teamName = team.name.toLowerCase().trim();
            return teamName === 'tech' || teamName === 'tech team' || teamName.includes('tech');
        }


        // Modified team selection handler
        document.getElementById('teamSelect').addEventListener('change', function() {
            const teamId = this.value;
            const addSubtaskBtn = document.getElementById('addSubtaskBtn');
            const teamWarning = document.getElementById('teamWarning');
            const subtasksContainer = document.getElementById('subtasksContainer');

            if (teamId) {
                // Show loading state
                addSubtaskBtn.innerHTML = '<span class="loading-spinner"></span> Loading...';
                addSubtaskBtn.disabled = true;

                // Find selected team
                selectedTeam = @json($teams).find(team => team.id == teamId);

                // Fetch employees for the selected team
                fetch(`/admin/task/get-team-users/${teamId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            teamEmployees = data.employees;

                            // If it's tech team, also fetch projects
                            if (isTechTeam(selectedTeam)) {
                                return fetch(`/admin/task/get-team-projects/${teamId}`);
                            } else {
                                teamProjects = []; // Reset projects for non-tech teams
                                return Promise.resolve({
                                    json: () => ({
                                        success: true,
                                        projects: []
                                    })
                                });
                            }
                        } else {
                            throw new Error(data.message || 'Failed to fetch employees');
                        }
                    })
                    .then(response => {
                        if (isTechTeam(selectedTeam)) {
                            if (!response.ok) {
                                throw new Error('Failed to fetch projects');
                            }
                            return response.json();
                        } else {
                            return {
                                success: true,
                                projects: []
                            };
                        }
                    })
                    .then(projectData => {
                        if (isTechTeam(selectedTeam)) {
                            if (projectData.success) {
                                teamProjects = projectData.projects;
                            } else {
                                console.warn('Failed to fetch projects:', projectData.message);
                                teamProjects = [];
                            }
                        }

                        // Enable subtask functionality
                        addSubtaskBtn.innerHTML = '<i class="fas fa-plus me-1"></i>Add Subtask';
                        addSubtaskBtn.disabled = false;
                        teamWarning.style.display = 'none';
                        subtasksContainer.style.display = 'block';

                        // Initialize empty message if no subtasks exist
                        if (subtasksContainer.children.length === 0) {
                            subtasksContainer.innerHTML =
                                '<div class="empty-subtasks">No subtasks added yet. Click "Add Subtask" to create one.</div>';
                        }

                        // Update existing subtask dropdowns
                        updateExistingSubtaskEmployees();
                        updateExistingSubtaskProjects();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error loading team data. Please try again.');

                        // Reset button state
                        addSubtaskBtn.innerHTML = '<i class="fas fa-plus me-1"></i>Add Subtask';
                        addSubtaskBtn.disabled = true;
                        teamWarning.style.display = 'block';
                        subtasksContainer.style.display = 'none';
                    });
            } else {
                // Reset state when no team selected
                addSubtaskBtn.innerHTML = '<i class="fas fa-plus me-1"></i>Add Subtask';
                addSubtaskBtn.disabled = true;
                teamWarning.style.display = 'block';
                subtasksContainer.style.display = 'none';
                teamEmployees = [];
                teamProjects = [];
                selectedTeam = null;
            }
        });


        // Update existing subtask project dropdowns when team changes
        function updateExistingSubtaskProjects() {
            const projectRows = document.querySelectorAll('.subtask-project-row');
            const projectSelects = document.querySelectorAll('select[name*="[project_id]"]:not([type="hidden"])');
            const hiddenProjectInputs = document.querySelectorAll('input[name*="[project_id]"][type="hidden"]');

            if (isTechTeam(selectedTeam)) {
                // Show project dropdowns for tech team
                projectRows.forEach(row => {
                    row.style.display = 'block';
                });

                projectSelects.forEach(select => {
                    const currentValue = select.value;
                    select.innerHTML = '<option value="" disabled selected>Select project</option>' +
                        generateProjectOptions();
                    // Try to restore previous selection if project still exists
                    if (currentValue && teamProjects.some(project => project.id == currentValue)) {
                        select.value = currentValue;
                    }
                });

                // Remove hidden inputs for tech team
                hiddenProjectInputs.forEach(input => {
                    input.remove();
                });
            } else {
                // Hide project dropdowns for non-tech teams
                projectRows.forEach(row => {
                    row.style.display = 'none';
                });

                // Set all project values to 0 for non-tech teams
                projectSelects.forEach(select => {
                    select.value = '';
                });
            }
        }
        // Update project field visibility based on team selection
        function updateProjectVisibility() {
            const projectSelects = document.querySelectorAll('select[name*="[project_id]"]');

            projectSelects.forEach(select => {
                const projectRow = select.closest('.col-md-6');
                if (selectedTeam && selectedTeam.name.toLowerCase() === 'tech') {
                    // Show project selection for Tech team
                    projectRow.style.display = 'block';
                    select.innerHTML = '<option value="" disabled selected>Select project</option>' +
                        generateProjectOptions();
                } else {
                    // Hide project selection for non-Tech teams
                    projectRow.style.display = 'none';
                    select.value = '0'; // Set hidden value to 0
                }
            });
        }


        // Generate project options
        function generateProjectOptions() {
            if (!teamProjects || teamProjects.length === 0) {
                return '<option value="" disabled>No projects available</option>';
            }

            return teamProjects.map(project =>
                `<option value="${project.id}">${project.name}</option>`
            ).join('');
        }
        // Update existing subtask employee dropdowns when team changes
        function updateExistingSubtaskEmployees() {
            const employeeSelects = document.querySelectorAll('select[name*="[user_id]"]');
            employeeSelects.forEach(select => {
                const currentValue = select.value;
                select.innerHTML = '<option value="" disabled selected>Select employee</option>' +
                    generateEmployeeOptions();
                // Try to restore previous selection if employee still exists in new team
                if (currentValue && teamEmployees.some(employee => employee.id == currentValue)) {
                    select.value = currentValue;
                }
            });
        }

        // Update all subtask titles based on main task title
        function updateSubtaskTitles() {
            const subtaskTitleInputs = document.querySelectorAll('input[name*="[title]"]');
            subtaskTitleInputs.forEach((input, index) => {
                if (mainTaskTitle) {
                    input.value = `${mainTaskTitle} - ${index + 1}`;
                } else {
                    input.value = '';
                }
            });
        }

        // Handle image upload preview
        document.getElementById('imageUpload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imagePreview = document.getElementById('imagePreview');
                    const fileItem = document.createElement('div');
                    fileItem.className = 'file-item';
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'file-preview';
                    img.alt = 'Uploaded image';
                    fileItem.appendChild(img);
                    fileItem.appendChild(document.createTextNode(file.name));
                    imagePreview.innerHTML = ''; // Clear previous preview
                    imagePreview.appendChild(fileItem);
                };
                reader.readAsDataURL(file);
            }
        });

        // Add Subtask functionality
        document.getElementById('addSubtaskBtn').addEventListener('click', function() {
            if (teamEmployees.length === 0) {
                alert('No employees found for the selected team.');
                return;
            }
            addSubtask();
        });

        // Updated addSubtask function with proper project field handling
        function addSubtask() {
            subtaskCounter++;
            const subtasksContainer = document.getElementById('subtasksContainer');

            // Remove empty message if it exists
            const emptyMessage = subtasksContainer.querySelector('.empty-subtasks');
            if (emptyMessage) {
                emptyMessage.remove();
            }

            // Generate subtask title
            const subtaskTitle = mainTaskTitle ? `${mainTaskTitle} - ${subtaskCounter}` : '';

            // Check if selected team is tech team
            const isTeamTech = isTechTeam(selectedTeam);

            const subtaskHtml = `
        <div class="subtask-item" data-subtask-id="${subtaskCounter}">
            <div class="subtask-header" style="display: flex; gap: 10px;">
                <div class="subtask-number">${subtaskCounter}</div>
                <button type="button" class="btn btn-danger remove-subtask-btn" onclick="removeSubtask(${subtaskCounter})">
                 <i class="fas fa-trash-alt"></i>
                </button>
            </div>
            <div class="row subtask-row">
                <div class="col-md-8">
                    <label for="subtask_title_${subtaskCounter}" class="form-label">Subtask Title</label>
                    <input type="text" class="form-control" id="subtask_title_${subtaskCounter}"
                           name="subtasks[${subtaskCounter}][title]"
                           value="${subtaskTitle}" readonly>
                </div>
                <div class="col-md-4">
                    <label for="subtask_user_${subtaskCounter}" class="form-label">Assign To</label>
                    <select class="form-select form-control" id="subtask_user_${subtaskCounter}"
                            name="subtasks[${subtaskCounter}][user_id]" required>
                        <option value="" disabled selected>Select employee</option>
                        ${generateEmployeeOptions()}
                    </select>
                </div>
            </div>
            <div class="row subtask-row">
                ${isTeamTech ? `
                            <div class="col-md-6 subtask-project-row">
                                <label for="subtask_project_${subtaskCounter}" class="form-label">Project <span class="text-danger">*</span></label>
                                <select class="form-select form-control select2" id="subtask_project_${subtaskCounter}"
                                        name="subtasks[${subtaskCounter}][project_id]" required>
                                    <option value="" disabled selected>Select project</option>
                                    ${generateProjectOptions()}
                                </select>
                            </div>
                            <div class="col-md-6">
                        ` : `
                            <input type="hidden" name="subtasks[${subtaskCounter}][project_id]" value="0">
                            <div class="col-md-12">
                        `}
                    <label for="subtask_description_${subtaskCounter}" class="form-label">Description</label>
                    <textarea class="form-control" id="subtask_description_${subtaskCounter}"
                              name="subtasks[${subtaskCounter}][description]" rows="2"
                              placeholder="Enter subtask description"></textarea>
                </div>
            </div>

            <div class="row subtask-row">
                <div class="col-md-6">
                    <label for="subtask_priority_${subtaskCounter}" class="form-label">Priority</label>
                    <select class="form-select form-control" id="subtask_priority_${subtaskCounter}"
                            name="subtasks[${subtaskCounter}][priority]">
                        <option value="" disabled selected>Select priority</option>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                        <option value="Critical">Critical</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="subtask_status_${subtaskCounter}" class="form-label">Status</label>
                    <select class="form-select form-control" id="subtask_status_${subtaskCounter}"
                            name="subtasks[${subtaskCounter}][status]">
                        <option value="Pending" selected>Pending</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>
            </div>
        </div>
    `;

            subtasksContainer.insertAdjacentHTML('beforeend', subtaskHtml);

            // Scroll to the newly added subtask
            const newSubtask = subtasksContainer.lastElementChild;
            newSubtask.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });

            // Focus on the user selection
            const userSelect = newSubtask.querySelector(`#subtask_user_${subtaskCounter}`);
            setTimeout(() => userSelect.focus(), 100);
        }

        function generateEmployeeOptions() {
            return teamEmployees.map(employee =>
                `<option value="${employee.id}">${employee.name}</option>`
            ).join('');
        }

        function removeSubtask(subtaskId) {
            const subtaskItem = document.querySelector(`[data-subtask-id="${subtaskId}"]`);
            if (subtaskItem) {
                // Add fade out animation
                subtaskItem.style.opacity = '0';
                subtaskItem.style.transform = 'translateX(-20px)';

                setTimeout(() => {
                    subtaskItem.remove();
                    renumberSubtasks();
                    updateSubtaskTitles();

                    // Show empty message if no subtasks left
                    const subtasksContainer = document.getElementById('subtasksContainer');
                    if (subtasksContainer.children.length === 0) {
                        subtasksContainer.innerHTML =
                            '<div class="empty-subtasks">No subtasks added yet. Click "Add Subtask" to create one.</div>';
                    }
                }, 300);
            }
        }

        function renumberSubtasks() {
            const subtaskItems = document.querySelectorAll('.subtask-item');
            subtaskItems.forEach((item, index) => {
                const number = index + 1;
                const numberElement = item.querySelector('.subtask-number');
                if (numberElement) {
                    numberElement.textContent = number;
                }

                // Update subtask counter for proper numbering
                subtaskCounter = subtaskItems.length;
            });
        }

        // Form validation for subtasks

        // Updated form validation to include project validation for tech team only
        document.getElementById('taskForm').addEventListener('submit', function(e) {
            const subtaskUsers = document.querySelectorAll('select[name*="[user_id]"]');
            const subtaskProjects = document.querySelectorAll('select[name*="[project_id]"]:not([type="hidden"])');

            let hasError = false;

            // Validate user assignments
            subtaskUsers.forEach((userSelect, index) => {
                if (userSelect.value === '') {
                    userSelect.classList.add('is-invalid');
                    hasError = true;
                } else {
                    userSelect.classList.remove('is-invalid');
                }
            });

            // Validate project assignments ONLY for tech team
            if (isTechTeam(selectedTeam)) {
                subtaskProjects.forEach((projectSelect, index) => {
                    if (projectSelect.value === '') {
                        projectSelect.classList.add('is-invalid');
                        hasError = true;
                    } else {
                        projectSelect.classList.remove('is-invalid');
                    }
                });
            }

            if (hasError) {
                e.preventDefault();

                let message = 'Please fix the following errors:\n';
                if (document.querySelectorAll('select[name*="[user_id]"].is-invalid').length > 0) {
                    message += '- Assign all subtasks to employees\n';
                }
                if (isTechTeam(selectedTeam) &&
                    document.querySelectorAll('select[name*="[project_id]"].is-invalid').length > 0) {
                    message += '- Select projects for all subtasks (required for Tech team)\n';
                }

                alert(message);

                // Scroll to first error
                const firstError = document.querySelector('.is-invalid');
                if (firstError) {
                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    firstError.focus();
                }
            }
        });
    </script>
@endsection
