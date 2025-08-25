@extends('admin.master')


@section('title', 'Admin Dashboard')


@section('style')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<style>
    .custom-btn {
        display: inline-block;
        font-weight: 400;
        text-align: center;
        vertical-align: middle;
        user-select: none;
        border: 1px solid transparent;
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem; 
        line-height: 1.5;
        border-radius: 0.25rem;
        transition: all 0.15s ease-in-out;
        color: #fff;
        background-color: #0dcaf0;
        border-color: #0dcaf0;
    }

    .custom-btn:hover {
        background-color: #31d2f2;
        border-color: #31d2f2;
    }

    .filter-btn.active {
        background-color: #7367f0 !important;
        color: #fff !important;
    }

</style>
@endsection



@section('content')
<div class="container-fluid py-3">
    <h2 class="mb-4">Project Overview</h2>

    <!-- Project Overview -->
    <div class="row mb-4">
        @foreach($projects as $key => $value)
            @php
                $icons = ['totalProjects'=>'fa-folder','ongoingProjects'=>'fa-spinner','completedProjects'=>'fa-check-circle','pendingProjects'=>'fa-hourglass-half'];
                $colors = ['totalProjects'=>'text-primary','ongoingProjects'=>'text-warning','completedProjects'=>'text-success','pendingProjects'=>'text-danger'];
                $labels = ['totalProjects'=>'Total Projects','ongoingProjects'=>'Ongoing Projects','completedProjects'=>'Completed Projects','pendingProjects'=>'Pending Projects'];
                $routeNames = ['ongoingProjects'=>'admin.project.ongoing'];
            @endphp

            @php
                $route = isset($routeNames[$key]) ? route($routeNames[$key]) : 'javascript:void(0)';
            @endphp

            <div class="col-md-3">
                <a href="{{ $route }}" class="text-decoration-none">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            
                            <i class="fas {{ $icons[$key] }} fa-2x {{ $colors[$key] }}"></i>
                            <h3 class="mt-2">{{ $value }}</h3>
                            <p class="text-muted mb-0">{{ $labels[$key] }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>


    
    
    <!-- Filter Buttons -->
    <div class="d-flex align-items-center mb-4" style="gap: 10px; justify-content: flex-end;">
        <button class="btn btn-secondary active filter-btn" data-range="today">Today</button>
        <button class="btn btn-secondary filter-btn" data-range="7days">Last 7 Days</button>
        <button class="btn btn-secondary filter-btn" data-range="30days">Last 30 Days</button>

        <div class="d-flex align-items-center" style="gap: 10px; justify-content: flex-end;">
            <input type="date" id="startDate" class="form-control form-control-sm">
            <input type="date" id="endDate" class="form-control form-control-sm">
            <button class="custom-btn" id="customFilterBtn">Filter</button>
        </div>
    </div>

    <h2 class="mb-4">Task Overview</h2>

    <!-- Task Overview -->
    <div class="row g-4 mb-4">
        <div class="col-md-3" id="todayTasksCard">
            <a href="javascript:void(0)" class="text-decoration-none">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-calendar-plus fa-2x text-primary"></i>
                        <h3 class="mt-2">{{ $tasks['todayTasks'] }}</h3>
                        <p class="text-muted mb-0">Today’s Tasks</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3" id="completedTasksCard">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="fas fa-tasks fa-2x text-success"></i>
                    <h3 class="mt-2">{{ $tasks['completedTasks'] }}</h3>
                    <p class="text-muted mb-0">Completed Tasks</p>
                </div>
            </div>
        </div>
        <div class="col-md-3" id="pendingTasksCard">
            <a href="javascript:void(0)" class="text-decoration-none">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-hourglass-half fa-2x text-warning"></i>
                        <h3 class="mt-2">{{ $tasks['pendingTasks'] }}</h3>
                        <p class="text-muted mb-0">Pending Tasks</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3" id="delayedTasksCard">
            <a href="javascript:void(0)" class="text-decoration-none">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                        <h3 class="mt-2">{{ $tasks['delayedTasks'] }}</h3>
                        <p class="text-muted mb-0">Delayed Tasks</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Charts -->
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Tasks Status Overview</h5>
                </div>
                <div class="card-body">
                    <canvas id="tasksBarChart" style="width:100%; height:100%;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Priority Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="tasksPieChart" style="width:100%; height:100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Employee Task Table (Detailed)</h4>
                </div>
                <div class="card-body">
                    <table id="employeeTaskTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Total Tasks</th>
                                <th>Completed</th>
                                <th>Active</th>
                                <th>Overdue</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $emp)
                            <tr>
                                <td>{{ $emp['name'] }}</td>
                                <td>{{ $emp['totalTasks'] }}</td>
                                <td>{{ $emp['completedTasks'] }}</td>
                                <td>{{ $emp['activeTasks'] }}</td>
                                <td>{{ $emp['overdueTasks'] }}</td>
                                <td>
                                    <a href="{{ route('admin.employee.tasks.detail', $emp['id']) }}" class="btn btn-sm btn-primary">
                                        View Work
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card mt-4">
                <div class="card-header">
                    <h4>Active Tasks / Subtasks</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="activeTimersTable">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Task</th>
                                <th>Subtask</th>
                                <th>Started At</th>
                                <th>Current Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activeTimers as $timer)
                                <tr>
                                    <td>{{ $timer['employee_name'] }}</td>
                                    <td>{{ $timer['task_title'] }}</td>
                                    <td>{{ $timer['subtask_title'] }}</td>
                                    <td>{{ $timer['started_at'] }}</td>
                                    <td class="duration">{{ $timer['duration'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No active timers found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header">
                    <h4>Project Calendar</h4>
                </div>
                <div class="card-body">
                    <select id="employeeFilter" class="select2">
                        <option value="">All Employees</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee['id'] }}">{{ $employee['name'] }}</option>
                        @endforeach
                    </select>
                    <div class="mt-3" id="adminCalendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    <script>
        $(document).ready(function(){
            $('#employeeTaskTable').DataTable({
                "ordering": true,
                "searching": true,
                "paging": true
            });
        });
    </script>

    <script>
        function formatTime(seconds) {
            const h = Math.floor(seconds / 3600).toString().padStart(2,'0');
            const m = Math.floor((seconds % 3600) / 60).toString().padStart(2,'0');
            const s = Math.floor(seconds % 60).toString().padStart(2,'0');
            return `${h}:${m}:${s}`;
        }

        function fetchActiveTimers() {
            $.get("{{ route('admin.activeTimers') }}", function(data) {
                const tbody = $("#activeTimersTable tbody");
                tbody.empty();

                if(data.length === 0){
                    tbody.append(`
                        <tr>
                            <td colspan="5" class="text-center">No active timers found.</td>
                        </tr>
                    `);
                    return;
                }

                data.forEach(timer => {
                    const start = new Date(timer.started_at);
                    const elapsed = Math.floor((new Date() - start)/1000);
                    tbody.append(`
                        <tr>
                            <td>${timer.employee_name}</td>
                            <td>${timer.task_title}</td>
                            <td>${timer.subtask_title}</td>
                            <td>${timer.started_at}</td>
                            <td>${formatTime(elapsed)}</td>
                        </tr>
                    `);
                });
            });
        }



        // Fetch every 5 seconds
        setInterval(fetchActiveTimers, 5000);
        fetchActiveTimers();
    </script>

    <script>
        let barChart, pieChart;

        // Initialize charts
        function initCharts(tasks){
            const barCtx = document.getElementById('tasksBarChart').getContext('2d');
            if(barChart) barChart.destroy();
            barChart = new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: ['Today', 'Ongoing', 'Pending', 'Delayed'],
                    datasets: [{
                        label: 'Tasks',
                        data: [tasks.todayTasks, tasks.ongoingTasks, tasks.pendingTasks, tasks.delayedTasks],
                        backgroundColor: ['#0d6efd','#198754','#ffc107','#dc3545'],
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    animation: {
                        duration: 1500,
                        easing: 'easeOutBounce'
                    }
                }
            });

            const pieCtx = document.getElementById('tasksPieChart').getContext('2d');
            if(pieChart) pieChart.destroy();
            pieChart = new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: ['Low','Medium','High','Critical'],
                    datasets:[{
                        data: [tasks.priorityLow, tasks.priorityMedium, tasks.priorityHigh, tasks.priorityCritical],
                        backgroundColor:['#6c757d','#0d6efd','#fd7e14','#dc3545']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'top' } },
                    animation: {
                        duration: 1500,
                        easing: 'easeOutBounce'
                    }
                }
            });
        }

        initCharts(@json($tasks));

        // AJAX filtering
        $(document).ready(function(){
            $('.filter-btn').click(function(){
                const range = $(this).data('range');
                fetchData({range: range});
            });

            $('#customFilterBtn').click(function(){
                const start = $('#startDate').val();
                const end = $('#endDate').val();
                fetchData({start: start, end: end});
            });

            function fetchData(data){
                $.ajax({
                    url: "{{ route('admin.summary.dashboard.filter') }}",
                    type: "GET",
                    data: data,
                    success: function(tasks){
                        $('#todayTasksCard h3').text(tasks.todayTasks);
                        $('#completedTasksCard h3').text(tasks.completedTasks);
                        $('#pendingTasksCard h3').text(tasks.pendingTasks);
                        $('#delayedTasksCard h3').text(tasks.delayedTasks);

                        initCharts(tasks); // update charts dynamically
                    }
                });
            }
        });
    </script>

    <script>
        // filtering functionality
        const filterButtons = document.querySelectorAll('.filter-btn');

        filterButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                filterButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const range = btn.getAttribute('data-range');
                console.log('Selected Range:', range);
            });
        });

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('adminCalendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: "auto",
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: {
                    url: "{{ route('admin.calendarData') }}",
                    method: 'GET',
                    extraParams: function() {
                        return {
                            employee_id: document.getElementById('employeeFilter').value
                        };
                    }
                },

                eventContent: function(arg) {
                    let props = arg.event.extendedProps;
                    let html = `
                        <div style="font-size:12px; line-height:1.3;">
                            <b>📌 ${arg.event.title}</b><br>
                            📂 ${props.project}<br>
                            👤 ${props.employee}
                        </div>
                    `;
                    return { html: html };
                },

                eventDidMount: function(info) {
                    const props = info.event.extendedProps;
                    info.el.setAttribute('title', 
                        `Project: ${props.project}\nEmployee: ${props.employee}\nStatus: ${props.status}`
                    );
                },

                eventClick: function(info) {
                    const props = info.event.extendedProps;
                    console.log(props);
                    alert(
                        `📌 Task: ${info.event.title}\n` +
                        `📂 Project: ${props.project}\n` +
                        `👤 Employee: ${props.employee}\n` +
                        `📅 From: ${info.event.start.toLocaleDateString()} → To: ${info.event.end.toLocaleDateString()}\n` +
                        `⚡ Status: ${props.status}\n` +
                        `⭐ Priority: ${props.priority}`
                    );
                }
                // eventClick: function(info) {
                //     const props = info.event.extendedProps;
                //     const subtasks = props.subtasks || [];
                //     let subtaskHtml = '';
                //     if(subtasks.length > 0){
                //         subtaskHtml = `<table style="width:100%; border-collapse: collapse;">
                //             <thead>
                //                 <tr>
                //                     <th style="border:1px solid #ddd; padding:5px;">Subtask</th>
                //                     <th style="border:1px solid #ddd; padding:5px;">Start</th>
                //                     <th style="border:1px solid #ddd; padding:5px;">End</th>
                //                     <th style="border:1px solid #ddd; padding:5px;">Time Logged</th>
                //                 </tr>
                //             </thead>
                //             <tbody>`;
                //         subtasks.forEach(st => {
                //             subtaskHtml += `
                //                 <tr>
                //                     <td style="border:1px solid #ddd; padding:5px;">${st.title}</td>
                //                     <td style="border:1px solid #ddd; padding:5px;">${st.start ? new Date(st.start).toLocaleString() : '-'}</td>
                //                     <td style="border:1px solid #ddd; padding:5px;">${st.end ? new Date(st.end).toLocaleString() : '-'}</td>
                //                     <td style="border:1px solid #ddd; padding:5px;">${st.time_logged || '00:00:00'}</td>
                //                 </tr>
                //             `;
                //         });
                //         subtaskHtml += '</tbody></table>';
                //     } else {
                //         subtaskHtml = '<p>No subtasks assigned.</p>';
                //     }

                //     Swal.fire({
                //         title: `<b>📌 Task: ${info.event.title}</b>`,
                //         html: `
                //             <p><strong>Project:</strong> ${props.project || '-'}</p>
                //             <p><strong>Employee(s):</strong> ${props.employee}</p>
                //             <p><strong>Status:</strong> ${props.status}</p>
                //             <p><strong>Priority:</strong> ${props.priority}</p>
                //             <p><strong>Duration:</strong> ${info.event.start.toLocaleDateString()} → ${info.event.end.toLocaleDateString()}</p>
                //             <hr>
                //             <h5>Subtasks</h5>
                //             ${subtaskHtml}
                //         `,
                //         width: '700px',
                //         showCloseButton: true,
                //         focusConfirm: false,
                //         confirmButtonText: 'Close',
                //     });
                // }
            });
            calendar.render();

            $('#employeeFilter').on('change', function() {
                calendar.refetchEvents();
            });
        });
    </script>
@endsection
