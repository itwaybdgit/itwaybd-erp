<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Modal Debug</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
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

        /* Custom Modal Styles */
        .task-modal .modal-dialog {
            max-width: 900px;
            margin: 1rem auto;
        }

        .task-modal .modal-content {
            border-radius: 8px;
            overflow: hidden;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
        }

        .modal-tabs {
            display: flex;
            border-bottom: 1px solid #e9ecef;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .modal-tab {
            padding: 12px 20px;
            background: none;
            border: none;
            cursor: pointer;
            color: #6c757d;
            font-size: 14px;
            border-bottom: 2px solid transparent;
            transition: all 0.2s;
        }

        .modal-tab.active {
            color: #495057;
            border-bottom-color: #007bff;
            background: white;
        }

        .task-modal .modal-header {
            padding: 0;
            border-bottom: none;
            position: relative;
        }

        .task-modal .modal-body {
            padding: 0;
            display: flex;
            flex: 1;
            overflow: hidden;
        }

        .modal-main-content {
            flex: 1;
            padding: 24px;
            overflow-y: auto;
        }

        .modal-sidebar {
            width: 280px;
            background: #f8f9fa;
            padding: 20px;
            border-left: 1px solid #e9ecef;
            overflow-y: auto;
        }

        .task-title {
            font-size: 24px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }

        .project-info {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 4px;
        }

        .project-link {
            color: #007bff;
            text-decoration: none;
        }

        .section {
            margin-bottom: 32px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .task-details {
            color: #6c757d;
            line-height: 1.6;
            margin-bottom: 16px;
        }

        .checklist-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .checklist-counter {
            color: #6c757d;
            font-size: 14px;
        }

        .checklist-item {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
            padding: 8px 0;
        }

        .checklist-item input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #007bff;
        }

        .checklist-item label {
            color: #6c757d;
            cursor: pointer;
            flex: 1;
        }

        .create-item {
            color: #007bff;
            text-decoration: underline;
            cursor: pointer;
            font-size: 14px;
        }

        .attachment {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 6px;
            margin-bottom: 12px;
        }

        .attachment-preview {
            width: 48px;
            height: 48px;
            background: #e9ecef;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .attachment-info {
            flex: 1;
        }

        .attachment-name {
            font-weight: 500;
            color: #495057;
            margin-bottom: 4px;
        }

        .attachment-meta {
            font-size: 12px;
            color: #6c757d;
        }

        .attachment-actions {
            display: flex;
            gap: 8px;
        }

        .attachment-actions a {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }

        .sidebar-section {
            margin-bottom: 24px;
        }

        .sidebar-title {
            font-size: 14px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 12px;
        }

        .assigned-users {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #007bff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
            font-weight: 500;
        }

        .timer-section {
            text-align: center;
            margin-bottom: 20px;
        }

        .timer-display {
            font-size: 24px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .play-btn {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #28a745;
            border: none;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .settings-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 12px;
            margin-bottom: 4px;
            background: white;
            border-radius: 4px;
            font-size: 14px;
        }

        .settings-label {
            color: #6c757d;
        }

        .settings-value {
            color: #495057;
            font-weight: 500;
        }

        .add-reminder-btn {
            width: 100%;
            padding: 10px;
            background: #e3f2fd;
            border: 1px solid #bbdefb;
            border-radius: 4px;
            color: #1976d2;
            cursor: pointer;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .tags-section {
            border-top: 1px solid #e9ecef;
            padding-top: 16px;
        }

        .edit-tags {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }

        .invoice-info {
            background: #e8f4f8;
            padding: 12px;
            border-radius: 4px;
            margin-top: 16px;
        }

        .invoice-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
            font-size: 14px;
        }

        .icon {
            width: 16px;
            height: 16px;
            fill: currentColor;
        }

        .debug-info {
            background: #e7f3ff;
            border: 1px solid #b3d4fc;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .debug-info h5 {
            color: #0066cc;
            margin-bottom: 10px;
        }

        .debug-info ul {
            margin: 0;
            padding-left: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="debug-info">
            <h5>🔧 Debug Information</h5>
            <p><strong>Common issues that prevent modals from opening:</strong></p>
            <ul>
                <li>Bootstrap JS not loaded or loaded incorrectly</li>
                <li>jQuery conflicts or missing</li>
                <li>JavaScript errors preventing event handlers</li>
                <li>Incorrect modal markup structure</li>
                <li>CSS conflicts affecting modal display</li>
            </ul>
        </div>

        <!-- Test Buttons -->
        <div class="row mb-4">
            <div class="col-12">
                <h4>Test Modal Opening Methods:</h4>
                <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#taskModal">
                    Method 1: Bootstrap data attributes
                </button>
                <button class="btn btn-success me-2" onclick="openModalJS()">
                    Method 2: JavaScript
                </button>
                <button class="btn btn-warning me-2" onclick="loadTaskModal(123)">
                    Method 3: Your original function
                </button>
                <button class="btn btn-info me-2" onclick="debugModal()">
                    Debug Modal
                </button>
            </div>
        </div>

        <!-- Sample Task Table -->
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>SL</th>
                                <th>Title</th>
                                <th>Project</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>
                                    <div class="fw-bold">Packaging design layout</div>
                                    <small class="text-muted">This is the initial draft and it must contain all the key elements...</small>
                                </td>
                                <td>
                                    <span class="badge bg-info">WordPress Landing Page</span>
                                </td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small class="text-muted">25% Complete</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-success" 
                                            data-bs-toggle="modal" data-bs-target="#taskModal"
                                            onclick="loadTaskModal(1)"
                                            title="Quick View">
                                            <i class="fas fa-expand"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>
                                    <div class="fw-bold">Website Development</div>
                                    <small class="text-muted">Complete frontend and backend development...</small>
                                </td>
                                <td>
                                    <span class="badge bg-info">E-commerce Site</span>
                                </td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small class="text-muted">60% Complete</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-success" 
                                            data-bs-toggle="modal" data-bs-target="#taskModal"
                                            onclick="loadTaskModal(2)"
                                            title="Quick View">
                                            <i class="fas fa-expand"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Modal -->
    <div class="modal fade task-modal" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-tabs">
                        <button class="modal-tab active" data-tab="task">Task</button>
                        <button class="modal-tab" data-tab="information">Information</button>
                        <button class="modal-tab" data-tab="notes">My Notes</button>
                        <button class="modal-tab" data-tab="recurring">Recurring</button>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="modal-main-content">
                        <!-- Task Tab Content -->
                        <div class="tab-content" id="task-content">
                            <h1 class="task-title" id="modal-task-title">Packaging design layout</h1>
                            <div class="project-info">
                                <strong>Project:</strong> <span id="modal-project-name" class="project-link">WordPress Landing Page</span>
                            </div>
                            <div class="project-info">
                                <strong>Milestone:</strong> Planning
                            </div>

                            <div class="section">
                                <h2 class="section-title">
                                    <svg class="icon" viewBox="0 0 24 24">
                                        <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/>
                                    </svg>
                                    Description
                                </h2>
                                
                                <div class="task-details" id="modal-task-description">
                                    This is the initial draft and it must contain all the key elements (as listed in the project brief). It should allow the client to envisage the final outcome.
                                </div>

                                <a href="#" class="create-item">Edit Description</a>
                            </div>

                            <div class="section">
                                <div class="checklist-header">
                                    <h2 class="section-title">
                                        <input type="checkbox" style="margin-right: 8px;">
                                        Checklist
                                    </h2>
                                    <span class="checklist-counter">0/4</span>
                                </div>

                                <div class="checklist-item">
                                    <input type="checkbox" id="check1">
                                    <label for="check1">Suitable for target audience</label>
                                </div>
                                <div class="checklist-item">
                                    <input type="checkbox" id="check2">
                                    <label for="check2">Maximum of 3 iterations</label>
                                </div>
                                <div class="checklist-item">
                                    <input type="checkbox" id="check3">
                                    <label for="check3">Test across multiple devices and browsers</label>
                                </div>
                                <div class="checklist-item">
                                    <input type="checkbox" id="check4">
                                    <label for="check4">Minimum resolution 1200 x 3000px</label>
                                </div>

                                <a href="#" class="create-item">Create A New Item</a>
                            </div>

                            <div class="section">
                                <h2 class="section-title">
                                    <svg class="icon" viewBox="0 0 24 24">
                                        <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                                    </svg>
                                    Attachments
                                </h2>
                                
                                <div class="attachment">
                                    <div class="attachment-preview">
                                        <svg class="icon" viewBox="0 0 24 24" style="width: 24px; height: 24px;">
                                            <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                                        </svg>
                                    </div>
                                    <div class="attachment-info">
                                        <div class="attachment-name">Steven [11 months ago]</div>
                                        <div class="attachment-meta">mockup-package-1.jpg</div>
                                    </div>
                                    <div class="attachment-actions">
                                        <a href="#">Download ↓</a>
                                        <span style="color: #e9ecef;">|</span>
                                        <a href="#">Set Cover</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Information Tab Content (Hidden by default) -->
                        <div class="tab-content" id="information-content" style="display: none;">
                            <h2>Task Information</h2>
                            <p>Additional task information will go here...</p>
                            <div class="task-details">
                                <strong>Task ID:</strong> <span id="info-task-id">123</span><br>
                                <strong>Created:</strong> 2024-01-15<br>
                                <strong>Updated:</strong> 2024-01-20<br>
                                <strong>Priority:</strong> High<br>
                                <strong>Estimated Hours:</strong> 8 hours<br>
                                <strong>Actual Hours:</strong> 6 hours<br>
                            </div>
                        </div>

                        <!-- Notes Tab Content (Hidden by default) -->
                        <div class="tab-content" id="notes-content" style="display: none;">
                            <h2>My Notes</h2>
                            <textarea class="form-control" rows="6" placeholder="Add your notes here..."></textarea>
                            <button class="btn btn-primary mt-2">Save Notes</button>
                        </div>

                        <!-- Recurring Tab Content (Hidden by default) -->
                        <div class="tab-content" id="recurring-content" style="display: none;">
                            <h2>Recurring Settings</h2>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="enableRecurring">
                                <label class="form-check-label" for="enableRecurring">
                                    Enable recurring task
                                </label>
                            </div>
                            <div class="mt-3">
                                <label class="form-label">Repeat every:</label>
                                <select class="form-select">
                                    <option>Daily</option>
                                    <option>Weekly</option>
                                    <option>Monthly</option>
                                    <option>Yearly</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-sidebar">
                        <div class="sidebar-section">
                            <div class="sidebar-title">Assigned Users</div>
                            <div class="assigned-users">
                                <div class="user-avatar">A</div>
                                <div class="user-avatar">B</div>
                            </div>
                        </div>

                        <div class="sidebar-section">
                            <div class="sidebar-title">My Timer 
                                <svg class="icon" viewBox="0 0 24 24" style="width: 14px; height: 14px; margin-left: 4px;">
                                    <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4M12.5,7V12.25L17,14.92L16.25,16.15L11,13V7H12.5Z"/>
                                </svg>
                            </div>
                            <div class="timer-display">
                                <span id="timer">00:00</span>
                                <button class="play-btn" onclick="toggleTimer()">▶</button>
                            </div>
                        </div>

                        <div class="sidebar-section">
                            <div class="sidebar-title">Settings</div>
                            <div class="settings-item">
                                <span class="settings-label">📅 Start Date:</span>
                                <span class="settings-value" id="modal-start-date">12-12-2024</span>
                            </div>
                            <div class="settings-item">
                                <span class="settings-label">📅 Due Date:</span>
                                <span class="settings-value" id="modal-end-date">12-14-2024</span>
                            </div>
                            <div class="settings-item">
                                <span class="settings-label">📊 Status:</span>
                                <span class="settings-value" id="modal-status">Awaiting Feedback</span>
                            </div>
                            <div class="settings-item">
                                <span class="settings-label">🔥 Priority:</span>
                                <span class="settings-value">Normal</span>
                            </div>
                            <div class="settings-item">
                                <span class="settings-label">👁️ Client:</span>
                                <span class="settings-value">Visible</span>
                            </div>
                        </div>

                        <button class="add-reminder-btn">
                            ⏰ Add A Reminder
                        </button>

                        <div class="sidebar-section tags-section">
                            <div class="sidebar-title">Tags</div>
                            <a href="#" class="edit-tags">Edit Tags</a>
                        </div>

                        <div class="invoice-info">
                            <div class="invoice-row">
                                <span>Time Invoiced</span>
                                <span>00:00</span>
                            </div>
                            <div class="invoice-row">
                                <span>Project</span>
                                <span style="color: #007bff;">#62</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <script>
        let timerRunning = false;
        let seconds = 0;
        let timerInterval;

        // Sample task data
        const sampleTasks = {
            1: {
                title: "Packaging design layout",
                project: "WordPress Landing Page",
                description: "This is the initial draft and it must contain all the key elements (as listed in the project brief). It should allow the client to envisage the final outcome.",
                start_date: "12-12-2024",
                end_date: "12-14-2024",
                status: "In Progress"
            },
            2: {
                title: "Website Development",
                project: "E-commerce Site",
                description: "Complete frontend and backend development with payment integration and admin panel.",
                start_date: "01-15-2024",
                end_date: "02-15-2024",
                status: "In Progress"
            }
        };

        function toggleTimer() {
            const playBtn = document.querySelector('.play-btn');
            const timerDisplay = document.getElementById('timer');
            
            if (timerRunning) {
                clearInterval(timerInterval);
                playBtn.innerHTML = '▶';
                timerRunning = false;
            } else {
                timerInterval = setInterval(() => {
                    seconds++;
                    const mins = Math.floor(seconds / 60);
                    const secs = seconds % 60;
                    timerDisplay.textContent = `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
                }, 1000);
                playBtn.innerHTML = '⏸';
                timerRunning = true;
            }
        }

        // Fixed loadTaskModal function with actual data loading
        function loadTaskModal(taskId) {
            console.log('Loading task modal for ID:', taskId);
            
            // Get task data
            const task = sampleTasks[taskId];
            if (task) {
                // Update modal content
                document.getElementById('modal-task-title').textContent = task.title;
                document.getElementById('modal-project-name').textContent = task.project;
                document.getElementById('modal-task-description').textContent = task.description;
                document.getElementById('modal-start-date').textContent = task.start_date;
                document.getElementById('modal-end-date').textContent = task.end_date;
                document.getElementById('modal-status').textContent = task.status;
                document.getElementById('info-task-id').textContent = taskId;
            }

            // Force show modal using Bootstrap instance
            try {
                const modalElement = document.getElementById('taskModal');
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
            } catch (error) {
                console.error('Error opening modal:', error);
                alert('Error opening modal. Check console for details.');
            }
        }

        // Alternative method to open modal
        function openModalJS() {
            const modalElement = document.getElementById('taskModal');
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        }

        // Debug function
        function debugModal() {
            const modalElement = document.getElementById('taskModal');
            console.log('Modal element:', modalElement);
            console.log('Bootstrap available:', typeof bootstrap !== 'undefined');
            console.log('jQuery available:', typeof $ !== 'undefined');
            
            if (!modalElement) {
                alert('Modal element not found!');
                return;
            }
            
            try {
                const modal = new bootstrap.Modal(modalElement);
                console.log('Modal instance created:', modal);
                modal.show();
                alert('Modal should be opening now. Check if it appears.');
            } catch (error) {
                console.error('Error:', error);
                alert('Error: ' + error.message);
            }
        }

        // Tab functionality
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing...');
            
            const tabs = document.querySelectorAll('.modal-tab');
            const contents = document.querySelectorAll('.tab-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    console.log('Tab clicked:', this.dataset.tab);
                    
                    // Remove active class from all tabs
                    tabs.forEach(t => t.classList.remove('active'));
                    // Add active class to clicked tab
                    this.classList.add('active');

                    // Hide all content
                    contents.forEach(content => content.style.display = 'none');
                    
                    // Show corresponding content
                    const targetContent = document.getElementById(this.dataset.tab + '-content');
                    if (targetContent) {
                        targetContent.style.display = 'block';
                    }
                });
            });

            // Checklist functionality
            const checkboxes = document.querySelectorAll('.checklist-item input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const checkedCount = document.querySelectorAll('.checklist-item input[type="checkbox"]:checked').length;
                    const totalCount = checkboxes.length;
                    document.querySelector('.checklist-counter').textContent = `${checkedCount}/${totalCount}`;
                });
            });

            // Test Bootstrap availability
            if (typeof bootstrap === 'undefined') {
                console.error('Bootstrap JS is not loaded!');
                document.body.insertAdjacentHTML('afterbegin', 
                    '<div class="alert alert-danger">⚠️ Bootstrap JS is not loaded! Modal will not work.</div>'
                );
            } else {
                console.log('Bootstrap JS loaded successfully');
            }
        });

        // Modal event listeners for debugging
        document.addEventListener('DOMContentLoaded', function()