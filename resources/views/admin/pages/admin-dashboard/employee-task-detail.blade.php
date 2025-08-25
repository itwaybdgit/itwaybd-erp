@extends('admin.master')

@section('content')
<style>
    .card-body p {
        margin-bottom: 5px;
    }
</style>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>{{ $employee->name }} - Task Summary</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Project</th>
                            <th>Task</th>
                            <th>Status</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                        <tr>
                            <td>{{ $task['project'] ?? '-' }}</td>
                            <td>{{ $task['title'] }}</td>
                            <td>{{ $task['status'] }}</td>
                            <td>{{ $task['start_date_time'] }}</td>
                            <td>{{ $task['end_date_time'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        <h4>{{ $employee->name }} - Task Details</h4>

        <div class="row">
            @forelse($tasks as $task)
                <div class="col-lg-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            <strong>{{ $task['title'] }}</strong> 
                            <span class="badge bg-{{ $task['status'] == 'completed' ? 'success' : 'warning' }}">
                                {{ ucfirst($task['status']) }}
                            </span>
                        </div>
                        <div class="card-body">
                            <p>{{ $task['description'] }}</p>
                            <p><b>Project:</b> {{ $task['project'] }} | <b>Team:</b> {{ $task['team'] }}</p>
                            <p><b>Start:</b> {{ $task['start_date_time'] }} | <b>End:</b> {{ $task['end_date_time'] }}</p>
                            <p><b>Created By:</b> {{ $task['created_by'] }}</p>
                            <p><b>Progress:</b> {{ $task['progress'] }}%</p>
                            <p><b>Time Logged:</b> {{ $task['time_logged'] ? gmdate('H:i:s', $task['time_logged']) : '00:00:00' }} hrs</p>


                            {{-- Subtasks --}}
                            @if(count($task['subtasks']))
                                <h6>My Subtasks</h6>
                                <ul>
                                    @foreach($task['subtasks'] as $subtask)
                                        <li>
                                            {{ $subtask['title'] }} 
                                            ({{ ucfirst($subtask['status']) }}, {{ gmdate('H:i:s', $subtask['time_logged'] ?? 0) }} hrs)
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p>No tasks assigned to you.</p>
            @endforelse
            
        </div>

        
    </div>
@endsection
