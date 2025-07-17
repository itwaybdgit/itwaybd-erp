@extends('admin.master')

@section('content')
    <div class="container-fluid">
        <div class="card-body shadow d-flex justify-content-between align-items-center mb-2">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-task me-2"></i>Edit
            </h1>
            <a href="{{ route('project.index') }}" class="btn btn-rounded btn-info">
                <span class="btn-icon-start text-white">
                    <i class="fa fa-arrow-left"></i>
                </span>
                Back to List
            </a>
        </div>
        <div class="card shadow mt-4">
            <div class="card-body">
                <form action="{{ route('task.update', $task->id) }}" method="POST" enctype="multipart/form-data"
                    id="taskForm">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div class="mb-3">
                        <label class="form-label">Task Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $task->title) }}"
                            required>
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="4" required>{{ old('description', $task->description) }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Start and End Date -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Start Date & Time</label>
                            <input type="datetime-local" name="start_date_time" class="form-control"
                                value="{{ old('start_date_time', \Carbon\Carbon::parse($task->start_date_time)->format('Y-m-d\TH:i')) }}"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">End Date & Time</label>
                            <input type="datetime-local" name="end_date_time" class="form-control"
                                value="{{ old('end_date_time', \Carbon\Carbon::parse($task->end_date_time)->format('Y-m-d\TH:i')) }}"
                                required>
                        </div>
                    </div>

                    <!-- Status & Priority -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select form-control" required>
                                @foreach (['Pending', 'In Progress', 'Completed'] as $status)
                                    <option value="{{ $status }}" {{ $task->status == $status ? 'selected' : '' }}>
                                        {{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Priority</label>
                            <select name="priority" class="form-select form-control" required>
                                @foreach (['Low', 'Medium', 'High', 'Critical'] as $priority)
                                    <option value="{{ $priority }}"
                                        {{ $task->priority == $priority ? 'selected' : '' }}>{{ $priority }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Project & User -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Project</label>
                            <select name="project_id" class="form-select form-control" required>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}"
                                        {{ $task->project_id == $project->id ? 'selected' : '' }}>{{ $project->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Assign User</label>
                            <select name="user_id" class="form-select form-control" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $task->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Image -->
                    <div class="mb-3">
                        <label class="form-label">Current Image</label><br>
                        @if ($task->image)
                            <img src="{{ asset('uploads/tasks/' . $task->image) }}" width="100" class="mb-2"
                                alt="Task Image">
                        @endif
                        <input type="file" name="image" class="form-control">
                    </div>

                    <!-- Task Messages -->
                    <div class="messages-section">
                        <h5>Task Messages</h5>

                        {{-- Existing messages (from database) --}}
                        @foreach ($taskMessages as $msg)
                            <div class="message-item d-flex justify-content-between align-items-center mb-2"
                                data-id="{{ $msg->id }}">
                                <input type="text" class="form-control me-2" value="{{ $msg->message }}" readonly>
                                <button type="button" class="btn btn-danger btn-sm delete-existing-message"
                                    data-id="{{ $msg->id }}"
                                    data-url="{{ route('task.task-message.destroy', $msg->id) }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        @endforeach

                        {{-- New messages will be appended here --}}
                        <div id="messagesList"></div>

                        {{-- Hidden JSON field for new messages --}}
                        <input type="hidden" name="messages" id="hiddenMessages">

                        {{-- Input field for new message --}}
                        <div class="input-group mt-3 mb-2">
                            <input type="text" class="form-control" id="messageInput" placeholder="Enter a new message">
                            <button class="btn btn-outline-secondary" type="button" id="addMessageBtn">Add</button>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-success">Update Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const messageInput = document.getElementById('messageInput');
            const addMessageBtn = document.getElementById('addMessageBtn');
            const messagesList = document.getElementById('messagesList');
            const hiddenMessages = document.getElementById('hiddenMessages');

            let tempMessages = [];

            function updateHiddenField() {
                hiddenMessages.value = JSON.stringify(tempMessages);
            }

            function addNewMessage(messageText) {
                const wrapper = document.createElement('div');
                wrapper.className = 'message-item d-flex justify-content-between align-items-center mb-2';

                const input = document.createElement('input');
                input.type = 'text';
                input.className = 'form-control me-2';
                input.value = messageText;
                input.readOnly = true;

                const deleteBtn = document.createElement('button');
                deleteBtn.className = 'btn btn-sm btn-danger';
                deleteBtn.textContent = 'Delete';
                deleteBtn.addEventListener('click', function() {
                    messagesList.removeChild(wrapper);
                    tempMessages = tempMessages.filter(msg => msg !== messageText);
                    updateHiddenField();
                });

                wrapper.appendChild(input);
                wrapper.appendChild(deleteBtn);
                messagesList.appendChild(wrapper);
            }

            addMessageBtn.addEventListener('click', function() {
                const messageText = messageInput.value.trim();
                if (!messageText) return;

                tempMessages.push(messageText);
                updateHiddenField();
                addNewMessage(messageText);
                messageInput.value = '';
            });

            // Remove existing DB messages with AJAX
            document.querySelectorAll('.delete-existing-message').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (!confirm('Are you sure to delete this message?')) return;

                    const url = btn.dataset.url;
                    const wrapper = btn.closest('.message-item');

                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    }).then(res => {
                        if (res.ok) {
                            wrapper.remove();
                        } else {
                            alert('Failed to delete message.');
                        }
                    }).catch(() => {
                        alert('Error while deleting message.');
                    });
                });
            });

            // Submit: create hidden inputs for messages[]
            document.getElementById('taskForm').addEventListener('submit', function(e) {
                // Clean existing generated inputs
                this.querySelectorAll('input[name^="messages["]').forEach(el => el.remove());

                tempMessages.forEach((msg, index) => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = `messages[${index}]`;
                    input.value = msg;
                    this.appendChild(input);
                });
            });
        });
    </script>
@endsection
