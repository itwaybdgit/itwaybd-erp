@extends('admin.master')
@section('title')
    Hrm - {{ $title }}
@endsection

@section('styles')
    <style>
        .bootstrap-switch-large {
            width: 200px;
        }

        .status-badge {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 10px;
        }


        .status-toggle {
            display: flex;
            gap: 5px;
            margin-bottom: 10px;
        }

        .toggle-btn {
            padding: 6px 12px;
            border: 2px solid;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .toggle-btn.present {
            border-color: #20c997;
            color: #20c997;
            background-color: transparent;
        }

        .toggle-btn.present.active {
            background-color: #20c997;
            color: white;
        }

        .toggle-btn.absent {
            border-color: #dc3545;
            color: #dc3545;
            background-color: transparent;
        }

        .toggle-btn.absent.active {
            background-color: #dc3545;
            color: white;
        }

        .not-marked {
            background-color: #dc3545;
            color: white;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 12px;
        }

        .marked {
            background-color: #28a745;
            color: white;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 12px;
        }

        .time-input {
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 8px 12px;
            font-size: 14px;
            width: 100px;
        }

        .save-btn {
            background-color: #0d6efd;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .save-btn:hover {
            background-color: #0b5ed7;
            transform: scale(1.05);
        }

        .table-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .table th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
            padding: 12px;
        }

        .table td {
            padding: 12px;
            vertical-align: middle;
            border-bottom: 1px solid #dee2e6;
        }

        .employee-row {
            transition: background-color 0.2s;
        }

        .employee-row:hover {
            background-color: #f8f9fa;
        }

        .form-control-sm {
            font-size: 14px;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .time-container {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .time-row {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .time-label {
            font-size: 12px;
            color: #6c757d;
            min-width: 60px;
        }

        .leave-section {
            opacity: 0;
            height: 0;
            overflow: hidden;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .leave-section.show {
            opacity: 1;
            height: auto;
            pointer-events: all;
        }

        .status-indicator {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .overtime-display {
            font-weight: bold;
            color: #6c757d;
        }

        /* Toast notifications */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1055;
        }

        /* Loading spinner */
        .spinner-border {
            display: none;
            width: 1.5rem;
            height: 1.5rem;
            margin-left: 5px;
            vertical-align: middle;
        }

        .save-btn.saving .spinner-border {
            display: inline-block;
        }

        .table-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
            /* Add this */
            padding-bottom: 60px;
            /* Make space for the save button */
        }

        .table-wrapper {
            position: relative;
            overflow: auto;
            max-height: 400px;
            /* Set max height instead of fixed height */
            width: 100%;
        }

        /* Fix the save button position */
        .save-all-container {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            padding: 10px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            z-index: 10;
        }

        .marked {
            color: green;
            font-weight: bold;
            color: #fff;
        }
    </style>
@endsection



@section('content')
    <div class="container-fluid py-4">

        <div class="table-container">
            <div style=" display: flex; padding: 10px">
                <div class="col-md-4">

                </div>
                <div class="col-md-4">
                    <input type="date" id="From" value="{{ request('from', date('Y-m-d')) }}" class="form-control"
                        name="from">
                </div>
                <div class="col-md-4">

                </div>
            </div>


            <div id="attendanceTableContainer">
                @include('backend.pages.hrm.attendance.partial_table', [
                    'attendances' => $attendances,
                    'dayes' => $dayes,
                ])
            </div>




        </div>
    </div>

    <!-- Toast Notification Container -->
    <div id="toastContainer" class="toast-container"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#From').on('change', function() {
            let selectedDate = $(this).val();

            $.ajax({
                url: '{{ route('hrm.attendance.mark') }}',
                type: 'POST',
                data: {
                    from: selectedDate,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#attendanceTableContainer').html(response);
                },
                error: function(xhr) {
                    console.error("Error fetching attendance:", xhr.responseText);
                }
            });
        });
    </script>


    <script>
        // CSRF Token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function handleClockInChange(employeeId) {
            const row = document.querySelector(`tr[data-employee-id="${employeeId}"]`);
            const clockInInput = row.querySelector('.clock-in');
            const presentBtn = row.querySelector('.toggle-btn.present');
            const absentBtn = row.querySelector('.toggle-btn.absent');
            const leaveSection = row.querySelector('.leave-section');
            const statusBadge = row.querySelector('.status-badge');

            if (clockInInput.value) {
                // If clock-in has value, set to present
                presentBtn.classList.add('active');
                absentBtn.classList.remove('active');
                statusBadge.className = 'status-badge status-present';
                leaveSection.classList.remove('show');

                // Update status in database
                const attendanceId = row.dataset.attendanceId;
                updateAttendanceStatus(employeeId, attendanceId, 'present');
            } else {
                // If clock-in is empty, set to absent
                presentBtn.classList.remove('active');
                absentBtn.classList.add('active');
                statusBadge.className = 'status-badge status-absent';
                leaveSection.classList.add('show');

                // Update status in database
                const attendanceId = row.dataset.attendanceId;
                updateAttendanceStatus(employeeId, attendanceId, 'absent');
            }

            // Recalculate overtime
            calculateOvertime(row);
        }

        function toggleStatus(event, employeeId, status) {
            event.preventDefault();
            event.stopPropagation();

            const row = document.querySelector(`tr[data-employee-id="${employeeId}"]`);
            const attendanceId = row.dataset.attendanceId;
            const statusBadge = row.querySelector('.status-badge');
            const presentBtn = row.querySelector('.toggle-btn.present');
            const absentBtn = row.querySelector('.toggle-btn.absent');
            const leaveSection = row.querySelector('.leave-section');
            const clockInInput = row.querySelector('.clock-in');
            const clockOutInput = row.querySelector('.clock-out');
            const attendanceSpan = row.querySelector('.marked, .not-marked');

            presentBtn.classList.remove('active');
            absentBtn.classList.remove('active');

            if (status === 'present') {
                presentBtn.classList.add('active');
                statusBadge.className = 'status-badge status-present';
                if (leaveSection) leaveSection.classList.remove('show');
                if (attendanceSpan) {
                    attendanceSpan.textContent = 'Not Marked';
                    attendanceSpan.className = 'not-marked';
                }

                // Enable inputs
                if (clockInInput) clockInInput.disabled = false;
                if (clockOutInput) clockOutInput.disabled = false;

                // Set current time if empty
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                if (clockInInput && !clockInInput.value) {
                    clockInInput.value = `${hours}:${minutes}`;
                }
                if (clockOutInput && !clockOutInput.value) {
                    clockOutInput.value = `${hours}:${minutes}`;
                }

            } else {
                absentBtn.classList.add('active');
                statusBadge.className = 'status-badge status-absent';
                if (leaveSection) leaveSection.classList.add('show');
                if (attendanceSpan) {
                    attendanceSpan.textContent = 'Not Marked';
                    attendanceSpan.className = 'not-marked';
                }

                // Disable Clock In, Clock Out, and Late checkbox
                if (clockInInput) clockInInput.disabled = true;
                if (clockOutInput) clockOutInput.disabled = true;

                const lateCheckbox = row.querySelector('.late-arrival');
                if (lateCheckbox) lateCheckbox.disabled = true;
            }

            updateAttendanceStatus(employeeId, attendanceId, status);
            calculateOvertime(row);
        }

        // ... (keep all other existing functions like updateAttendanceStatus, saveAttendance, etc.) ...

        document.addEventListener('DOMContentLoaded', function() {
            // Prevent form submission on Enter key
            document.querySelector('form').addEventListener('keypress', function(e) {
                if (e.keyCode === 13) {
                    e.preventDefault();
                    return false;
                }
            });
        });
    </script>

    <script>
        const BASE_URL = "{{ url('/') }}";

        function ajaxUpdateAttendance() {
            let attendanceData = [];

            document.querySelectorAll(".employee-row").forEach(row => {
                const attendanceId = row.getAttribute('data-attendance-id');
                const employeeId = row.getAttribute('data-employee-id');
                const clockIn = row.querySelector('.clock-in')?.value || null;
                const clockOut = row.querySelector('.clock-out')?.value || null;
                const isLate = row.querySelector('.late-arrival')?.checked ? 'yes' : 'no';
                const ot = row.querySelector('input[name="ot"]')?.value || null;

                const isPresent = row.querySelector('.toggle-btn.present')?.classList.contains('active') ? 'yes' :
                    'no';
                const isMarked = row.querySelector('span.marked') ? 'yes' : 'no';

                attendanceData.push({
                    attendance_id: attendanceId,
                    employee_id: employeeId,
                    sign_in: clockIn,
                    sign_out: clockOut,
                    lateStatus: isLate,
                    ot: ot,
                    attendanceStatus: isPresent,
                    markStatus: isMarked
                });
            });

            fetch("{{ route('attendance.ajaxUpdate') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        attendances: attendanceData
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Attendance updated successfully!');
                        location.reload(); // Optional
                    } else {
                        alert('Update failed.');
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert('An error occurred.');
                });
        }


        function saveAttendance(employeeId) {
            const row = document.querySelector(`.employee-row[data-employee-id="${employeeId}"]`);
            const attendanceId = row.getAttribute('data-attendance-id');

            const clockIn = row.querySelector('.clock-in').value;
            const ot = row.querySelector('.ot').value;
            const clockOut = row.querySelector('.clock-out').value;
            const isLate = row.querySelector('.late-arrival').checked;
            const status = row.querySelector('.toggle-btn.present').classList.contains('active') ? 'present' : 'absent';

            const spinner = row.querySelector('.spinner-border');
            spinner.style.display = 'inline-block';

            fetch(`${BASE_URL}/admin/attendance/mark/update/${attendanceId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        sign_in: clockIn,
                        sign_out: clockOut,
                        lateStatus: isLate,
                        markStatus: true,
                        attendanceStatus: status,
                        ot: ot
                    })
                })
                .then(response => response.json())
                .then(data => {
                    spinner.style.display = 'none';
                    if (data.success) {
                        // Format the overtime from server response
                        const overtimeMinutes = data.overtime || 0;
                        const overtimeHours = Math.floor(overtimeMinutes / 60);
                        const overtimeMins = overtimeMinutes % 60;
                        const overtimeDisplay = overtimeHours > 0 || overtimeMins > 0 ?
                            `${overtimeHours} : ${overtimeMins.toString().padStart(2, '0')}` :
                            '';

                        // Update the overtime field
                        const overtimeField = row.querySelector('.overtime-display input');
                        if (overtimeField) {
                            overtimeField.value = overtimeDisplay;
                        }

                        alert('Attendance updated successfully!');
                    } else {
                        alert('Update failed.');
                    }
                })
                .catch(error => {
                    spinner.style.display = 'none';
                    alert('Error occurred while updating.');
                    console.error(error);
                });
        }

        function initializeSelect2() {
            $('.select2').select2({
                width: '100%',
                placeholder: "Select employee",
                allowClear: true
            });
        }

        $(document).ready(function() {
            initializeSelect2();

            // Event delegation for select change
            $(document).on('change', '#employeId', function() {
                loadAttendanceData();
            });
        });

        function loadAttendanceData() {
            const employeeId = $('#employeId').val();
            const fromDate = $('input[name="from"]').val() || '';

            // Show loading state
            const container = $("#attendanceTableContainer");
            container.html('<div class="text-center py-4"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');

            // Destroy Select2 before AJAX to prevent memory leaks
            $('.select2').select2('destroy');

            $.ajax({
                url: "{{ route('hrm.attendance.mark') }}",
                type: "POST",
                data: {
                    employee_id: employeeId,
                    from: fromDate,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    container.html(response);
                    initializeSelect2(); // Reinitialize after content load
                },
                error: function(xhr) {
                    console.error("Error:", xhr.responseText);
                    container.html('<div class="alert alert-danger">Error loading data</div>');
                    initializeSelect2(); // Reinitialize even on error
                }
            });
        }
    </script>

    <script>
        // Initialize Select2 on page load and after every AJAX complete
    </script>
@endsection
