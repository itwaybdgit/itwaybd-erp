@extends('admin.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card-body shadow d-flex justify-content-between align-items-center mb-2">
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-task me-2"></i>Create New Task
                    </h1>
                    <a href="{{ route('project.index') }}" class="btn btn-rounded btn-info">
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
                                        <input type="datetime-local" class="form-control" id="endDateTime"
                                            name="end_date_time" required />
                                        @error('end_date_time')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Status and Priority -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="taskStatus" class="form-label">Status</label>
                                        <select class="form-select form-control" id="taskStatus" name="status" required>
                                            <option value="" disabled selected>Select status</option>
                                            <option value="Pending">Pending</option>
                                            <option value="In Progress">In Progress</option>
                                            <option value="Completed">Completed</option>
                                        </select>
                                        @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="taskPriority" class="form-label">Priority</label>
                                        <select class="form-select form-control" id="taskPriority" name="priority" required>
                                            <option value="" disabled selected>Select priority</option>
                                            <option value="Low">Low</option>
                                            <option value="Medium">Medium</option>
                                            <option value="High">High</option>
                                        </select>
                                        @error('priority')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Project and Assignee -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="projectSelect" class="form-label">Project</label>
                                        <select class="form-select form-control" id="projectSelect" name="project_id"
                                            required>
                                            <option value="" disabled selected>Select project</option>
                                            @foreach ($projects as $project)
                                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('project_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                      <!-- Image Upload -->
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

                                <!-- Dynamic Subtasks Section -->
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <label class="form-label mb-0">
                                            <i class="fas fa-tasks me-2"></i>Subtasks
                                        </label>
                                        <button type="button" class="btn btn-outline-primary btn-sm" id="addSubtaskBtn" disabled>
                                            <i class="fas fa-plus me-1"></i>Add Subtask
                                        </button>
                                    </div>
                                    <div class="alert alert-info" id="projectWarning">
                                        <i class="fas fa-info-circle me-2"></i>Please select a project first to add subtasks.
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
    </div>
@endsection

@section('styles')
    <style>
        body {
            background-color: #f8f9fa;
            font-family: "Inter", sans-serif;
        }

        .task-form-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: 500;
            color: #333;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            padding: 0.75rem;
            font-size: 1rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .btn-primary {
            background-color: #0d6efd;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
        }

        .btn-outline-secondary {
            border-radius: 8px;
            padding: 0.5rem 1rem;
        }

        .messages-section {
            margin-top: 1.5rem;
            padding: 1rem;
            background-color: #f1f3f5;
            border-radius: 8px;
        }

        .message-item {
            background-color: #ffffff;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            border-radius: 6px;
            border: 1px solid #dee2e6;
        }

        .file-preview-section {
            margin-top: 1rem;
        }

        .file-preview {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
            border-radius: 4px;
            margin-right: 0.5rem;
        }

        /* Subtask Styles */
        .subtasks-container {
            border: 2px dashed #e9ecef;
            border-radius: 8px;
            padding: 1rem;
            min-height: 60px;
            background-color: #f8f9fa;
        }

        .subtask-item {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            position: relative;
            transition: all 0.3s ease;
        }

        .subtask-item:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .subtask-header {
            display: flex;
            justify-content-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .subtask-number {
            background-color: #0d6efd;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .remove-subtask-btn {
            background: none;
            border: none;
            color: #dc3545;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .remove-subtask-btn:hover {
            background-color: #f8d7da;
        }

        .empty-subtasks {
            text-align: center;
            color: #6c757d;
            font-style: italic;
            padding: 2rem;
        }

        .subtask-row {
            margin-bottom: 0.75rem;
        }

        .subtask-row:last-child {
            margin-bottom: 0;
        }

        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .subtask-item .row {
                margin: 0;
            }
            
            .subtask-item .col-md-8,
            .subtask-item .col-md-4 {
                padding: 0.25rem;
            }
        }

        @media (max-width: 576px) {
            .task-form-container {
                margin: 1rem;
                padding: 1.5rem;
            }

            .form-control,
            .form-select {
                font-size: 0.9rem;
            }

            .btn-primary,
            .btn-outline-secondary {
                width: 100%;
            }

            .subtask-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
        }
    </style>
@endsection

@section('scripts')
    <script>
        let subtaskCounter = 0;
        let projectUsers = []; // Store users for the selected project

        // Project selection handler
        document.getElementById('projectSelect').addEventListener('change', function() {
            const projectId = this.value;
            const addSubtaskBtn = document.getElementById('addSubtaskBtn');
            const projectWarning = document.getElementById('projectWarning');
            const subtasksContainer = document.getElementById('subtasksContainer');
            
            if (projectId) {
                // Show loading state
                addSubtaskBtn.innerHTML = '<span class="loading-spinner"></span> Loading...';
                addSubtaskBtn.disabled = true;
                
                // Fetch users for the selected project
                fetch(`/admin/task/get-project-users/${projectId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            projectUsers = data.users;
                            
                            // Enable subtask functionality
                            addSubtaskBtn.innerHTML = '<i class="fas fa-plus me-1"></i>Add Subtask';
                            addSubtaskBtn.disabled = false;
                            projectWarning.style.display = 'none';
                            subtasksContainer.style.display = 'block';
                            
                            // Initialize empty message if no subtasks exist
                            if (subtasksContainer.children.length === 0) {
                                subtasksContainer.innerHTML = '<div class="empty-subtasks">No subtasks added yet. Click "Add Subtask" to create one.</div>';
                            }
                            
                            // Update existing subtask user dropdowns
                            updateExistingSubtaskUsers();
                        } else {
                            throw new Error(data.message || 'Failed to fetch users');
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching project users:', error);
                        alert('Error loading project users. Please try again.');
                        
                        // Reset button state
                        addSubtaskBtn.innerHTML = '<i class="fas fa-plus me-1"></i>Add Subtask';
                        addSubtaskBtn.disabled = true;
                        projectWarning.style.display = 'block';
                        subtasksContainer.style.display = 'none';
                    });
            } else {
                // Reset state when no project selected
                addSubtaskBtn.innerHTML = '<i class="fas fa-plus me-1"></i>Add Subtask';
                addSubtaskBtn.disabled = true;
                projectWarning.style.display = 'block';
                subtasksContainer.style.display = 'none';
                projectUsers = [];
            }
        });

        // Update existing subtask user dropdowns when project changes
        function updateExistingSubtaskUsers() {
            const userSelects = document.querySelectorAll('select[name*="[user_id]"]');
            userSelects.forEach(select => {
                const currentValue = select.value;
                select.innerHTML = '<option value="" disabled selected>Select user</option>' + generateUserOptions();
                // Try to restore previous selection if user still exists in new project
                if (currentValue && projectUsers.some(user => user.id == currentValue)) {
                    select.value = currentValue;
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
            if (projectUsers.length === 0) {
                alert('No users found for the selected project.');
                return;
            }
            addSubtask();
        });

        function addSubtask() {
            subtaskCounter++;
            const subtasksContainer = document.getElementById('subtasksContainer');
            
            // Remove empty message if it exists
            const emptyMessage = subtasksContainer.querySelector('.empty-subtasks');
            if (emptyMessage) {
                emptyMessage.remove();
            }

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
                                   placeholder="Enter subtask title" required>
                        </div>
                        <div class="col-md-4">
                            <label for="subtask_user_${subtaskCounter}" class="form-label">Assign To</label>
                            <select class="form-select form-control" id="subtask_user_${subtaskCounter}" 
                                    name="subtasks[${subtaskCounter}][user_id]" required>
                                <option value="" disabled selected>Select user</option>
                                ${generateUserOptions()}
                            </select>
                        </div>
                    </div>
                    <div class="row subtask-row">
                        <div class="col-md-12">
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
            newSubtask.scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            // Focus on the title input
            const titleInput = newSubtask.querySelector(`#subtask_title_${subtaskCounter}`);
            setTimeout(() => titleInput.focus(), 100);
        }

        function generateUserOptions() {
            return projectUsers.map(user => 
                `<option value="${user.id}">${user.name}</option>`
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
                    
                    // Show empty message if no subtasks left
                    const subtasksContainer = document.getElementById('subtasksContainer');
                    if (subtasksContainer.children.length === 0) {
                        subtasksContainer.innerHTML = '<div class="empty-subtasks">No subtasks added yet. Click "Add Subtask" to create one.</div>';
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
            });
        }

        // Form validation for subtasks
        document.getElementById('taskForm').addEventListener('submit', function(e) {
            const subtaskTitles = document.querySelectorAll('input[name*="[title]"]');
            const subtaskUsers = document.querySelectorAll('select[name*="[user_id]"]');
            
            let hasError = false;
            
            subtaskTitles.forEach((titleInput, index) => {
                const userSelect = subtaskUsers[index];
                
                if (titleInput.value.trim() === '') {
                    titleInput.classList.add('is-invalid');
                    hasError = true;
                } else {
                    titleInput.classList.remove('is-invalid');
                }
                
                if (userSelect && userSelect.value === '') {
                    userSelect.classList.add('is-invalid');
                    hasError = true;
                } else if (userSelect) {
                    userSelect.classList.remove('is-invalid');
                }
            });
            
            if (hasError) {
                e.preventDefault();
                alert('Please fill in all required subtask fields (Title and Assign To).');
            }
        });
    </script>
@endsection