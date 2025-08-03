@extends('admin.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-task me-2"></i>Task Management
                    </h1>
                    <a href="{{ route('task.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add New Task
                    </a>
                </div>

                <!-- Filter Section -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('task.index') }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="search">Search</label>
                                        <input type="text" class="form-control" name="search" id="search"
                                            value="{{ request('search') }}" placeholder="Search task...">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" name="status" id="status">
                                            <option value="">All Status</option>
                                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="in_progress"
                                                {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress
                                            </option>
                                            <option value="completed"
                                                {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled"
                                                {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="priority">Priority</label>
                                        <select class="form-control" name="priority" id="priority">
                                            <option value="">All Priority</option>
                                            <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low
                                            </option>
                                            <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>
                                                Medium</option>
                                            <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>
                                                High</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="project_id">Project</label>
                                        <select class="form-control" name="project_id" id="project_id">
                                            <option value="">All Projects</option>
                                            {{-- @foreach ($projects as $project)
                                                <option value="{{ $project->id }}"
                                                    {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                                    {{ $project->name }}
                                                </option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div class="d-flex">
                                            <button type="submit" class="btn btn-primary me-2">
                                                <i class="fas fa-filter"></i> Filter
                                            </button>
                                            <a href="{{ route('task.index') }}" class="btn btn-secondary">
                                                <i class="fas fa-times"></i> Clear
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- task Table -->
                <div class="card shadow">
                    {{-- <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Task List</h6>
                    </div> --}}
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table  table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>SL</th>
                                        <th>Title</th>
                                        <th>Project</th>
                                        <th>Assigned To</th>
                                        <th>Status</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                @if ($tasks->count() > 0)
                                    <tbody>
                                        @foreach ($tasks as $task)
                                            <tr>
                                                {{-- @dd($task) --}}
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <div class="fw-bold">{{ $task->title }}</div>
                                                    @if ($task->description)
                                                        <small
                                                            class="text-muted">{{ Str::limit($task->description, 20) }}</small>
                                                    @endif
                                                    {{-- <span class="badge bg-info">
                                                        {{ $task->priority ?? '' }}
                                                    </span> --}}
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $task->project->name ?? '' }}</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @foreach ($task->assignedUsers as $user)
                                                            <span class="badge bg-primary me-1">{{ $user->name }}</span>
                                                        @endforeach

                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="progress" style="height: 20px;">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                            style="width: {{ '' }}%;"
                                                            aria-valuenow="{{ '' }}" aria-valuemin="0"
                                                            aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                    <small class="text-muted">
                                                        {{ '' }}% Complete
                                                    </small>
                                                </td>

                                                <td>
                                                    {{ $task->start_date_time ? $task->start_date_time : 'N/A' }}
                                                </td>
                                                <td>
                                                    {{ $task->end_date_time ? $task->end_date_time : 'N/A' }}
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        {{-- <a href="{{ route('task.show', $task) }}"
                                                            class="btn btn-sm btn-outline-info" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a> --}}
                                                        <a href="{{ route('task.edit', $task->id) }}"
                                                            class="btn btn-sm btn-outline-primary" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('task.destroy', $task->id) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Are you sure you want to delete this task?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                title="Delete">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @else
                                    <div class="text-center py-4">
                                        <i class="fas fa-task fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No task found</h5>
                                        <p class="text-muted">Start by creating your first task!</p>
                                        <a href="{{ route('task.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Create Task
                                        </a>
                                    </div>
                                @endif


                            </table>
                        </div>

                        <!-- Pagination -->
                        {{-- <div class="d-flex justify-content-center">
                            {{ $task->appends(request()->query())->links() }}
                        </div> --}}


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .status-select {
            min-width: 120px;
        }

        .table td {
            vertical-align: middle;
        }

        .card {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
        }

        .btn-group .btn {
            margin-right: 2px;
        }

        .btn-group .btn:last-child {
            margin-right: 0;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }

        .badge {
            font-size: 0.75em;
        }

        .form-select-sm {
            font-size: 0.875rem;
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Status update functionality
            const statusSelects = document.querySelectorAll('.status-select');

            statusSelects.forEach(function(select) {
                select.addEventListener('change', function() {
                    const taskId = this.dataset.taskId;
                    const newStatus = this.value;
                    const currentStatus = this.dataset.currentStatus;

                    // Show loading state
                    this.disabled = true;

                    fetch(`/task/${taskId}/status`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                status: newStatus
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update the current status
                                this.dataset.currentStatus = newStatus;

                                // Show success message
                                showAlert('Status updated successfully!', 'success');

                                // Optionally reload the page after a delay
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            } else {
                                throw new Error(data.message || 'Failed to update status');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Revert the select to previous value
                            this.value = currentStatus;
                            showAlert('Failed to update status. Please try again.', 'error');
                        })
                        .finally(() => {
                            this.disabled = false;
                        });
                });
            });

            function showAlert(message, type) {
                const alertDiv = document.createElement('div');
                alertDiv.className =
                    `alert alert-${type === 'error' ? 'danger' : 'success'} alert-dismissible fade show`;
                alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

                const container = document.querySelector('.container-fluid');
                container.insertBefore(alertDiv, container.firstChild);

                // Auto dismiss after 3 seconds
                setTimeout(() => {
                    alertDiv.remove();
                }, 3000);
            }
        });
    </script>
@endsection
