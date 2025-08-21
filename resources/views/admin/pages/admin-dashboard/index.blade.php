@extends('admin.master')


@section('title', 'Admin Dashboard')


@section('style')
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

/* Optional: active styling */
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
        <div class="col-md-3" id="ongoingTasksCard">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="fas fa-tasks fa-2x text-success"></i>
                    <h3 class="mt-2">{{ $tasks['ongoingTasks'] }}</h3>
                    <p class="text-muted mb-0">Ongoing Tasks</p>
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
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Tasks Status Overview</h5>
                </div>
                <div class="card-body">
                    <canvas id="tasksBarChart" style="width:100%; height:300px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
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
</div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                        $('#ongoingTasksCard h3').text(tasks.ongoingTasks);
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
@endsection
