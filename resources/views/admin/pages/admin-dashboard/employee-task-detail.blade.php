@extends('admin.master')

@section('content')
<style>
    .card-body p{
        margin-bottom: 0.5rem;
    }
</style>
<div class="container-fluid">
    <h2 class="mb-4">Employee Task Details</h2>

    <div class="card mb-4">
        <div class="card-body">
            <h5>Employee Info</h5>
            <p><strong>Name:</strong> {{ optional($employee->user)->name ?? 'Unknown' }}</p>
            <p><strong>Role:</strong> {{ optional($employee->designations)->name ?? 'Employee' }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="taskTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Project</th>
                        <th>Task Title</th>
                        <th>Description</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Progress</th>
                        <th>Time Logged</th>
                        <th>Created By</th>
                        <th>Subtasks</th>
                        <th>Team Members</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                        <tr>
                            <td>{{ $task['project'] }}</td>
                            <td>{{ $task['title'] }}</td>
                            <td>{{ $task['description'] }}</td>
                            <td><span class="badge bg-{{ $task['priority'] == 'high' ? 'danger' : 'secondary' }}">
                                {{ ucfirst($task['priority']) }}</span></td>
                            <td><span class="badge bg-{{ $task['status'] == 'completed' ? 'success' : 'warning' }}">
                                {{ ucfirst($task['status']) }}</span></td>
                            <td>{{ $task['start_date_time'] }}</td>
                            <td>{{ $task['end_date_time'] }}</td>
                            <td>{{ $task['progress'] }}%</td>
                            <td>{{ $task['time_logged'] }} hrs</td>
                            <td>{{ $task['created_by'] }}</td>
                            <td>
                                @if(!empty($task['subtasks']))
                                    <ul class="list-unstyled">
                                        @foreach($task['subtasks'] as $subtask)
                                            <li>
                                                <strong>{{ $subtask['title'] }}</strong> 
                                                ({{ ucfirst($subtask['status']) }}, {{ ucfirst($subtask['priority']) }}) - 
                                                {{ $subtask['time_logged'] }} hrs 
                                                <span class="text-muted">[{{ $subtask['user_name'] }}]</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <em>No Subtasks</em>
                                @endif
                            </td>
                            <td>
                                @if(!empty($task['team_members']))
                                    <ul class="list-unstyled" style="column-count: 2;">
                                        @foreach($task['team_members'] as $member)
                                            <li>
                                                <span class="badge bg-info">{{ $member['name'] }}</span>
                                                <small>({{ $member['role'] }})</small>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <em>No Team Members</em>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center">No tasks found for this employee.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    <div class="row">
        @forelse($tasks as $task)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>{{ $task['title'] }}</h5>
                        <span class="badge bg-{{ $task['status'] == 'completed' ? 'success' : 'warning' }}">
                            {{ ucfirst($task['status']) }}
                        </span>
                    </div>
                    <div class="card-body">
                        <p><strong>Project:</strong> {{ $task['project'] }}</p>
                        <p><strong>Description:</strong> {{ $task['description'] }}</p>
                        <p><strong>Priority:</strong> {{ ucfirst($task['priority']) }}</p>
                        <p><strong>Team:</strong> {{ $task['team'] }}</p>
                        <p><strong>Start:</strong> {{ $task['start_date_time'] }}</p>
                        <p><strong>End:</strong> {{ $task['end_date_time'] }}</p>
                        <p><strong>Created By:</strong> {{ $task['created_by'] }}</p>

                        <div class="mb-2">
                            <strong>Progress:</strong> {{ $task['progress'] }}%
                            <div class="progress mt-1" style="height: 4px">
                                <div class="progress-bar bg-success"
                                     role="progressbar"
                                     style="width: {{ $task['progress'] }}%; height: 6px; font-size: 7px;"
                                     aria-valuenow="{{ $task['progress'] }}"
                                     aria-valuemin="0"
                                     aria-valuemax="100">
                                    {{ $task['progress'] }}%
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <p><strong>Total Time Logged:</strong> {{ $task['time_logged'] }} hrs</p>
                            @if($task['is_overdue'])
                                <span class="badge bg-danger">Overdue</span>
                            @endif
                        </div>
                    </div>

                    @if(!empty($task['subtasks']))
                        <div class="card-footer">
                            <h6>Subtasks</h6>
                            <ul class="list-group">
                                @foreach($task['subtasks'] as $subtask)
                                    <li class="list-group-item">
                                        {{-- Subtask Title (clickable) --}}
                                        <div class="d-flex justify-content-between align-items-center">
                                            <button class="btn btn-link p-0 text-start toggle-subtask" type="button">
                                                <strong>{{ $subtask['title'] }}</strong>
                                            </button>
                                            <span class="badge bg-primary">{{ $subtask['user_name'] }}</span>
                                        </div>

                                        {{-- Hidden Details --}}
                                        <div class="subtask-details mt-2" style="display:none;">
                                            <small>{{ $subtask['description'] }}</small><br>
                                            <span>Status: {{ ucfirst($subtask['status']) }}</span> | 
                                            <span>Priority: {{ ucfirst($subtask['priority']) }}</span> | 
                                            <span>Time: {{ $subtask['time_logged'] }} hrs</span>

                                            <div class="mt-2">
                                                <div class="progress" style="height: 4px">
                                                    <div class="progress-bar bg-info"
                                                        role="progressbar"
                                                        style="width: {{ $subtask['status'] == 'completed' ? 100 : 0 }}%; height: 4px;"
                                                        aria-valuenow="{{ $subtask['status'] == 'completed' ? 100 : 0 }}"
                                                        aria-valuemin="0"
                                                        aria-valuemax="100">
                                                        {{ $subtask['status'] == 'completed' ? '100%' : '0%' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <div class="card-footer">
                        <button class="btn btn-sm btn-outline-primary toggle-team" type="button">
                            Show Team Members
                        </button>
                        <div class="team-members mt-3" style="display:none;">
                            <h6>Team Members</h6>
                            <ul class="list-inline">
                                @foreach($task['team_members'] as $member)
                                    <li class="list-inline-item">
                                        <span class="badge bg-info">{{ $member['name'] }} ({{ $member['role'] }})</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    No tasks found for this employee.
                </div>
            </div>
        @endforelse
    </div>


</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#taskTable').DataTable({
            pageLength: 10,
            ordering: true,
            responsive: true
        });
    });
</script>
<script>
    document.addEventListener("click", function(e) {
        if (e.target.classList.contains("toggle-team")) {
            e.target.nextElementSibling.classList.toggle("d-none");
        }
        if (e.target.closest(".toggle-subtask")) {
            const details = e.target.closest("li").querySelector(".subtask-details");
            details.style.display = details.style.display === "none" ? "block" : "none";
        }
    });

</script>
@endpush
