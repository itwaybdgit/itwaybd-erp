@extends('admin.master')

@section('content')
    <div class="container-fluid py-2">
        <!-- Overview Cards -->
        <div class="row g-4 mb-2">
            <div class="col-md-6 col-lg-3">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="card-subtitle mb-2 text-muted">Total Tasks</h6>
                                <h2 class="card-title mb-0">{{ count($tasks) }}</h2>
                                <small class="text-muted">All tasks in system</small>
                            </div>
                            <div class="stat-icon bg-light">
                                <i class="fas fa-tasks text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="card-subtitle mb-2 text-muted">Pending Tasks</h6>
                                <h2 class="card-title mb-0">{{ $tasks->where('status', 'Panding')->count() }}</h2>
                                <small class="text-muted">Tasks waiting to start</small>
                            </div>
                            <div class="stat-icon bg-light">
                                <i class="far fa-circle text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="card-subtitle mb-2 text-muted">Working Tasks</h6>
                                <h2 class="card-title mb-0">{{ $tasks->where('status', 'in_progress')->count() }}
                                </h2>
                                <small class="text-muted">Tasks in progress</small>
                            </div>
                            <div class="stat-icon bg-primary bg-opacity-10">
                                <i class="fas fa-clock text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="card-subtitle mb-2 text-muted">Solved Tasks</h6>
                                <h2 class="card-title mb-0">{{ $tasks->where('status', 'Completed')->count() }}</h2>
                                <small class="text-muted">Completed tasks</small>
                            </div>
                            <div class="stat-icon bg-success bg-opacity-10">
                                <i class="fas fa-check-circle text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Task List -->
        <div class="card shadow">

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>SL</th>
                                <th>Title</th>
                                <th>Project</th>
                                <th>Assigned To</th>
                                <th>Status</th>
                                <th>StartTime</th>
                                <th>EndTime</th>
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
                                                <small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
                                            @endif
                                            {{-- <span class="badge bg-info">
                                                {{ $task->priority ?? '' }}
                                            </span> --}}
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $task->getProject->name ?? '' }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                {{-- <img src="https://ui-avatars.com/api/?name={{ urlencode($task->getUser->name) }}&background=007bff&color=fff&size=32"
                                                        class="rounded-circle me-2" width="32" height="32"> --}}
                                                <div>
                                                    <div class="fw-bold">{{ $task->getUser->name }}</div>
                                                    <small class="text-muted">{{ $task->getUser->email }}</small>
                                                </div>
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
                                                <a href="{{ route('task.show', $task) }}"
                                                    class="btn btn-sm btn-outline-info" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('task.edit', $task) }}"
                                                    class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                {{-- <form action="{{ route('task.destroy', $task) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this task?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form> --}}
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
    @endsection

    @section('styles')
        <style>
            body {
                background-color: #f8f9fa;
            }

            .dashboard-header {
                background: white;
                border-bottom: 1px solid #dee2e6;
                padding: 1rem 0;
            }

            .stat-card {
                transition: transform 0.2s;
            }

            .stat-card:hover {
                transform: translateY(-2px);
            }

            .stat-icon {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .badge-priority-high {
                background-color: #fee2e2;
                color: #dc2626;
            }

            .badge-priority-medium {
                background-color: #fef3c7;
                color: #d97706;
            }

            .badge-priority-low {
                background-color: #dcfce7;
                color: #16a34a;
            }

            .badge-status-pending {
                background-color: #f3f4f6;
                color: #6b7280;
            }

            .badge-status-working {
                background-color: #dbeafe;
                color: #2563eb;
            }

            .badge-status-solved {
                background-color: #dcfce7;
                color: #16a34a;
            }

            .task-row {
                cursor: pointer;
                transition: background-color 0.2s;
            }

            .task-row:hover {
                background-color: #f8f9fa;
            }

            .search-box {
                position: relative;
            }

            .search-icon {
                position: absolute;
                left: 10px;
                top: 50%;
                transform: translateY(-50%);
                color: #6b7280;
            }

            .search-input {
                padding-left: 35px;
            }

            .task-description {
                font-size: 0.875rem;
                color: #6b7280;
                margin-top: 0.25rem;
            }

            .assignee-info {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                font-size: 0.875rem;
            }

            .due-date-info {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                font-size: 0.875rem;
            }
        </style>
    @endsection

    @section('scripts')
    @endsection
