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
                                            <option value="Critical">Critical</option>
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
                                    <div class="col-md-6">
                                        <label for="assignUser" class="form-label">Assign User</label>
                                        <select class="form-select form-control" id="assignUser" name="user_id" required>
                                            <option value="" disabled selected>Select user</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Image Upload -->
                                <div class="mb-3">
                                    <label for="imageUpload" class="form-label">Upload Image</label>
                                    <input type="file" class="form-control" id="imageUpload" name="image"
                                        accept="image/*">
                                    <div class="file-preview-section mt-2" id="imagePreview"></div>
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Task Messages -->
                                <div class="messages-section">
                                    <h5>Task Messages</h5>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="messageInput"
                                            placeholder="Enter a message" />
                                        <button class="btn btn-outline-secondary" type="button"
                                            id="addMessageBtn">Add</button>
                                    </div>
                                    <div id="messagesList"></div>
                                    <!-- Hidden input to store messages as JSON -->
                                    <input type="hidden" id="hiddenMessages" value="" name="hiddenMessages">
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
        }
    </style>
@endsection

@section('scripts')
    <script>
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

        document.addEventListener('DOMContentLoaded', function() {
            const messagesList = document.getElementById('messagesList');
            const hiddenMessages = document.getElementById('hiddenMessages');
            const messageInput = document.getElementById('messageInput');
            const addMessageBtn = document.getElementById('addMessageBtn');

            let editingIndex = null;

            function addMessageToList(messageText, index) {
                const messageItem = document.createElement('div');
                messageItem.className = 'message-item d-flex justify-content-between align-items-center mb-1';

                const input = document.createElement('input');
                input.type = 'text';
                input.className = 'form-control me-2';
                input.value = messageText;
                input.readOnly = true;

                const buttonGroup = document.createElement('div');
                buttonGroup.className = 'd-flex';

                const editBtn = document.createElement('button');
                editBtn.className = 'btn btn-sm btn-warning me-2';
                editBtn.textContent = 'Edit';
                editBtn.addEventListener('click', function() {
                    messageInput.value = input.value;
                    editingIndex = index;
                });

                const deleteBtn = document.createElement('button');
                deleteBtn.className = 'btn btn-sm btn-danger';
                deleteBtn.textContent = 'Delete';
                deleteBtn.addEventListener('click', function() {
                    let messages = JSON.parse(hiddenMessages.value || '[]');
                    messages.splice(index, 1);
                    hiddenMessages.value = JSON.stringify(messages);
                    renderMessages();
                });


                buttonGroup.appendChild(deleteBtn);

                messageItem.appendChild(input);
                messageItem.appendChild(buttonGroup);
                messagesList.appendChild(messageItem);
            }

            function renderMessages() {
                messagesList.innerHTML = '';
                let messages = hiddenMessages.value ? JSON.parse(hiddenMessages.value) : [];
                messages.forEach((msg, idx) => addMessageToList(msg, idx));
            }

            // Load messages initially
            renderMessages();

            addMessageBtn.addEventListener('click', function() {
                const messageText = messageInput.value.trim();
                if (!messageText) return;

                let messages = hiddenMessages.value ? JSON.parse(hiddenMessages.value) : [];

                if (editingIndex !== null) {
                    messages[editingIndex] = messageText;
                    editingIndex = null;
                } else {
                    messages.push(messageText);
                }

                hiddenMessages.value = JSON.stringify(messages);
                renderMessages();
                messageInput.value = '';
            });
        });
        // Add button clicked
        addMessageBtn.addEventListener('click', function() {
            const messageText = messageInput.value.trim();
            if (!messageText) return;

            let messages = hiddenMessages.value ? JSON.parse(hiddenMessages.value) : [];

            if (editingIndex !== null) {
                messages[editingIndex] = messageText;
                editingIndex = null;
            } else {
                messages.push(messageText);
            }

            hiddenMessages.value = JSON.stringify(messages);
            renderMessages();
            messageInput.value = '';
        });



        document.getElementById('taskForm').addEventListener('submit', function(e) {

            const existingInputs = this.querySelectorAll('input[name^="messages["]');
            existingInputs.forEach(input => input.remove());

            const hiddenMessages = document.getElementById('hiddenMessages');
            if (hiddenMessages.value) {
                const messages = JSON.parse(hiddenMessages.value);
                messages.forEach((message, index) => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = `messages[${index}]`;
                    input.value = message;
                    this.appendChild(input);
                });
            }
        });
    </script>
@endsection
