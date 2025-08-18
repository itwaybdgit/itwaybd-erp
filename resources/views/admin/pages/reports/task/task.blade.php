@extends('admin.master')


@section('title', 'Task Management Reports')

@push('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.css" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
        }
        .stats-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }
        .calendar-container {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .activity-item {
            background: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        .activity-item:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        .performance-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .fc-event {
            border: none !important;
            border-radius: 8px !important;
        }
        .loading-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200px;
        }
        .filter-section {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .overdue-task {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }
    </style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">Task Management Reports</h2>
                    <p class="text-muted">Monitor team performance and task progress</p>
                </div>
                <div>
                    <button class="btn btn-primary me-2" onclick="exportReport()">
                        <i class="fas fa-download me-2"></i>Export Report
                    </button>
                    <button class="btn btn-outline-primary" onclick="refreshData()">
                        <i class="fas fa-refresh me-2"></i>Refresh
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="filter-section">
                <div class="row">
                    <div class="col-md-3">
                        <label for="dateRange" class="form-label">Date Range</label>
                        <select class="form-select" id="dateRange" onchange="updateDateRange()">
                            <option value="today">Today</option>
                            <option value="week">This Week</option>
                            <option value="month" selected>This Month</option>
                            <option value="quarter">This Quarter</option>
                            <option value="custom">Custom Range</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="userFilter" class="form-label">Filter by User</label>
                        <select class="form-select" id="userFilter" onchange="filterByUser()">
                            <option value="">All Users</option>
                        </select>
                    </div>
                    <div class="col-md-3" id="customStartDate" style="display: none;">
                        <label for="startDate" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="startDate" onchange="refreshData()">
                    </div>
                    <div class="col-md-3" id="customEndDate" style="display: none;">
                        <label for="endDate" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="endDate" onchange="refreshData()">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4" id="statsCards">
        <div class="col-md-2">
            <div class="stats-card p-3 h-100">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-primary me-3">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted">Total Tasks</h6>
                        <h3 class="mb-0" id="totalTasks">
                            <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stats-card p-3 h-100">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-success me-3">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted">Completed</h6>
                        <h3 class="mb-0" id="completedTasks">
                            <div class="spinner-border spinner-border-sm text-success" role="status"></div>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stats-card p-3 h-100">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-info me-3">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted">In Progress</h6>
                        <h3 class="mb-0" id="inProgressTasks">
                            <div class="spinner-border spinner-border-sm text-info" role="status"></div>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stats-card p-3 h-100">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-warning me-3">
                        <i class="fas fa-pause-circle"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted">Pending</h6>
                        <h3 class="mb-0" id="pendingTasks">
                            <div class="spinner-border spinner-border-sm text-warning" role="status"></div>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stats-card p-3 h-100">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-danger me-3">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted">Overdue</h6>
                        <h3 class="mb-0" id="overdueTasks">
                            <div class="spinner-border spinner-border-sm text-danger" role="status"></div>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="stats-card p-3 h-100">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-secondary me-3">
                        <i class="fas fa-percentage"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted">Completion Rate</h6>
                        <h3 class="mb-0" id="completionRate">
                            <div class="spinner-border spinner-border-sm text-secondary" role="status"></div>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row">
        <!-- Calendar View -->
        <div class="col-lg-8 mb-4">
            <div class="calendar-container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Task Calendar</h4>
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-check" name="calendarView" id="monthView" checked>
                        <label class="btn btn-outline-primary" for="monthView">Month</label>
                        <input type="radio" class="btn-check" name="calendarView" id="weekView">
                        <label class="btn btn-outline-primary" for="weekView">Week</label>
                        <input type="radio" class="btn-check" name="calendarView" id="dayView">
                        <label class="btn btn-outline-primary" for="dayView">Day</label>
                    </div>
                </div>
                <div id="calendar"></div>
            </div>
        </div>

        <!-- Daily Activity & Charts -->
        <div class="col-lg-4 mb-4">
            <!-- Daily Activity -->
            <div class="performance-card mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Daily Activity</h5>
                    <input type="date" class="form-control w-auto" id="activityDate" onchange="loadDailyActivity()">
                </div>
                <div id="dailyActivityContainer">
                    <div class="loading-spinner">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                </div>
            </div>

            <!-- Progress Chart -->
            <div class="performance-card">
                <h5 class="mb-3">Task Progress Trend</h5>
                <div class="position-relative">
                    <canvas id="progressChart" height="200"></canvas>
                    <div id="chartLoader" class="position-absolute top-50 start-50 translate-middle">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Performance -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="performance-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">Team Performance</h4>
                    <div>
                        <select class="form-select" id="performancePeriod" onchange="loadTeamPerformance()">
                            <option value="7">Last 7 Days</option>
                            <option value="30" selected>Last 30 Days</option>
                            <option value="90">Last 90 Days</option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Employee</th>
                                <th>Total Tasks</th>
                                <th>Completed</th>
                                <th>Completion Rate</th>
                                <th>Time Logged</th>
                                <th>Avg. Time/Task</th>
                                <th>Performance</th>
                            </tr>
                        </thead>
                        <tbody id="teamPerformanceTable">
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="spinner-border text-primary" role="status"></div>
                                    <div class="mt-2 text-muted">Loading team performance data...</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Task Details Modal -->
<div class="modal fade" id="taskModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalTitle">Task Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="taskModalBody">
                <!-- Task details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="position-fixed top-0 start-0 w-100 h-100 d-none" style="background-color: rgba(255,255,255,0.8); z-index: 9999;">
    <div class="d-flex justify-content-center align-items-center h-100">
        <div class="text-center">
            <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;"></div>
            <div class="text-muted">Loading data...</div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <!-- FullCalendar JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

    <script>
        let calendar;
        let progressChart;

        // Initialize everything when document is ready
        $(document).ready(function() {
            initCalendar();
            loadTaskOverview();
            loadUsers();
            loadDailyActivity();
            loadTeamPerformance();
            initProgressChart();

            // Set today as default for activity date
            $('#activityDate').val(new Date().toISOString().split('T')[0]);
        });

        // Initialize FullCalendar
        function initCalendar() {
            const calendarEl = document.getElementById('calendar');
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 600,
                events: '{{ route("admin.task-reports.calendar-tasks") }}',
                eventClick: function(info) {
                    showTaskDetails(info.event);
                },
                eventDidMount: function(info) {
                    // Add tooltip with task details
                    info.el.setAttribute('title',
                        `${info.event.title}\n` +
                        `Status: ${info.event.extendedProps.status}\n` +
                        `Priority: ${info.event.extendedProps.priority}\n` +
                        `Progress: ${info.event.extendedProps.progress}%`
                    );

                    // Add overdue indicator
                    if (info.event.extendedProps.is_overdue) {
                        info.el.style.border = '2px solid #dc3545';
                        info.el.classList.add('overdue-task');
                    }
                },
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                loading: function(isLoading) {
                    if (isLoading) {
                        $('#calendar').append('<div class="calendar-loading position-absolute top-50 start-50 translate-middle"><div class="spinner-border text-primary"></div></div>');
                    } else {
                        $('.calendar-loading').remove();
                    }
                }
            });
            calendar.render();

            // Handle view changes
            $('input[name="calendarView"]').change(function() {
                const view = $(this).attr('id');
                switch(view) {
                    case 'monthView':
                        calendar.changeView('dayGridMonth');
                        break;
                    case 'weekView':
                        calendar.changeView('timeGridWeek');
                        break;
                    case 'dayView':
                        calendar.changeView('timeGridDay');
                        break;
                }
            });
        }

        // Load task overview statistics
        function loadTaskOverview() {
            const dateRange = getDateRange();

            $.get('{{ route("admin.task-reports.overview") }}', {
                start_date: dateRange.start,
                end_date: dateRange.end
            })
            .done(function(data) {
                $('#totalTasks').text(data.total_tasks);
                $('#completedTasks').text(data.completed_tasks);
                $('#inProgressTasks').text(data.in_progress_tasks);
                $('#pendingTasks').text(data.pending_tasks);
                $('#overdueTasks').text(data.overdue_tasks);
                $('#completionRate').text(data.completion_rate + '%');

                // Add animation to stats cards
                $('.stats-card').each(function(index) {
                    $(this).delay(index * 100).fadeIn();
                });
            })
            .fail(function(xhr) {
                console.error('Failed to load task overview:', xhr.responseText);
                showErrorToast('Failed to load task statistics');
            });
        }

        // Load users for dropdown
        function loadUsers() {
            $.get('{{ route("admin.task-reports.users") }}')
            .done(function(data) {
                const userSelect = $('#userFilter');
                userSelect.empty().append('<option value="">All Users</option>');

                data.forEach(user => {
                    userSelect.append(`<option value="${user.id}">${user.name}</option>`);
                });
            })
            .fail(function() {
                console.error('Failed to load users');
            });
        }

        // Load daily activity
        function loadDailyActivity() {
            const date = $('#activityDate').val();
            const userId = $('#userFilter').val();

            $('#dailyActivityContainer').html(`
                <div class="loading-spinner">
                    <div class="spinner-border text-primary" role="status"></div>
                    <div class="mt-2 text-muted small">Loading activity data...</div>
                </div>
            `);

            $.get('{{ route("admin.task-reports.user-activity") }}', {
                date: date,
                user_id: userId
            })
            .done(function(data) {
                let html = '';

                if (Object.keys(data).length === 0) {
                    html = `
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-calendar-times fa-2x mb-2"></i>
                            <div>No activity found for this date</div>
                        </div>
                    `;
                } else {
                    Object.values(data).forEach(user => {
                        html += `
                            <div class="activity-item">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0 d-flex align-items-center">
                                        <div class="bg-primary rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; font-size: 12px; color: white;">
                                            ${user.user_name.charAt(0).toUpperCase()}
                                        </div>
                                        ${user.user_name}
                                    </h6>
                                    <span class="badge bg-primary">${user.formatted_time}</span>
                                </div>
                                <div class="row text-sm mb-2">
                                    <div class="col-6">
                                        <small class="text-muted">
                                            <i class="fas fa-tasks me-1"></i>Tasks: ${user.tasks_worked}
                                        </small>
                                    </div>
                                    <div class="col-6 text-end">
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>Activities: ${user.activities.length}
                                        </small>
                                    </div>
                                </div>
                        `;

                        if (user.activities.length > 0) {
                            html += '<div class="mt-2">';
                            user.activities.slice(0, 3).forEach(activity => {
                                html += `
                                    <div class="d-flex justify-content-between align-items-center py-1 border-bottom">
                                        <small class="text-truncate me-2" title="${activity.subtask_title}">
                                            <i class="fas fa-dot-circle me-1 text-${getActivityStatusColor(activity.status)}"></i>
                                            ${activity.subtask_title}
                                        </small>
                                        <small class="text-muted">${activity.formatted_duration}</small>
                                    </div>
                                `;
                            });

                            if (user.activities.length > 3) {
                                html += `<small class="text-muted"><i class="fas fa-plus-circle me-1"></i>+${user.activities.length - 3} more activities</small>`;
                            }
                            html += '</div>';
                        }

                        html += '</div>';
                    });
                }

                $('#dailyActivityContainer').html(html);
            })
            .fail(function() {
                $('#dailyActivityContainer').html(`
                    <div class="text-center text-danger py-4">
                        <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                        <div>Failed to load activity data</div>
                    </div>
                `);
            });
        }

        // Load team performance
        function loadTeamPerformance() {
            const dateRange = getDateRange();

            $.get('{{ route("admin.task-reports.team-performance") }}', {
                start_date: dateRange.start,
                end_date: dateRange.end
            })
            .done(function(data) {
                let html = '';

                if (data.length === 0) {
                    html = `
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-users-slash fa-2x mb-2"></i>
                                <div>No performance data available</div>
                            </td>
                        </tr>
                    `;
                } else {
                    data.forEach((employee, index) => {
                        const performanceColor = getPerformanceColor(employee.completion_rate);

                        html += `
                            <tr class="table-row-animate" style="animation-delay: ${index * 100}ms;">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-light rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <span class="text-primary fw-bold">${employee.name.charAt(0).toUpperCase()}</span>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">${employee.name}</div>
                                            <small class="text-muted">${employee.email}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">${employee.total_subtasks}</span>
                                </td>
                                <td>
                                    <span class="badge bg-success">${employee.completed_subtasks}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 60px; height: 8px;">
                                            <div class="progress-bar bg-${performanceColor}" style="width: ${employee.completion_rate}%"></div>
                                        </div>
                                        <span class="text-${performanceColor} fw-semibold">${employee.completion_rate}%</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info text-white">${employee.formatted_time}</span>
                                </td>
                                <td>
                                    <span class="text-muted">${formatDuration(employee.avg_time_per_task)}</span>
                                </td>
                                <td>
                                    <span class="badge bg-${performanceColor}">${getPerformanceLabel(employee.completion_rate)}</span>
                                </td>
                            </tr>
                        `;
                    });
                }

                $('#teamPerformanceTable').html(html);
            })
            .fail(function() {
                $('#teamPerformanceTable').html(`
                    <tr>
                        <td colspan="7" class="text-center text-danger py-4">
                            <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                            <div>Failed to load team performance data</div>
                        </td>
                    </tr>
                `);
            });
        }

        // Initialize progress chart
        function initProgressChart() {
            const ctx = document.getElementById('progressChart').getContext('2d');

            progressChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Tasks Created',
                        data: [],
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true
                    }, {
                        label: 'Tasks Completed',
                        data: [],
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            },
                            grid: {
                                color: '#f3f4f6'
                            }
                        },
                        x: {
                            grid: {
                                color: '#f3f4f6'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#ffffff',
                            bodyColor: '#ffffff',
                            borderColor: '#3b82f6',
                            borderWidth: 1
                        }
                    },
                    animation: {
                        duration: 1000,
                        easing: 'easeInOutQuart'
                    }
                }
            });

            loadProgressChart();
        }

        // Load progress chart data
        function loadProgressChart() {
            $('#chartLoader').show();

            $.get('{{ route("admin.task-reports.progress-chart") }}', { days: 30 })
            .done(function(data) {
                const labels = data.map(item => new Date(item.date).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }));
                const created = data.map(item => item.created);
                const completed = data.map(item => item.completed);

                progressChart.data.labels = labels;
                progressChart.data.datasets[0].data = created;
                progressChart.data.datasets[1].data = completed;
                progressChart.update();

                $('#chartLoader').hide();
            })
            .fail(function() {
                $('#chartLoader').hide();
                console.error('Failed to load progress chart data');
            });
        }

        // Show task details modal
        function showTaskDetails(event) {
            const task = event.extendedProps;

            $('#taskModalTitle').text(event.title);
            $('#taskModalBody').html(`
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="border-bottom pb-2">Task Information</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td class="fw-semibold">Status:</td>
                                <td><span class="badge bg-${getStatusColor(task.status)}">${task.status}</span></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Priority:</td>
                                <td><span class="badge bg-${getPriorityColor(task.priority)}">${task.priority}</span></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Project:</td>
                                <td>${task.project}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Progress:</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 100px; height: 8px;">
                                            <div class="progress-bar bg-success" style="width: ${task.progress}%"></div>
                                        </div>
                                        <span>${task.progress}%</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Start:</td>
                                <td>${new Date(event.start).toLocaleString()}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">End:</td>
                                <td>${event.end ? new Date(event.end).toLocaleString() : 'Not set'}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="border-bottom pb-2">Assigned Users</h6>
                        <div class="d-flex flex-wrap mb-3">
                            ${task.assigned_users.map(user => `
                                <span class="badge bg-light text-dark me-1 mb-1 d-flex align-items-center">
                                    <i class="fas fa-user me-1"></i>${user}
                                </span>
                            `).join('')}
                        </div>
                        ${task.is_overdue ? `
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                This task is overdue!
                            </div>
                        ` : ''}
                    </div>
                </div>
            `);

            new bootstrap.Modal(document.getElementById('taskModal')).show();
        }

        // Helper functions
        function getDateRange() {
            const range = $('#dateRange').val();
            const now = new Date();
            let start, end;

            switch(range) {
                case 'today':
                    start = end = now.toISOString().split('T')[0];
                    break;
                case 'week':
                    const startOfWeek = new Date(now.setDate(now.getDate() - now.getDay()));
                    const endOfWeek = new Date(now.setDate(now.getDate() - now.getDay() + 6));
                    start = startOfWeek.toISOString().split('T')[0];
                    end = endOfWeek.toISOString().split('T')[0];
                    break;
                case 'quarter':
                    const quarter = Math.floor(now.getMonth() / 3);
                    start = new Date(now.getFullYear(), quarter * 3, 1).toISOString().split('T')[0];
                    end = new Date(now.getFullYear(), quarter * 3 + 3, 0).toISOString().split('T')[0];
                    break;
                case 'custom':
                    start = $('#startDate').val() || new Date().toISOString().split('T')[0];
                    end = $('#endDate').val() || new Date().toISOString().split('T')[0];
                    break;
                default: // month
                    start = new Date(now.getFullYear(), now.getMonth(), 1).toISOString().split('T')[0];
                    end = new Date(now.getFullYear(), now.getMonth() + 1, 0).toISOString().split('T')[0];
            }

            return { start, end };
        }

        function getPerformanceColor(rate) {
            if (rate >= 80) return 'success';
            if (rate >= 60) return 'warning';
            return 'danger';
        }

        function getPerformanceLabel(rate) {
            if (rate >= 80) return 'Excellent';
            if (rate >= 60) return 'Good';
            return 'Needs Improvement';
        }

        function getStatusColor(status) {
            const colors = {
                'Pending': 'warning',
                'In Progress': 'info',
                'Completed': 'success',
                'On Hold': 'danger'
            };
            return colors[status] || 'secondary';
        }

        function getPriorityColor(priority) {
            const colors = {
                'High': 'danger',
                'Medium': 'warning',
                'Low': 'info'
            };
            return colors[priority] || 'secondary';
        }

        function getActivityStatusColor(status) {
            const colors = {
                'active': 'success',
                'completed': 'primary',
                'paused': 'warning'
            };
            return colors[status] || 'secondary';
        }

        function formatDuration(seconds) {
            if (!seconds) return '00:00:00';
            const hours = Math.floor(seconds / 3600);
            const minutes = Math.floor((seconds % 3600) / 60);
            const secs = seconds % 60;
            return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        }

        function showErrorToast(message) {
            // You can implement a toast notification system here
            console.error(message);
        }

        function showLoadingOverlay() {
            $('#loadingOverlay').removeClass('d-none');
        }

        function hideLoadingOverlay() {
            $('#loadingOverlay').addClass('d-none');
        }

        // Event handlers
        function updateDateRange() {
            const range = $('#dateRange').val();
            if (range === 'custom') {
                $('#customStartDate, #customEndDate').show();
            } else {
                $('#customStartDate, #customEndDate').hide();
                refreshData();
            }
        }

        function filterByUser() {
            loadDailyActivity();
        }

        function refreshData() {
            showLoadingOverlay();

            Promise.all([
                loadTaskOverview(),
                loadDailyActivity(),
                loadTeamPerformance(),
                loadProgressChart()
            ]).finally(() => {
                calendar.refetchEvents();
                hideLoadingOverlay();
            });
        }

        function exportReport() {
            const dateRange = getDateRange();

            showLoadingOverlay();

            $.post('{{ route("admin.task-reports.export") }}', {
                start_date: dateRange.start,
                end_date: dateRange.end,
                user_id: $('#userFilter').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            })
            .done(function(data) {
                // Handle successful export
                alert('Export functionality will be implemented based on your requirements (CSV/Excel/PDF)');
            })
            .fail(function() {
                alert('Failed to export report. Please try again.');
            })
            .always(() => {
                hideLoadingOverlay();
            });
        }

        // Add some CSS animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .table-row-animate {
                animation: fadeInUp 0.5s ease forwards;
                opacity: 0;
            }
        `;
        document.head.appendChild(style);
    </script>
@endpush
