@extends('admin.master')

@section('title')
    Employee - {{ $title }}
@endsection


<style>
    .btn-custom {
        padding: 10px 13px;
        border: none;
        border-radius: 5px 5px 0 0;
        background: green;
        color: white
    }

    .attendance-forms {
        display: none;
    }

    .employee-selection {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
</style>

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Attendence</h3>
                    <div class="card-tools">

                        <a class="btn btn-default" href="{{ route('hrm.attendance.create') }}"><i class="fa fa-plus"></i>
                            Add New</a>


                        <span id="buttons"></span>
                        <a class="btn btn-tool btn-default" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </a>
                        <a class="btn btn-tool btn-default" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- Employee Selection Section -->
                    <div class="employee-selection">
                        <div class="form-group row">
                            <label for="employee_select" class="col-sm-3 col-form-label"><strong>Select
                                    Employee:</strong></label>
                            <div class="col-md-6">
                                <select name="employee_select" class="form-control select2" id="employee_select">
                                    <option value="">-- Select Employee --</option>
                                    <option value="all" data-name="All" data-id-card="All">All</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}" data-name="{{ $employee->name }}"
                                            data-id-card="{{ $employee->id_card }}">
                                            {{ $employee->name }} ({{ $employee->id_card }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="button" id="load_employee" class="btn btn-primary" disabled>
                                    <i class="fa fa-check"></i> Load Employee
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Forms Section (Initially Hidden) -->
                    <div class="attendance-forms" id="attendance_forms">
                        <div class="selected-employee-info mb-3">
                            <div class="alert alert-info">
                                <strong>Selected Employee:</strong> <span id="selected_employee_name"></span>
                                <span id="selected_employee_id" style="display: none;"></span>
                                <span id="selected_employee_id_display"></span>
                                <button type="button" class="btn btn-sm btn-secondary float-right" id="change_employee">
                                    Change Employee
                                </button>
                            </div>
                        </div>

                        <button class="check_in btn-custom" type="button">
                            Check In
                        </button>
                        <button class="check_out btn-custom" type="button">
                            Check Out
                        </button>
                        <button class="absent btn-custom" type="button">
                            Absent
                        </button>

                        <div class="collapse active show" id="check_in">
                            <div class="card-header">
                                <h4 class="card-title">Check In</h4>
                            </div>
                            <div class="card card-body">
                                <form class="needs-validation" method="POST" action="{{ route('hrm.attendance.sign_in') }}"
                                    novalidate>
                                    @csrf
                                    <input type="hidden" name="emplyee_id" id="checkin_employee_id">

                                    <div class="form-group row">
                                        <label for="intime" class="col-sm-3 col-form-label">Employee Name*</label>
                                        <div class="col-md-4 mb-1">
                                            <span id="checkin_employee_name" class="form-control-plaintext"></span>
                                            @error('emplyee_id')
                                                <span class=" error text-red text-bold">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="intime" class="col-sm-3 col-form-label">Date *</label>
                                        <div class="col-md-4 mb-1">
                                            <input type="date" id="current-date" class="form-control" name="date">
                                            @error('date')
                                                <span class="error text-red text-bold">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="Emplyee">Punch Time* <span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-4 mb-1">
                                            <input type="time" id="current-time" class="form-control" name="sign_in">
                                            @error('sign_in')
                                                <span class="error text-red text-bold">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Location</label>
                                        <div class="col-md-4 mb-1">
                                            <div id="map-checkin" style="height: 200px; width: 100%;"></div>
                                            <input type="hidden" id="latitude" name="latitude">
                                            <input type="hidden" id="longitude" name="longitude">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <button class="btn btn-info" type="submit"><i class="fa fa-save"></i>
                                            &nbsp;Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="collapse" id="check_out">
                            <div class="card-header">
                                <h4 class="card-title">Check Out</h4>
                            </div>
                            <div class="card card-body">
                                <form class="needs-validation" method="POST"
                                    action="{{ route('hrm.attendance.sign_out') }}" novalidate>
                                    @csrf
                                    <input type="hidden" name="emplyee_id" id="checkout_employee_id">

                                    <div class="form-group row">
                                        <label for="intime" class="col-sm-3 col-form-label">Employee Name*</label>
                                        <div class="col-md-4 mb-1">
                                            <span id="checkout_employee_name" class="form-control-plaintext"></span>
                                            @error('emplyee_id')
                                                <span class=" error text-red text-bold">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="intime" class="col-sm-3 col-form-label">Date *</label>
                                        <div class="col-md-4 mb-1">
                                            <input type="date" id="current-date2" class="form-control"
                                                name="date">
                                            @error('date')
                                                <span class="error text-red text-bold">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="Emplyee">Punch Time* <span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-4 mb-1">
                                            <input type="time" id="current-time2" class="form-control"
                                                name="sign_out">
                                            @error('sign_out')
                                                <span class="error text-red text-bold">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Location</label>
                                        <div class="col-md-4 mb-1">
                                            <div id="map-checkout" style="height: 200px; width: 100%;"></div>
                                            <input type="hidden" id="latitude2" name="latitude">
                                            <input type="hidden" id="longitude2" name="longitude">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <button class="btn btn-info" type="submit"><i class="fa fa-save"></i>
                                            &nbsp;Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="collapse" id="absent">
                            <div class="card-header">
                                <h4 class="card-title">Absent</h4>
                            </div>
                            <div class="card card-body">
                                <form class="needs-validation" method="POST"
                                    action="{{ route('hrm.attendance.absent.employee') }}" novalidate>
                                    @csrf
                                    <input type="hidden" name="emplyee_id" id="absent_employee_id">

                                    <div class="form-group row">
                                        <label for="intime" class="col-sm-3 col-form-label">Employee Name*</label>
                                        <div class="col-md-4 mb-1">
                                            <span id="absent_employee_name" class="form-control-plaintext"></span>
                                            @error('emplyee_id')
                                                <span class=" error text-red text-bold">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="intime" class="col-sm-3 col-form-label">Date *</label>
                                        <div class="col-md-4 mb-1">
                                            <input type="date" id="current-date3" class="form-control"
                                                name="date">
                                            @error('date')
                                                <span class="error text-red text-bold">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Location</label>
                                        <div class="col-md-4 mb-1">
                                            <div id="map-absent" style="height: 200px; width: 100%;"></div>
                                            <input type="hidden" id="latitude3" name="latitude">
                                            <input type="hidden" id="longitude3" name="longitude">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <button class="btn btn-info" type="submit"><i class="fa fa-save"></i>
                                            &nbsp;Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col-->
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.4.3/purify.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script>
        $(document).ready(function() {
            const sign = "{{ session()->get('sign') }}";

            // Employee Selection Logic
            $('#employee_select').on('change', function() {
                if ($(this).val()) {
                    $('#load_employee').prop('disabled', false);
                } else {
                    $('#load_employee').prop('disabled', true);
                }
            });

            // Load Employee Button Click
            $('#load_employee').on('click', function() {
                const selectedOption = $('#employee_select option:selected');
                const employeeId = selectedOption.val();
                const employeName = selectedOption.data('name');
                const employeeIdCard = selectedOption.data('id-card');

                if (employeeId) {
                    if (employeeId === 'all') {
                        // Handle "All" selection
                        $('#selected_employee_name').text('All');
                        $('#selected_employee_id').text('all');
                        $('#selected_employee_id_display').text(''); // Don't show ID for "All"

                        // Set "all" in form inputs
                        $('#checkin_employee_id').val('all');
                        $('#checkout_employee_id').val('all');
                        $('#absent_employee_id').val('all');

                        // Display "All" in employee name fields
                        $('#checkin_employee_name').text('All');
                        $('#checkout_employee_name').text('All');
                        $('#absent_employee_name').text('All');
                    } else {
                        // Handle specific employee selection
                        $('#selected_employee_name').text(employeName);
                        $('#selected_employee_id').text(employeeIdCard);
                        $('#selected_employee_id_display').text('(' + employeeIdCard +
                            ')'); // Show ID in parentheses

                        // Set employee ID in all forms
                        $('#checkin_employee_id').val(employeeId);
                        $('#checkout_employee_id').val(employeeId);
                        $('#absent_employee_id').val(employeeId);

                        // Set employee names in all forms
                        $('#checkin_employee_name').text(employeName);
                        $('#checkout_employee_name').text(employeName);
                        $('#absent_employee_name').text(employeName);
                    }

                    // Hide employee selection and show attendance forms
                    $('.employee-selection').hide();
                    $('.attendance-forms').show();

                    // Initialize maps and set current date/time
                    initializePage();
                }
            });

            // Change Employee Button
            $('#change_employee').on('click', function() {
                $('.attendance-forms').hide();
                $('.employee-selection').show();
                $('#employee_select').val('').trigger('change');
            });

            // Tab switching logic
            function resetButtons() {
                $('.check_in, .check_out, .absent').css('background', '#8fbc8f');
            }

            function initializeTabState() {
                if (sign === "0") {
                    $('#check_in').addClass('active show');
                    $('#check_out, #absent').removeClass('active show');
                    resetButtons();
                    $('.check_in').css('background', 'green');
                } else if (sign === "1") {
                    $('#check_out').addClass('active show');
                    $('#check_in, #absent').removeClass('active show');
                    resetButtons();
                    $('.check_out').css('background', 'green');
                } else {
                    $('#check_in').addClass('active show');
                    $('#check_out, #absent').removeClass('active show');
                    resetButtons();
                    $('.check_in').css('background', 'green');
                }
            }

            $('.check_in').on('click', function() {
                $('#check_in').addClass('active show');
                $('#check_out, #absent').removeClass('active show');
                resetButtons();
                $(this).css('background', 'green');
            });

            $('.check_out').on('click', function() {
                $('#check_out').addClass('active show');
                $('#check_in, #absent').removeClass('active show');
                resetButtons();
                $(this).css('background', 'green');
            });

            $('.absent').on('click', function() {
                $('#absent').addClass('active show');
                $('#check_in, #check_out').removeClass('active show');
                resetButtons();
                $(this).css('background', 'red');
            });

            // Initialize tab state when forms are loaded
            function initializePage() {
                initializeTabState();

                // Get current date and time
                var currentDate = new Date().toISOString().slice(0, 10);
                var currentTime = new Date().toLocaleTimeString('en-GB', {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                // Set date and time values
                document.getElementById('current-date').value = currentDate;
                document.getElementById('current-date2').value = currentDate;
                document.getElementById('current-date3').value = currentDate;
                document.getElementById('current-time').value = currentTime;
                document.getElementById('current-time2').value = currentTime;

                // Get user's location and display maps
                getLocation();
            }
        });

        // Map functions
        function initMap(id, lat, lng) {
            // Initialize the map and set its view to the user's location
            var map = L.map(id).setView([lat, lng], 18);

            // Load and display the tile layer from OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Add a marker at the user's location
            L.marker([lat, lng]).addTo(map)
                .bindPopup('You are here!')
                .openPopup();
        }

        // Function to get the user's location
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;

                    // Set the hidden input values for all maps
                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lng;
                    document.getElementById('latitude2').value = lat;
                    document.getElementById('longitude2').value = lng;
                    document.getElementById('latitude3').value = lat;
                    document.getElementById('longitude3').value = lng;

                    // Initialize all maps with the user's location
                    initMap('map-checkin', lat, lng);
                    initMap('map-checkout', lat, lng);
                    initMap('map-absent', lat, lng);
                }, function() {
                    alert('Geolocation failed or permission denied.');
                });
            } else {
                alert('Geolocation is not supported by this browser.');
            }
        }
    </script>
@endsection
