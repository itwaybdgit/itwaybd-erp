@extends('admin.master')
@section('title')
    Hrm - {{ $title }}
@endsection

<style>
    .bootstrap-switch-large {
        width: 200px;
    }
</style>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }


    .container {
        max-width: 1200px;
        margin: 0 auto;
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .header {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: white;
        padding: 30px;
        text-align: center;
    }

    .header h1 {
        font-size: 2.5em;
        margin-bottom: 10px;
        font-weight: 300;
    }

    .controls {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    .control-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    select,
    button {
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    select {
        background: white;
        color: #333;
        border: 2px solid transparent;
    }

    button {
        background: #10b981;
        color: white;
        font-weight: 600;
    }

    button:hover {
        background: #059669;
        transform: translateY(-2px);
    }

    .calendar-container {
        padding: 30px;
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .month-year {
        font-size: 2em;
        font-weight: 600;
        color: #1f2937;
    }

    .nav-btn {
        background: #6366f1;
        color: white;
        border: none;
        padding: 15px 20px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 18px;
        transition: all 0.3s ease;
    }

    .nav-btn:hover {
        background: #4f46e5;
        transform: scale(1.1);
    }

    .calendar {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 2px;
        background: #f3f4f6;
        border-radius: 12px;
        padding: 20px;
    }

    .calendar-day {
        aspect-ratio: 1;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        padding: 8px;
        background: white;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        min-height: 80px;
    }

    .calendar-day:hover {
        background: #f0f9ff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .calendar-day.header {
        background: #4f46e5;
        color: white;
        font-weight: 600;
        cursor: default;
        aspect-ratio: auto;
        min-height: 50px;
    }

    .calendar-day.header:hover {
        transform: none;
        box-shadow: none;
    }

    .calendar-day.other-month {
        color: #9ca3af;
        background: #f9fafb;
    }

    .calendar-day.today {
        background: #fef3c7;
        border: 2px solid #f59e0b;
    }

    .calendar-day.has-holiday {
        background: #fef2f2;
        border-left: 4px solid #ef4444;
    }

    .day-number {
        font-weight: 600;
        font-size: 16px;
        margin-bottom: 4px;
    }

    .holiday-indicator {
        font-size: 10px;
        color: #ef4444;
        text-align: center;
        word-wrap: break-word;
        line-height: 1.2;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
    }

    .modal-content {
        background: white;
        margin: 5% auto;
        padding: 0;
        border-radius: 16px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        transform: scale(0.9);
        transition: transform 0.3s ease;
    }

    .modal.show .modal-content {
        transform: scale(1);
    }

    .modal-header {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: white;
        padding: 20px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 16px 16px 0 0;
    }

    .close {
        color: white;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        line-height: 1;
    }

    .close:hover {
        opacity: 0.7;
    }

    .modal-body {
        padding: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #374151;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 16px;
        transition: border-color 0.3s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: #4f46e5;
    }

    .form-group textarea {
        resize: vertical;
        height: 80px;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 30px;
    }

    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .btn-primary {
        background: #4f46e5;
        color: white;
    }

    .btn-primary:hover {
        background: #4338ca;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
    }

    .holiday-list {
        max-height: 200px;
        overflow-y: auto;
        margin-top: 15px;
    }

    .holiday-item {
        padding: 10px;
        background: #f8fafc;
        border-radius: 6px;
        margin-bottom: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .holiday-item h4 {
        color: #1f2937;
        margin-bottom: 2px;
    }

    .holiday-item p {
        color: #6b7280;
        font-size: 14px;
    }

    .holiday-actions {
        display: flex;
        gap: 5px;
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 12px;
    }

    .loading {
        text-align: center;
        padding: 20px;
        color: #6b7280;
    }

    @media (max-width: 768px) {
        .calendar {
            padding: 10px;
        }

        .calendar-day {
            min-height: 60px;
            font-size: 12px;
        }

        .controls {
            flex-direction: column;
            gap: 10px;
        }

        .modal-content {
            margin: 10% auto;
            width: 95%;
        }
    }
</style>

@section('content')
    <div class="container">
        <div class="header">
            <h1>Holiday Management System</h1>
            <div class="controls">
                <div class="control-group">
                    <label for="yearSelect" style="color: white;">Year:</label>
                    <select id="yearSelect"></select>
                </div>
                <div class="control-group">
                    <label for="monthSelect" style="color: white;">Month:</label>
                    <select id="monthSelect">
                        <option value="">All Months</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
                <button onclick="loadHolidays()">Load Holidays</button>
                <button class="btn btn-primary" onclick="addHolidayForDateMultiple()">Add Holiday</button>
            </div>
        </div>

        <div class="calendar-container">
            <div class="calendar-header">
                <button class="nav-btn" onclick="previousMonth()">‹</button>
                <div class="month-year" id="monthYearDisplay"></div>
                <button class="nav-btn" onclick="nextMonth()">›</button>
            </div>
            <div class="calendar" id="calendar"></div>
        </div>
    </div>

    <!-- Holiday Modal -->
    <div id="holidayModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Add Holiday</h2>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <div class="modal-body">
                <form id="holidayForm">
                    <div class="form-group">
                        <label for="holidayTitle">Title *</label>
                        <input type="text" id="holidayTitle" name="title" required>
                    </div>

                    <div class="form-group">
                        <label for="holidayDate">Date *</label>
                        <input type="date" id="holidayDate" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="holidayType">Type *</label>
                        <select id="holidayType" name="type" required>
                            <option value="public">Public Holiday</option>
                            <option value="religious">Religious Holiday</option>
                            <option value="national">National Holiday</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Holiday</button>
                        <button type="button" class="btn btn-danger" id="deleteBtn" onclick="deleteHoliday()"
                            style="display: none;">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="holidayModalMultiple" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Add Holiday</h2>
                <span class="close" onclick="closeModalMultiple()">&times;</span>
            </div>
            <div class="modal-body">
                <form id="holidayFormMultiple">
                    <div class="form-group">
                        <label for="holidayTitle">Title *</label>
                        <input type="text" id="holidayTitleMul" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="year">Select Year *</label>
                        <input type="number" id="holidayyear" name="year" class="form-control" required
                            value="{{ date('Y') }}">
                    </div>

                    <div class="form-group mt-3">
                        <label for="day">Select Weekend Day *</label>
                        <select name="day[]" class="form-control select2" id="holidaydays" multiple="multiple"
                            style="width: 100%;" required>
                            <option value="sunday">Sunday</option>
                            <option value="monday">Monday</option>
                            <option value="tuesday">Tuesday</option>
                            <option value="wednesday">Wednesday</option>
                            <option value="thursday">Thursday</option>
                            <option value="friday">Friday</option>
                            <option value="saturday">Saturday</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="holidayType">Type *</label>
                        <select id="holidayTypeMultiple" name="type" required>
                            <option value="weekly">Weekly Holiday</option>

                        </select>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="closeModalMultiple()">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Holiday</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Day Details Modal -->
    <div id="dayModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="dayModalTitle">Holidays for Date</h2>
                <span class="close" onclick="closeDayModal()">&times;</span>
            </div>
            <div class="modal-body">
                <button class="btn btn-primary" onclick="addHolidayForDate()">Add Holiday</button>
                <div id="holidayList" class="holiday-list"></div>
            </div>
        </div>
    </div>

    <script>
        const BASE_URL = "{{ url('/') }}";
        let currentDate = new Date();
        let currentYear = currentDate.getFullYear();
        let currentMonth = currentDate.getMonth();
        let holidays = [];
        let editingHolidayId = null;
        let selectedDate = null;

        const monthNames = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        const dayNames = ['Fri', 'Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu'];

        // Initialize the application
        function init() {
            populateYearSelect();
            loadHolidays();
            generateCalendar();
        }

        // Populate year selector with range
        function populateYearSelect() {
            const yearSelect = document.getElementById('yearSelect');
            const currentYear = new Date().getFullYear();

            for (let year = currentYear - 5; year <= currentYear + 5; year++) {
                const option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                if (year === currentYear) option.selected = true;
                yearSelect.appendChild(option);
            }
        }

        function generateCalendar() {
            const calendar = document.getElementById('calendar');
            const monthYearDisplay = document.getElementById('monthYearDisplay');

            monthYearDisplay.textContent = `${monthNames[currentMonth]} ${currentYear}`;
            calendar.innerHTML = '';

            // Add day headers (Fri to Thu)
            dayNames.forEach(day => {
                const dayHeader = document.createElement('div');
                dayHeader.className = 'calendar-day header';
                dayHeader.textContent = day;
                calendar.appendChild(dayHeader);
            });

            const nativeFirstDay = new Date(currentYear, currentMonth, 1).getDay();
            const firstDay = (nativeFirstDay + 2) % 7; // Friday = 0
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
            const daysInPrevMonth = new Date(currentYear, currentMonth, 0).getDate();

            // Previous month's trailing days
            for (let i = firstDay - 1; i >= 0; i--) {
                const dayElement = createDayElement(daysInPrevMonth - i, true);
                calendar.appendChild(dayElement);
            }

            // Current month's days
            for (let day = 1; day <= daysInMonth; day++) {
                const dayElement = createDayElement(day, false);
                calendar.appendChild(dayElement);
            }

            // Next month's leading days to fill 42 cells (6 rows)
            const totalCells = 42;
            const currentCells = firstDay + daysInMonth;
            const remainingCells = totalCells - currentCells;

            for (let day = 1; day <= remainingCells; day++) {
                const dayElement = createDayElement(day, true);
                calendar.appendChild(dayElement);
            }
        }


        // Create individual day element
        function createDayElement(day, isOtherMonth) {
            const dayElement = document.createElement('div');
            dayElement.className = 'calendar-day';

            if (isOtherMonth) {
                dayElement.classList.add('other-month');
            }

            const dayNumber = document.createElement('div');
            dayNumber.className = 'day-number';
            dayNumber.textContent = day;
            dayElement.appendChild(dayNumber);

            // Check if this is today
            const today = new Date();
            const cellDate = new Date(currentYear, currentMonth, day);
            if (!isOtherMonth &&
                cellDate.getDate() === today.getDate() &&
                cellDate.getMonth() === today.getMonth() &&
                cellDate.getFullYear() === today.getFullYear()) {
                dayElement.classList.add('today');
            }

            // Add holidays for this day
            if (!isOtherMonth) {
                const dateStr =
                    `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                const dayHolidays = holidays.filter(h => h.date === dateStr);

                if (dayHolidays.length > 0) {
                    dayElement.classList.add('has-holiday');
                    dayHolidays.forEach(holiday => {
                        const indicator = document.createElement('div');
                        indicator.className = 'holiday-indicator';
                        indicator.textContent = holiday.title;
                        dayElement.appendChild(indicator);
                    });
                }

                dayElement.addEventListener('click', () => showDayDetails(dateStr));
            }

            return dayElement;
        }

        // Navigation functions
        function previousMonth() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            generateCalendar();
        }

        function nextMonth() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            generateCalendar();
        }

        // API functions
        async function loadHolidays() {
            try {
                const yearSelect = document.getElementById('yearSelect');
                const monthSelect = document.getElementById('monthSelect');

                let url = BASE_URL + '/admin/hrm-holidays?year=' + (yearSelect.value || currentYear);
                if (monthSelect.value) {
                    url += '&month=' + monthSelect.value;
                }

                const response = await fetch(url);
                const data = await response.json();

                if (data.success) {
                    holidays = data.data;
                    generateCalendar();
                }
            } catch (error) {
                console.error('Error loading holidays:', error);
                alert('Error loading holidays. Please try again.');
            }
        }

        async function saveHoliday(formData) {
            try {
                const url = editingHolidayId ? BASE_URL + `/admin/hrm-holiday-update/${editingHolidayId}` : BASE_URL +
                    '/admin/hrm-holiday-store';
                const method = editingHolidayId ? 'POST' : 'POST';

                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (data.success) {
                    closeModal();
                    loadHolidays();
                    alert(data.message);
                } else {
                    alert('Error saving holiday: ' + (data.message || 'Unknown error'));
                }
            } catch (error) {
                console.error('Error saving holiday:', error);
                alert('Error saving holiday. Please try again.');
            }
        }
        async function saveHolidayMultiple(formData) {
            try {
                const url = editingHolidayId ? BASE_URL + `/admin/hrm-holiday-update/${editingHolidayId}` : BASE_URL +
                    '/admin/hrm-holiday-store';
                const method = editingHolidayId ? 'POST' : 'POST';

                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (data.success) {
                    closeModalMultiple();
                    loadHolidays();
                    alert(data.message);
                } else {
                    alert('Error saving holiday: ' + (data.message || 'Unknown error'));
                }
            } catch (error) {
                console.error('Error saving holiday:', error);
                alert('Error saving holiday. Please try again.');
            }
        }
        async function deleteHoliday() {
            if (!editingHolidayId) return;

            if (confirm('Are you sure you want to delete this holiday?')) {
                try {
                    const response = await fetch(BASE_URL + `/admin/hrm-holiday-delete/${editingHolidayId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        closeModal();
                        loadHolidays();
                        alert(data.message);
                    } else {
                        alert('Error deleting holiday: ' + (data.message || 'Unknown error'));
                    }
                } catch (error) {
                    console.error('Error deleting holiday:', error);
                    alert('Error deleting holiday. Please try again.');
                }
            }
        }

        // Modal functions
        function showDayDetails(date) {
            selectedDate = date;
            const dayHolidays = holidays.filter(h => h.date === date);
            const modal = document.getElementById('dayModal');
            const title = document.getElementById('dayModalTitle');
            const holidayList = document.getElementById('holidayList');

            title.textContent = `Holidays for ${new Date(date + 'T00:00:00').toLocaleDateString()}`;

            if (dayHolidays.length === 0) {
                holidayList.innerHTML = '<p>No holidays on this date.</p>';
            } else {
                holidayList.innerHTML = dayHolidays.map(holiday => `
                    <div class="holiday-item">
                        <div>
                            <h4>${holiday.title}</h4>
                            <p>${holiday.type}</p>
                        </div>
                        <div class="holiday-actions">
                            <button class="btn btn-primary btn-sm" onclick="editHoliday(${holiday.id})">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="confirmDeleteHoliday(${holiday.id})">Delete</button>
                        </div>
                    </div>
                `).join('');
            }

            modal.style.display = 'block';
            setTimeout(() => modal.classList.add('show'), 10);
        }

        function addHolidayForDate() {
            closeDayModal();
            openModal(false, selectedDate);
        }

        function addHolidayForDateMultiple() {
            closeDayModal();
            openModalMultiple(false, selectedDate);
        }

        function openModal(isEdit = false, date = null) {
            const modal = document.getElementById('holidayModal');
            const title = document.getElementById('modalTitle');
            const deleteBtn = document.getElementById('deleteBtn');
            const form = document.getElementById('holidayForm');

            title.textContent = isEdit ? 'Edit Holiday' : 'Add Holiday';
            deleteBtn.style.display = isEdit ? 'inline-block' : 'none';

            if (date) {
                document.getElementById('holidayDate').value = date;
            }

            if (!isEdit) {
                form.reset();
                editingHolidayId = null;
            }

            modal.style.display = 'block';
            setTimeout(() => modal.classList.add('show'), 10);
        }

        function openModalMultiple(isEdit = false, date = null) {
            const modal = document.getElementById('holidayModalMultiple');
            const title = document.getElementById('modalTitle');
            const deleteBtn = document.getElementById('deleteBtn');
            const form = document.getElementById('holidayForm');

            title.textContent = isEdit ? 'Edit Holiday' : 'Add Holiday';
            deleteBtn.style.display = isEdit ? 'inline-block' : 'none';

            if (date) {
                document.getElementById('holidayDate').value = date;
            }

            if (!isEdit) {
                form.reset();
                editingHolidayId = null;
            }

            modal.style.display = 'block';
            setTimeout(() => modal.classList.add('show'), 10);
        }

        function editHoliday(holidayId) {
            const holiday = holidays.find(h => h.id === holidayId);
            if (!holiday) return;

            editingHolidayId = holidayId;

            document.getElementById('holidayTitle').value = holiday.title;

            document.getElementById('holidayDate').value = holiday.date;
            document.getElementById('holidayType').value = holiday.type;

            closeDayModal();
            openModal(true);
        }

        function confirmDeleteHoliday(holidayId) {
            editingHolidayId = holidayId;
            deleteHoliday();
        }

        function closeModal() {
            const modal = document.getElementById('holidayModal');
            modal.classList.remove('show');
            setTimeout(() => {
                modal.style.display = 'none';
                document.getElementById('holidayForm').reset();
                editingHolidayId = null;
            }, 300);
        }

        function closeModalMultiple() {
            const modal = document.getElementById('holidayModalMultiple');
            modal.classList.remove('show');
            setTimeout(() => {
                modal.style.display = 'none';
                document.getElementById('holidayFormMultiple').reset();
                editingHolidayId = null;
            }, 300);
        }

        function closeDayModal() {
            const modal = document.getElementById('dayModal');
            modal.classList.remove('show');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }

        // Form submission
        document.getElementById('holidayForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true; // Prevent double click

            const formData = {
                title: document.getElementById('holidayTitle').value,
                date: document.getElementById('holidayDate').value,
                type: document.getElementById('holidayType').value
            };

            saveHoliday(formData).finally(() => {
                submitBtn.disabled = false;
            });
        });

        document.getElementById('holidayFormMultiple').addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;

            const formData = {
                title: document.getElementById('holidayTitleMul').value,
                year: document.getElementById('holidayyear').value,
                day: $('#holidaydays').val(), // multiple values
                type: document.getElementById('holidayTypeMultiple').value
            };

            saveHolidayMultiple(formData).finally(() => {
                submitBtn.disabled = false;
            });
        });

        // Close modals when clicking outside
        window.addEventListener('click', function(event) {
            const holidayModal = document.getElementById('holidayModal');
            const dayModal = document.getElementById('dayModal');

            if (event.target === holidayModal) {
                closeModal();
            }
            if (event.target === dayModal) {
                closeDayModal();
            }
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
                closeDayModal();
            }
        });

        // Update calendar when year/month changes
        document.getElementById('yearSelect').addEventListener('change', function() {
            currentYear = parseInt(this.value);
            generateCalendar();
        });

        document.getElementById('monthSelect').addEventListener('change', function() {
            if (this.value) {
                currentMonth = parseInt(this.value) - 1;
                currentYear = parseInt(document.getElementById('yearSelect').value);
                generateCalendar();
            }
        });

        // Initialize the app when page loads
        document.addEventListener('DOMContentLoaded', init);
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Select employee(s)",
                allowClear: true
            });
        });
    </script>
@endsection
