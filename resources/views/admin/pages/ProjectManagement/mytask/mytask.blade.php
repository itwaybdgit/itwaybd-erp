
@extends('admin.master')

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f8f8;
            min-height: 100vh;
        }

        .container {
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e0e6ed;
        }

        .header h1 {
            color: #2c3e50;
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            padding: 12px 20px;
            border-radius: 25px;
            color: white;
        }

        .filters {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 10px 20px;
            border: 2px solid #667eea;
            background: transparent;
            color: #667eea;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .search-box {
            flex: 1;
            max-width: 300px;
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 12px 45px 12px 20px;
            border: 2px solid #e0e6ed;
            border-radius: 25px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .search-box i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            transform: translateY(0);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card i {
            font-size: 2rem;
            margin-bottom: 10px;
            opacity: 0.8;
        }

        .stat-card h3 {
            font-size: 2rem;
            margin-bottom: 5px;
            color: #fff;
        }

        .task-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 25px;
        }

        .task-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-left: 5px solid #667eea;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .task-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .task-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .task-title {
            color: #2c3e50;
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .task-meta {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
            font-size: 0.9rem;
            color: #7f8c8d;
        }

        .priority {
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .priority.high {
            background: #ffe6e6;
            color: #e74c3c;
        }

        .priority.medium {
            background: #fff3cd;
            color: #f39c12;
        }

        .priority.low {
            background: #d4edda;
            color: #27ae60;
        }

        .status {
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status.pending {
            background: #ffeaa7;
            color: #fdcb6e;
        }

        .status.in-progress {
            background: #74b9ff;
            color: white;
        }

        .status.completed {
            background: #00b894;
            color: white;
        }

        .status.on-hold {
            background: #636e72;
            color: white;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: #ecf0f1;
            border-radius: 4px;
            margin: 15px 0;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .time-tracking {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 15px 0;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .timer-display {
            font-size: 1.2rem;
            font-weight: 700;
            color: #667eea;
            font-family: 'Courier New', monospace;
        }

        .timer-controls {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-success {
            background: #00b894;
            color: white;
        }

        .btn-warning {
            background: #fdcb6e;
            color: white;
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .subtasks-section {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ecf0f1;
        }
        .subtasks-list{
            max-height: 220px; 
            overflow-y: auto;
        }

        .subtasks-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .subtask-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            margin-bottom: 8px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 3px solid #667eea;
        }

        .subtask-info {
            flex: 1;
        }

        .subtask-title {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 4px;
        }

        .subtask-meta {
            font-size: 0.8rem;
            color: #7f8c8d;
        }

        .subtask-item.active-timer {
            background: linear-gradient(135deg, #e8f8f5, #d5f4e6);
            border-left: 4px solid #27ae60;
        }

        .collaboration-section {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ecf0f1;
        }

        .team-members {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .member-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .member-avatar:hover {
            transform: scale(1.1);
        }

        .task-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            flex-wrap: wrap;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            backdrop-filter: blur(5px);
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 30px;
            border-radius: 15px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto!important;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #ecf0f1;
        }

        .close {
            font-size: 2rem;
            cursor: pointer;
            color: #7f8c8d;
            transition: color 0.3s ease;
        }

        .close:hover {
            color: #e74c3c;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #ecf0f1;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
                margin: 10px;
            }

            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .filters {
                flex-direction: column;
            }

            .task-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .floating-timer {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: linear-gradient(135deg, #ffffff, #fdfdfd);
            color: white !important;
            padding: 15px 20px;
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            display: none;
            z-index: 999;
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            display: none;
            z-index: 1001;
            animation: slideIn 0.3s ease;
        }

        .notification.success {
            background: #00b894;
        }

        .notification.error {
            background: #e74c3c;
        }

        .notification.info {
            background: #667eea;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        .task-card.active-timer {
            border-left-color: #00b894;
            background: linear-gradient(135deg, rgba(0, 184, 148, 0.05), rgba(102, 126, 234, 0.05));
        }

        .activity-log {
            max-height: 200px;
            overflow-y: auto;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-top: 15px;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #ecf0f1;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            background: #667eea;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.7rem;
        }
    </style>
    <div class="container">
        <div class="filters">
            <button class="filter-btn active" data-filter="all">All Tasks</button>
            <button class="filter-btn" data-filter="my-tasks">My Tasks</button>
            <button class="filter-btn" data-filter="team-tasks">Team Tasks</button>
            <button class="filter-btn" data-filter="completed">Completed</button>
            <button class="filter-btn" data-filter="overdue">Overdue</button>
            <div class="search-box">
                <input type="text" placeholder="Search tasks..." id="searchInput">
                <i class="fas fa-search"></i>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <i class="fas fa-tasks"></i>
                <h3 id="totalTasks">0</h3>
                <p>Total Tasks</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-clock"></i>
                <h3 id="activeTasks">0</h3>
                <p>Active Tasks</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-check-circle"></i>
                <h3 id="completedTasks">0</h3>
                <p>Completed</p>
            </div>
        </div>

        <div class="task-grid" id="taskGrid">
            <!-- Tasks will be populated here -->
        </div>
    </div>

    <!-- Floating Timer for Subtasks -->
    <div class="floating-timer" id="floatingTimer">
        <div class="timer-display">
            <i class="fas fa-clock"></i>
            <span id="floatingTimerDisplay">00:00:00</span>
            <span id="floatingTaskName"></span>
        </div>
        <button class="btn btn-sm btn-warning" onclick="pauseActiveSubtaskTimer()">
            <i class="fas fa-pause"></i>
        </button>
    </div>

    <!-- Notifications -->
    <div class="notification" id="notification"></div>

    <!-- Task Details Modal -->
    <div class="modal" id="taskModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Task Details</h2>
                <span class="close" onclick="closeModal('taskModal')">&times;</span>
            </div>
            <div id="modalContent">
                <!-- Content will be populated dynamically -->
            </div>
        </div>
    </div>

    <!-- Support Request Modal -->
    <div id="supportModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('supportModal')">&times;</span>
            <h3 id="supportModalTitle">Request Support</h3>
            <form id="supportForm">
                <div class="form-group">
                    <label>Select Team Member:</label>
                    <select id="supportMember" class="form-control">

                    </select>
                </div>
                <div class="form-group">
                    <label>Support Type:</label>
                    <select id="supportType" required>
                        <optgroup label="Software Development Team">
                            <option value="code-assistance">Code Assistance</option>
                            <option value="bug-fix">Bug Fix</option>
                            <option value="feature-review">Feature Review</option>
                            <option value="merge-support">Merge Support</option>
                        </optgroup>

                        <optgroup label="Accounts Team">
                            <option value="invoice-help">Invoice Help</option>
                            <option value="expense-approval">Expense Approval</option>
                            <option value="report-review">Report Review</option>
                        </optgroup>

                        <optgroup label="HR Team">
                            <option value="leave-request">Leave Request Help</option>
                            <option value="policy-explanation">Policy Explanation</option>
                            <option value="conflict-resolution">Conflict Resolution</option>
                        </optgroup>

                        <optgroup label="Support Team">
                            <option value="customer-issue">Customer Issue Handling</option>
                            <option value="ticket-assistance">Ticket Assistance</option>
                            <option value="live-support">Live Support Backup</option>
                        </optgroup>

                        <optgroup label="Sales Team">
                            <option value="lead-followup">Lead Follow-up</option>
                            <option value="proposal-review">Proposal Review</option>
                            <option value="client-demo">Client Demo Support</option>
                        </optgroup>
                    </select>
                </div>

                <div class="form-group">
                    <label>Message:</label>
                    <textarea id="supportMessage" rows="4" placeholder="Describe what kind of support you need..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send Support Request</button>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // CSRF setup for all jQuery AJAX calls
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Global variables - Remove localStorage related variables
        let currentTask = null;
        let activeSubtaskTimers = {};
        let taskData = [];
        let currentFilter = 'all';
        let currentUser = null;
        let currentActiveSubtask = null;
        let serverTimerSyncInterval = null;

        // Push notification setup
        function requestNotificationPermission() {
            if ('Notification' in window && Notification.permission === 'default') {
                Notification.requestPermission();
            }
        }

        function sendPushNotification(title, message, options = {}) {
            if ('Notification' in window && Notification.permission === 'granted') {
                const notification = new Notification(title, {
                    body: message,
                    icon: '/favicon.ico',
                    badge: '/favicon.ico',
                    ...options
                });

                setTimeout(() => {
                    notification.close();
                }, 5000);

                return notification;
            }
        }

        // Server-based timer functions
        function loadActiveTimerFromServer() {
            $.get('/api/my-active-timer')
                .done(function(response) {
                    if (response.active_timer) {
                        const timer = response.active_timer;
                        restoreServerTimer(timer);
                    }
                })
                .fail(function(xhr) {
                    console.error('Failed to load active timer:', xhr.responseText);
                });
        }

        function restoreServerTimer(timerData) {
            // Clear any existing local timer first
            clearCurrentTimer();

            const subtaskId = timerData.subtask_id;
            const startTime = new Date(timerData.started_at).getTime();

            // Set up the timer with server data
            activeSubtaskTimers[subtaskId] = {
                startTime: startTime,
                elapsed: timerData.current_duration,
                taskId: timerData.task_id,
                title: timerData.title,
                serverId: timerData.id,
                interval: setInterval(() => updateServerBasedTimer(subtaskId), 1000)
            };

            currentActiveSubtask = subtaskId;

            // Show floating timer
            $('#floatingTimer').show();
            $('#floatingTaskName').text(`- ${timerData.title}`);

            // Update UI
            $(`.subtask-item[data-subtask-id="${subtaskId}"]`).addClass('active-timer');

            // Render tasks to update UI
            setTimeout(() => renderTasks(), 100);

            console.log(`Server timer restored: ${timerData.title} (${timerData.formatted_duration} elapsed)`);
        }

        function updateServerBasedTimer(subtaskId) {
            const timer = activeSubtaskTimers[subtaskId];
            if (!timer) return;

            const currentTime = Math.floor((Date.now() - timer.startTime) / 1000);

            const timerDisplay = $(`#subtask-timer-${subtaskId}`);
            if (timerDisplay.length) {
                timerDisplay.text(formatTime(currentTime));
            }

            const modalTimerDisplay = $(`#modal-subtask-timer-${subtaskId}`);
            if (modalTimerDisplay.length) {
                modalTimerDisplay.text(formatTime(currentTime));
            }

            $('#floatingTimerDisplay').text(formatTime(currentTime));
        }

        function syncWithServer() {
            if (currentActiveSubtask && activeSubtaskTimers[currentActiveSubtask]) {
                $.post(`/api/subtasks/${currentActiveSubtask}/auto-save-timer`)
                    .done(function(response) {
                        // Update local timer with server data
                        const timer = activeSubtaskTimers[currentActiveSubtask];
                        if (timer) {
                            timer.elapsed = response.current_duration;
                        }
                    })
                    .fail(function(xhr) {
                        console.warn('Failed to sync with server:', xhr.responseText);
                    });
            }
        }

        function clearCurrentTimer() {
            if (currentActiveSubtask && activeSubtaskTimers[currentActiveSubtask]) {
                const timer = activeSubtaskTimers[currentActiveSubtask];
                clearInterval(timer.interval);
                delete activeSubtaskTimers[currentActiveSubtask];
            }

            currentActiveSubtask = null;
            $('#floatingTimer').hide();
            $('.subtask-item').removeClass('active-timer');
        }

        // Initialize the application
        $(document).ready(function() {
            requestNotificationPermission();

            loadMyTasks();
            loadTaskStats();
            setupEventListeners();

            // Load active timer from server
            setTimeout(() => {
                loadActiveTimerFromServer();
            }, 1000);

            // Refresh tasks periodically
            setInterval(loadMyTasks, 30000);

            // Sync with server every 10 seconds
            serverTimerSyncInterval = setInterval(syncWithServer, 10000);
        });

        function setupEventListeners() {
            $('.filter-btn').on('click', function() {
                $('.filter-btn').removeClass('active');
                $(this).addClass('active');
                currentFilter = $(this).data('filter');
                renderTasks();
            });

            $('#searchInput').on('input', function() {
                renderTasks();
            });

            $('#supportForm').on('submit', function(e) {
                e.preventDefault();
                handleSupportRequest();
            });

            // Handle page visibility changes
            document.addEventListener('visibilitychange', function() {
                if (document.visibilityState === 'visible') {
                    // Tab became visible, sync with server
                    setTimeout(() => {
                        loadActiveTimerFromServer();
                        renderTasks();
                    }, 500);
                }
            });

            // Handle browser focus events
            $(window).on('focus', function() {
                // Window gained focus, sync with server
                setTimeout(() => {
                    loadActiveTimerFromServer();
                    renderTasks();
                }, 100);
            });
        }

        function startSubtaskTimer(taskId, subtaskId, subtaskTitle) {
            if (activeSubtaskTimers[subtaskId]) return;

            $.post(`/api/subtasks/${subtaskId}/start-timer`, {
                _token: $('meta[name="csrf-token"]').attr('content')
            })
                .done(function(response) {
                    const startTime = new Date(response.started_at).getTime();

                    $('#floatingTimer').show();
                    $('#floatingTaskName').text(`- ${subtaskTitle}`);

                    activeSubtaskTimers[subtaskId] = {
                        startTime: startTime,
                        elapsed: 0,
                        taskId: taskId,
                        title: subtaskTitle,
                        serverId: response.timer_id,
                        interval: setInterval(() => updateServerBasedTimer(subtaskId), 1000)
                    };

                    currentActiveSubtask = subtaskId;

                    $(`.subtask-item[data-subtask-id="${subtaskId}"]`).addClass('active-timer');
                    renderTasks();

                    showNotification('Timer started for: ' + subtaskTitle, 'success');
                    sendPushNotification('Timer Started', `Working on: ${subtaskTitle}`);
                })
                .fail(function(xhr) {
                    showNotification('Failed to start subtask timer', 'error');
                    console.error('Timer start error:', xhr.responseText);
                });
        }

        function pauseSubtaskTimer(taskId, subtaskId) {
            const timer = activeSubtaskTimers[subtaskId];
            if (!timer) return;

            $.post(`/api/subtasks/${subtaskId}/pause-timer`, {
                _token: $('meta[name="csrf-token"]').attr('content')
            })
                .done(function(response) {
                    // Clear local timer
                    clearInterval(timer.interval);
                    delete activeSubtaskTimers[subtaskId];
                    currentActiveSubtask = null;

                    // Update task data locally
                    const task = taskData.find(t => t.id === taskId);
                    if (task) {
                        const subtask = task.subtasks.find(st => st.id === subtaskId);
                        if (subtask) {
                            subtask.time_logged += response.duration;
                            task.time_logged += response.duration;
                        }
                    }

                    $(`.subtask-item[data-subtask-id="${subtaskId}"]`).removeClass('active-timer');
                    renderTasks();

                    $('#floatingTimer').hide();

                    showNotification(`Subtask time logged: ${response.formatted_duration}`, 'success');
                    sendPushNotification('Timer Paused', `Logged ${response.formatted_duration} for: ${timer.title}`);
                })
                .fail(function(xhr) {
                    showNotification('Failed to pause subtask timer', 'error');
                    console.error('Timer pause error:', xhr.responseText);
                });
        }

        function pauseActiveSubtaskTimer() {
            if (currentActiveSubtask) {
                const timer = activeSubtaskTimers[currentActiveSubtask];
                if (timer) {
                    pauseSubtaskTimer(timer.taskId, currentActiveSubtask);
                }
            }
        }

        // Rest of your existing functions remain the same...
        function loadMyTasks() {
            $.get('/api/my-tasks')
                .done(function(response) {
                    taskData = response.tasks;
                    renderTasks();
                })
                .fail(function(xhr) {
                    console.error('Failed to load tasks:', xhr.responseText);
                    showNotification('Failed to load tasks', 'error');
                });
        }

        function loadTaskStats() {
            $.get('/api/my-task-stats')
                .done(function(stats) {
                    updateStatsDisplay(stats);
                })
                .fail(function(xhr) {
                    console.error('Failed to load stats:', xhr.responseText);
                });
        }

        function updateStatsDisplay(stats) {
            $('#totalTasks').text(stats.totalTasks);
            $('#activeTasks').text(stats.activeTasks);
            $('#completedTasks').text(stats.completedTasks);
            $('#overdueTasks').text(stats.overdueTasks || 0);
        }

        // Keep all your existing rendering functions...
        function renderTasks() {
            const searchTerm = $('#searchInput').val().toLowerCase();
            let filteredTasks = taskData;

            filteredTasks = filteredTasks.filter(task => {
                const matchesSearch = task.title.toLowerCase().includes(searchTerm) ||
                    task.description.toLowerCase().includes(searchTerm);

                const matchesFilter = (() => {
                    switch (currentFilter) {
                        case 'my-tasks':
                            return true;
                        case 'completed':
                            return task.status.toLowerCase() === 'completed';
                        case 'overdue':
                            return task.is_overdue;
                        case 'in-progress':
                            return task.status.toLowerCase() === 'in progress';
                        default:
                            return true;
                    }
                })();

                return matchesSearch && matchesFilter;
            });

            const taskGrid = $('#taskGrid');
            taskGrid.empty();

            if (filteredTasks.length === 0) {
                taskGrid.append(
                    '<div class="no-tasks"><h3>No tasks found</h3><p>You have no tasks matching the current filters.</p></div>'
                );
                return;
            }

            filteredTasks.forEach((task, index) => {
                taskGrid.append(createTaskCard(task));
            });

        }

        function createTaskCard(task) {
            const completedSubtasks = task.subtasks.filter(st => st.status === 'completed').length;
            const totalSubtasks = task.subtasks.length;
            const progressPercentage = totalSubtasks > 0 ? Math.round((completedSubtasks / totalSubtasks) * 100) : 0;

            const now = new Date();
            const dueDate = new Date(task.end_date_time);
            const isOverdueNow = dueDate < now;

            return `
                <div class="task-card" data-task-id="${task.id}">
                    <div class="task-header">
                        <div>
                            <div class="task-title">${task.title}</div>
                            <div class="task-meta">
                                <span><i class="fas fa-calendar"></i> Due: ${formatDate(task.end_date_time)}</span>
                                ${task.is_overdue ? '<span style="color: #e74c3c;"><i class="fas fa-exclamation-triangle"></i> Overdue</span>' : ''}
                            </div>
                        </div>
                        <div>
                            <span class="priority ${task.priority.toLowerCase()}">${task.priority}</span>
                            <span class="status ${task.status.toLowerCase().replace(' ', '-')}">${task.status}</span>
                        </div>
                    </div>

                    ${isOverdueNow ? `
                    <div class="alert-overdue" style="margin-top: 10px; padding: 10px; background-color: #f8d7da; color: #721c24; border-left: 4px solid #dc3545; border-radius: 4px;">
                        <i class="fas fa-exclamation-circle"></i> This task is overdue!
                    </div>
                ` : ''}

                    <div class="task-description-content" id="desc-${task.id}">
                        ${truncateDescription(task.description, 100)}
                    </div>
                    <a href="javascript:void(0)"
                    class="read-more-toggle"
                    data-task-id="${task.id}"
                    data-full-description='${encodeURIComponent(task.description)}'
                    onclick="toggleDescription(this)">Read more</a>

                    <div class="progress-section">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: ${task.progress}%"></div>
                        </div>
                        <small style="color: #7f8c8d;">${task.progress}% Complete (${completedSubtasks}/${totalSubtasks} subtasks)</small>
                    </div>

                    <div class="time-tracking">
                        <div class="timer-display">
                            <span>Total Time: ${formatTime(task.time_logged)}</span>
                        </div>
                        <div class="timer-controls">
                            <button class="btn btn-primary" onclick="openTaskDetails(${task.id})">
                                <i class="fas fa-eye"></i> Details
                            </button>
                        </div>
                    </div>

                    <div class="subtasks-section">
                        <div class="subtasks-header">
                            <h4><i class="fas fa-list-ul"></i> My Subtasks</h4>
                            <button type="button" id="add-subtask-btn" onclick="addNewSubtask(${task.id})" class="btn btn-sm btn-primary">+ Add Subtask</button>
                        </div>
                        <div class="subtasks-list">
                            ${task.subtasks.map(subtask => {
                                const isActiveTimer = activeSubtaskTimers[subtask.id];
                                return `
                                    <div class="subtask-item ${isActiveTimer ? 'active-timer' : ''}" data-subtask-id="${subtask.id}" style="display: flex; flex-direction: column; width: 100%;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                                            <div class="subtask-info" onclick="toggleSubtaskDescription(${subtask.id})" style="cursor: pointer; flex-grow: 1;">
                                                <div class="subtask-title">
                                                    ${subtask.title}
                                                    <i class="fas fa-chevron-down subtask-toggle-icon" id="toggle-icon-${subtask.id}" style="font-size: 12px; margin-left: 8px; transition: transform 0.3s ease;"></i>
                                                </div>
                                                <div class="subtask-meta">
                                                    <span class="priority ${subtask.priority}">${subtask.priority}</span>
                                                    <span class="status ${subtask.status.replace(' ', '-')}">${subtask.status.replace('-', ' ')}</span>
                                                    <span>Time: ${isActiveTimer ? `<span id="subtask-timer-${subtask.id}" style="color: #e74c3c; font-weight: bold;">00:00:00</span>` : formatTime(subtask.time_logged)}</span>
                                                </div>
                                            </div>

                                            <div class="subtask-actions">
                                                ${isActiveTimer ? `
                                                <button class="btn btn-warning btn-sm" onclick="pauseSubtaskTimer(${task.id}, ${subtask.id})">
                                                    <i class="fas fa-pause"></i>
                                                </button>` : `
                                                <button class="btn btn-success btn-sm" onclick="startSubtaskTimer(${task.id}, ${subtask.id}, '${subtask.title}')">
                                                    <i class="fas fa-play"></i>
                                                </button>`
                                                }

                                                ${subtask.status !== 'completed' ? `
                                                <button class="btn btn-primary btn-sm" onclick="markSubtaskComplete(${subtask.id})">
                                                    <i class="fas fa-check"></i>
                                                </button>` : ''
                                                }
                                                <button class="btn btn-info btn-sm" onclick="requestSubtaskSupport(${task.id}, ${subtask.id}, '${subtask.title}')">
                                                    <i class="fas fa-hands-helping"></i> Help
                                                </button>
                                            </div>
                                        </div>

                                        <div class="subtask-description-box" id="subtask-desc-${subtask.id}" style="display: none; margin-top: 8px; padding: 10px; background-color: #f8f9fa; border-left: 3px solid #007bff; border-radius: 4px; font-size: 14px; color: #6c757d; width: 100%;">
                                            ${subtask.description || 'No description available'}
                                        </div>
                                    </div>
                                `;
                            }).join('')}
                            

                            <div class="subtasks-containerr" id="subtasks-container-${task.id}"></div>

                            <button type="button" onclick="saveSubtasks(${task.id})" class="btn btn-success mt-2 d-none saveSubtasks" id="">💾 Save Subtasks</button>

                        </div>
                    </div>
                    <div class="task-actions">
                        <button class="btn btn-primary" onclick="openTaskDetails(${task.id})">
                            <i class="fas fa-eye"></i> View Details
                        </button>
                    </div>
                </div>
            `;
        }

        let subtaskCounter = 0;

        function addNewSubtask(taskId) {
            if (!taskId) {
                console.error("Task ID is required to add a subtask.");
                return;
            }
            subtaskCounter++;
            if(subtaskCounter != 0) {
                const thisContainer = document.querySelector(`#subtasks-container-${taskId}`);
                const saveButton = thisContainer.nextElementSibling;
                if (saveButton && saveButton.classList.contains("d-none")) {
                    saveButton.classList.remove("d-none");
                }
            }
            let subtaskHTML = `
                <div class="subtask-item" id="subtask-${subtaskCounter}">
                    <div class="row">
                        <div class="col-6">
                            <input type="text" class="form-control mb-1" name="subtasks[${subtaskCounter}][title]" placeholder="Subtask Title" required>
                        </div>
                        <div class="col-3">
                            <select class="form-control mb-1" name="subtasks[${subtaskCounter}][priority]">
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                                <option value="Critical">Critical</option>
                            </select>
                        </div>

                        <div class="col-3">

                            <select class="form-control mb-1" name="subtasks[${subtaskCounter}][status]">
                                <option value="Pending" selected>Pending</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <textarea class="form-control mb-1" name="subtasks[${subtaskCounter}][description]" placeholder="Subtask Description"></textarea>
                        </div>
                        
                    </div>

                    <button type="button" onclick="removeSubtask(${subtaskCounter}, '${taskId}')" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i> Remove Subtask
                    </button>
                </div>
            `;

            document.getElementById('subtasks-container-' + taskId).insertAdjacentHTML('beforeend', subtaskHTML);
        }

        function saveSubtasks(taskId) {
            if (!taskId) {
                console.error("Task ID is required to save subtasks.");
                return;
            }
            let subtasks = [];

            document.querySelectorAll('#subtasks-container-' + taskId + ' .subtask-item').forEach((item, index) => {
                let title = item.querySelector('input[name*="[title]"]').value;
                let priority = item.querySelector('select[name*="[priority]"]').value;
                let status = item.querySelector('select[name*="[status]"]').value;
                let description = item.querySelector('textarea[name*="[description]"]').value;

                subtasks.push({ title, priority, status, description });
            });
            fetch('/api/subtasks/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ task_id: taskId, subtasks: subtasks })
            })
            .then(res => res.json())
            .then(data => {
                alert("Subtasks saved successfully!");
                const subtaskList = document.querySelector(`.task-card[data-task-id="${taskId}"] .subtasks-list`);
                const container = document.getElementById(`subtasks-container-${taskId}`);


                container.innerHTML = "";
                data.data.forEach(subtask => {
                    console.log("Adding subtask:", subtask);
                    let subtaskHTML = `
                        <div class="subtask-item" data-subtask-id="${subtask.id}" style="display: flex; flex-direction: column; width: 100%;">
                            <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                                <div class="subtask-info" onclick="toggleSubtaskDescription(${subtask.id})" style="cursor: pointer; flex-grow: 1;">
                                    <div class="subtask-title">
                                        ${subtask.title}
                                        <i class="fas fa-chevron-down subtask-toggle-icon" id="toggle-icon-${subtask.id}" style="font-size: 12px; margin-left: 8px; transition: transform 0.3s ease;"></i>
                                    </div>
                                    <div class="subtask-meta">
                                        <span class="priority ${subtask.priority}">${subtask.priority}</span>
                                        <span class="status ${subtask.status.replace(' ', '-')}">${subtask.status}</span>
                                        <span>Time: ${formatTime(subtask.time_logged ?? 0)}</span>
                                    </div>
                                </div>

                                <div class="subtask-actions">
                                    <button class="btn btn-success btn-sm" onclick="startSubtaskTimer(${taskId}, ${subtask.id}, '${subtask.title}')">
                                        <i class="fas fa-play"></i>
                                    </button>
                                    <button class="btn btn-primary btn-sm" onclick="markSubtaskComplete(${subtask.id})">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-info btn-sm" onclick="requestSubtaskSupport(${taskId}, ${subtask.id}, '${subtask.title}')">
                                        <i class="fas fa-hands-helping"></i> Help
                                    </button>
                                </div>
                            </div>

                            <div class="subtask-description-box" id="subtask-desc-${subtask.id}" style="display: none; margin-top: 8px; padding: 10px; background-color: #f8f9fa; border-left: 3px solid #007bff; border-radius: 4px; font-size: 14px; color: #6c757d; width: 100%;">
                                ${subtask.description || 'No description available'}
                            </div>
                        </div>
                    `;
                    container.insertAdjacentHTML('beforeend', subtaskHTML);
                });
            })
            .catch(err => console.error("Error:", err));
        }

        function removeSubtask(id) {
            const currentSubTask = document.getElementById(`subtask-${id}`);
            const currentContainer = currentSubTask.closest('.subtasks-containerr');
            const currentSaveBtn = currentContainer.nextElementSibling;

            subtaskCounter--;
            currentSubTask.remove();

            if(subtaskCounter == 0 && currentSaveBtn && currentSaveBtn.classList.contains("saveSubtasks")) {
                currentSaveBtn.classList.add("d-none");
            }
        }







        function requestSubtaskSupport(taskId, subtaskId, subtaskTitle) {
            const task = taskData.find(t => t.id === taskId);
            if (!task) return;

            currentTask = task;
            currentSubtask = {
                id: subtaskId,
                title: subtaskTitle
            };

            const supportSelect = $('#supportMember');
            supportSelect.empty().append('<option value="">Choose a team member...</option>');

            task.team_members.forEach(member => {
                supportSelect.append(`<option value="${member.id}">${member.name} (${member.role})</option>`);
            });

            // Update the modal title to show it's for a specific subtask
            $('#supportModalTitle').text(`Request Support for: ${subtaskTitle}`);

            // Initialize or re-initialize Select2 on the dropdown
            supportSelect.select2({
                placeholder: 'Search a team member...',
                width: '100%',
                dropdownParent: $('#supportModal')
            });

            $('#supportModal').show();
        }

        // Function to toggle subtask description visibility
        function toggleSubtaskDescription(subtaskId) {
            const descBox = document.getElementById(`subtask-desc-${subtaskId}`);
            const toggleIcon = document.getElementById(`toggle-icon-${subtaskId}`);

            if (descBox.style.display === 'none' || descBox.style.display === '') {
                descBox.style.display = 'block';
                toggleIcon.style.transform = 'rotate(180deg)';
                toggleIcon.classList.remove('fa-chevron-down');
                toggleIcon.classList.add('fa-chevron-up');
            } else {
                descBox.style.display = 'none';
                toggleIcon.style.transform = 'rotate(0deg)';
                toggleIcon.classList.remove('fa-chevron-up');
                toggleIcon.classList.add('fa-chevron-down');
            }
        }

        function truncateDescription(description, wordLimit) {
            const words = description.trim().split(/\s+/);
            if (words.length <= wordLimit) {
                return `<p>${description}</p>`;
            }
            const shortText = words.slice(0, wordLimit).join(' ');
            return `<p>${shortText}...</p>`;
        }

        function toggleDescription(element) {
            const taskId = element.dataset.taskId;
            const fullDescription = decodeURIComponent(element.dataset.fullDescription);
            const descDiv = document.getElementById(`desc-${taskId}`);

            if (element.innerText === 'Read more') {
                descDiv.innerHTML = `<p>${fullDescription}</p>`;
                element.innerText = 'Show less';
            } else {
                descDiv.innerHTML = truncateDescription(fullDescription, 100);
                element.innerText = 'Read more';
            }
        }

        function markSubtaskComplete(subtaskId) {
            $.post(`/api/subtasks/${subtaskId}/status`, {
                    status: 'Completed',
                    _token: $('meta[name="csrf-token"]').attr('content')
                })
                .done(function(response) {
                    showNotification('Subtask marked as complete!', 'success');
                    loadMyTasks();

                    const task = taskData.find(t => t.subtasks.some(st => st.id === subtaskId));
                    const subtask = task ? task.subtasks.find(st => st.id === subtaskId) : null;

                    if (subtask) {
                        sendPushNotification('Subtask Completed!', `✅ ${subtask.title} has been completed`);
                    }
                })
                .fail(function(xhr) {
                    showNotification('Failed to update subtask', 'error');
                });
        }

        function handleSupportRequest() {
            const supportData = {
                _token: $('meta[name="csrf-token"]').attr('content'),
                task_id: currentTask.id,
                subtask_id: currentSubtask?.id || null,
                subtask_title: currentSubtask?.title || null,
                member_id: $('#supportMember').val(),
                support_type: $('#supportType').val(),
                message: $('#supportMessage').val(),
            };

            $.post('/api/support-requests', supportData)
                .done(function(response) {
                    showNotification('Support request sent successfully!', 'success');
                    closeModal('supportModal');
                    $('#supportForm')[0].reset();
                    currentSubtask = null;
                })
                .fail(function(xhr) {
                    showNotification('Failed to send support request', 'error');
                });
        }

        function openTaskDetails(taskId) {
            const task = taskData.find(t => t.id === taskId);
            if (!task) return;

            $('#modalTitle').text(task.title);

            const modalContent = `
        <div class="task-details">
            <div class="detail-section">
                <h4><i class="fas fa-info-circle"></i> Task Information</h4>
                <p><strong>Description:</strong> ${task.description}</p>
                <p><strong>Priority:</strong> <span class="priority ${task.priority.toLowerCase()}">${task.priority}</span></p>
                <p><strong>Status:</strong> <span class="status ${task.status.toLowerCase().replace(' ', '-')}">${task.status}</span></p>
                <p><strong>Progress:</strong> ${task.progress}%</p>
                <p><strong>Start Date:</strong> ${formatDate(task.start_date_time)}</p>
                <p><strong>Due Date:</strong> ${formatDate(task.end_date_time)}</p>
                <p><strong>Total Time Logged:</strong> ${formatTime(task.time_logged)}</p>
                ${task.is_overdue ? '<p style="color: #e74c3c;"><strong>Status:</strong> Overdue!</p>' : ''}
            </div>

            <div class="detail-section">
                <h4><i class="fas fa-list-ul"></i> My Subtasks</h4>
                <div class="subtasks-detail">
                    ${task.subtasks.map(subtask => {
                        const isActiveTimer = activeSubtaskTimers[subtask.id];
                        return `
                                                                        <div class="subtask-detail-item ${isActiveTimer ? 'active-timer' : ''}">
                                                                            <div class="subtask-header">
                                                                                <h5>${subtask.title}</h5>
                                                                                <div>
                                                                                    <span class="priority ${subtask.priority}">${subtask.priority}</span>
                                                                                    <span class="status ${subtask.status.replace(' ', '-')}">${subtask.status.replace('-', ' ')}</span>
                                                                                </div>
                                                                            </div>
                                                                            <p><strong>Time Logged:</strong> ${isActiveTimer ? `<span id="modal-subtask-timer-${subtask.id}" style="color: #e74c3c; font-weight: bold;">00:00:00</span>` : formatTime(subtask.time_logged)}</p>
                                                                            <div class="subtask-actions">
                                                                                ${isActiveTimer ?
                                                                                    `<button class="btn btn-warning btn-sm" onclick="pauseSubtaskTimer(${task.id}, ${subtask.id})">
                                        <i class="fas fa-pause"></i> Pause Timer
                                    </button>` :
                                                                                    `<button class="btn btn-success btn-sm" onclick="startSubtaskTimer(${task.id}, ${subtask.id}, '${subtask.title}')">
                                        <i class="fas fa-play"></i> Start Timer
                                    </button>`
                                                                                }
                                                                                <button class="btn btn-info btn-sm" onclick="sendSubtaskPushNotification(${subtask.id}, '${subtask.title}')">
                                                                                    <i class="fas fa-bell"></i> Push Notification
                                                                                </button>
                                                                                ${subtask.status !== 'completed' ?
                                                                                    `<button class="btn btn-primary btn-sm" onclick="markSubtaskComplete(${subtask.id})">
                                        <i class="fas fa-check"></i> Mark Complete
                                    </button>` : ''
                                                                                }
                                                                            </div>
                                                                        </div>
                                                                        `;
                    }).join('')}
                </div>
            </div>

        </div>
        `;

            $('#modalContent').html(modalContent);
            $('#taskModal').show();
        }

        // Utility functions
        function formatTime(seconds) {
            if (!seconds || seconds < 0) return "00:00:00";

            const hours = Math.floor(seconds / 3600);
            const minutes = Math.floor((seconds % 3600) / 60);
            const secs = seconds % 60;
            return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        function closeModal(modalId) {
            $('#' + modalId).hide();
        }

        function showNotification(message, type) {
            const notification = $('#notification');
            notification.removeClass('success error info').addClass(type);
            notification.text(message).show();

            setTimeout(() => {
                notification.hide();
            }, 3000);
        }

        function sendSubtaskPushNotification(subtaskId, title) {
            sendPushNotification('Subtask Reminder', `Don't forget about: ${title}`);
        }

        // Close modals when clicking outside
        $(window).on('click', function(e) {
            if ($(e.target).hasClass('modal')) {
                $(e.target).hide();
            }
        });

        // Cleanup on page unload
        $(window).on('beforeunload', function() {
            // Clear intervals to prevent memory leaks
            if (serverTimerSyncInterval) {
                clearInterval(serverTimerSyncInterval);
            }

            Object.values(activeSubtaskTimers).forEach(timer => {
                if (timer.interval) {
                    clearInterval(timer.interval);
                }
            });
        });

        // Server-based timer management functions
        function getActiveTimerInfo() {
            return $.get('/api/my-active-timer')
                .then(function(response) {
                    return response.active_timer;
                });
        }

        function isTimerActive() {
            return currentActiveSubtask !== null;
        }

        // Export functions for global access
        window.taskTimerManager = {
            getActiveTimer: getActiveTimerInfo,
            isActive: isTimerActive,
            pause: pauseActiveSubtaskTimer,
            syncWithServer: syncWithServer
        };

        // Debug functions (remove in production)
        window.debugTimer = {
            showActiveTimer: () => {
                getActiveTimerInfo().then(timer => {
                    console.log('Active Timer:', timer);
                });
            },
            forceSync: () => {
                loadActiveTimerFromServer();
                console.log('Timer synced with server');
            },
            clearLocalTimer: () => {
                clearCurrentTimer();
                console.log('Local timer cleared');
            }
        };
    </script>
@endsection
