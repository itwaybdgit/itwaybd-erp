@extends('admin.master')


@push('style')
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom CSS -->
<style>
    a{
        text-decoration: none;
    }
    /* Manual progress bar CSS */
    .progress-wrapper {
        width: 100%;
        background-color: #e0e0e0;
        border-radius: 5px;
        height: 10px;
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        background-color: #28a745; /* green color for completed */
        transition: width 0.5s ease;
    }

</style>
    
@endpush




@section('content')
<div class="container-fluid py-3">
    <h2 class="mb-4">Ongoing Projects</h2>

    <div class="row g-3">
        @forelse($projectsData as $project)
            <div class="col-lg-6 col-12">
                <div class="card shadow-sm rounded-3 border-0">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ $project['name'] }}</h5>
                            <div>
                                <span class="badge bg-primary">{{ $project['total_tasks'] }} Tasks</span>
                                <span class="badge bg-success">{{ $project['completed_tasks'] }} Completed</span>
                            </div>
                        </div>
                        @if($project['description'])
                            <small class="text-muted">{{ $project['description'] }}</small>
                        @endif
                    </div>

                    <div class="card-body">
                        <!-- Project Progress -->
                        <div class="progress-container mb-3">
                            <div class="mb-1">Project Progress: {{ $project['progress'] }}%</div>
                            <div style="background: #e0e0e0; border-radius:5px; height:10px;">
                                <div class="progress-bar" style="width: {{ $project['progress'] }}%"></div>
                            </div>
                        </div>

                        <!-- Tasks Accordion -->
                        <div class="accordion" id="taskAccordion{{ $project['id'] }}">
                            @foreach($project['tasks'] as $task)
                                <div class="accordion-item mb-2 border rounded">
                                    <h2 class="accordion-header" id="heading{{ $task['id'] }}">
                                        <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $task['id'] }}" aria-expanded="false" aria-controls="collapse{{ $task['id'] }}">
                                            <strong>{{ $task['title'] }}</strong>
                                            <span class="badge bg-secondary ms-2">{{ $task['subtasks']->count() }} Subtasks</span>
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $task['id'] }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $task['id'] }}" data-bs-parent="#taskAccordion{{ $project['id'] }}">
                                        <div class="accordion-body p-2">
                                            <!-- Task Progress -->
                                            <div class="progress-container mb-2">
                                                <div class="mb-1">Task Progress: {{ $task['progress'] }}%</div>
                                                <div style="background: #e0e0e0; border-radius:5px; height:6px;">
                                                    <div class="progress-bar" style="width: {{ $task['progress'] }}%;"></div>
                                                </div>
                                            </div>

                                            @if($task['subtasks']->isNotEmpty())
                                                <ul class="list-group list-group-flush">
                                                    @foreach($task['subtasks'] as $subtask)
                                                        <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                                            <div>
                                                                {{ $subtask['title'] }}
                                                                <br>
                                                                <small class="text-muted">
                                                                    👤 {{ $subtask['assigned_user']['name'] ?? 'Unassigned' }}
                                                                </small>
                                                            </div>
                                                            <span class="badge 
                                                                @if($subtask['status'] == 'Completed') bg-success 
                                                                @elseif($subtask['status'] == 'Pending') bg-warning 
                                                                @else bg-secondary 
                                                                @endif">
                                                                {{ $subtask['status'] ?? 'N/A' }}
                                                            </span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p class="text-muted mb-0">No subtasks available.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">No ongoing projects found.</div>
            </div>
        @endforelse
    </div>
</div>
@endsection

@section('scripts')
<!-- Bootstrap 5 JS (Popper included) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
