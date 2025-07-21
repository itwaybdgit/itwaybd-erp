@extends('admin.master')

 <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" />
    <style>
        .select2-container--bootstrap .select2-selection--single {
            height: 38px !important;
            line-height: 38px !important;
        }
        .select2-container--bootstrap .select2-selection--multiple {
            min-height: 38px !important;
        }
        .select2-container {
            width: 100% !important;
        }
        .select2-selection__choice {
            background-color: #007bff !important;
            border-color: #007bff !important;
            color: white !important;
        }
        .select2-selection__choice__remove {
            color: white !important;
        }
        .select2-selection__choice__remove:hover {
            color: #dc3545 !important;
        }
    </style>

@section('content')
    <section id="project-create-section">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ $page_heading ?? 'Project Create' }}</h4>

                        <a href="{{ route('project.index') }}" class="btn btn-rounded btn-info">
                            <span class="btn-icon-start text-white">
                                <i class="fa fa-arrow-left"></i>
                            </span>
                            Back to List
                        </a>
                    </div>

                    <div class="card-body mt-2">
                        <form action="{{ route('project.store') }}" method="POST">
                            @csrf

                            <div class="row g-3">
                                <!-- Project Name -->
                                <div class="col-md-4">
                                    <label for="name" class="form-label">Project Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old('name') }}" required>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Project Manager -->
                                {{-- <div class="col-md-4">
                                    <label for="project_manager_id" class="form-label">Project Manager <span
                                            class="text-danger">*</span></label>
                                    <select name="project_manager_id" id="project_manager_id" class="form-select select2-single" required>
                                        <option value="">Select Project Manager</option>
                                        @foreach($managers as $manager)
                                            <option value="{{ $manager->id }}" 
                                                data-email="{{ $manager->email }}"
                                                data-role="{{ $manager->role }}"
                                                {{ old('project_manager_id') == $manager->id ? 'selected' : '' }}>
                                                {{ $manager->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('project_manager_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div> --}}

                                <!-- Project Status -->
                                <div class="col-md-4">
                                    <label for="status" class="form-label">Project Status <span
                                            class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-select form-control" required>
                                        <option value="">Select Status</option>
                                        <option value="planning" {{ old('status') == 'planning' ? 'selected' : '' }}>Planning</option>
                                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="on_hold" {{ old('status') == 'on_hold' ? 'selected' : '' }}>On Hold</option>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    @error('status')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                  <div class="col-md-4">
                                    <label for="client_id" class="form-label">Client</label>
                                    <select name="client_id" id="client_id" class="form-select select2-single">
                                        <option value="">Select Client</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}" 
                                                data-email="{{ $client->contact_person_email ?? '' }}"
                                                data-company="{{ $client->company ?? '' }}"
                                                {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                                {{ $client->company_owner_name }}({{ $client->company_owner_phone }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('client_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>

                            <div class="row g-3 mt-2">
                                <!-- Starting Date -->
                                <div class="col-md-4">
                                    <label for="starting_date" class="form-label">Starting Date <span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="starting_date" id="starting_date" class="form-control"
                                        value="{{ old('starting_date') }}" required>
                                    @error('starting_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Ending Date -->
                                <div class="col-md-4">
                                    <label for="ending_date" class="form-label">Ending Date <span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="ending_date" id="ending_date" class="form-control"
                                        value="{{ old('ending_date') }}" required>
                                    @error('ending_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Priority -->
                                <div class="col-md-4">
                                    <label for="priority" class="form-label">Priority <span
                                            class="text-danger">*</span></label>
                                    <select name="priority" id="priority" class="form-select form-control" required>
                                        <option value="">Select Priority</option>
                                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                                        <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                    </select>
                                    @error('priority')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-3 mt-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Team Members Selection -->
                            <div class="row g-3 mt-2">
                                <div class="col-12">
                                    <label for="team_members" class="form-label">Team Members</label>
                                    <select name="team_members[]" id="team_members" class="form-select select2-multiple" multiple>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" 
                                                data-email="{{ $user->email }}"
                                                data-role="{{ $user->role ?? 'Member' }}"
                                                data-department="{{ $user->department->name ?? 'N/A' }}"
                                                {{ in_array($user->id, old('team_members', [])) ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Search and select multiple team members</small>
                                    @error('team_members')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-3 mt-2">
                                <!-- Budget -->
                               

                                <!-- Client -->
                              

                                <!-- Department -->
                                {{-- <div class="col-md-4">
                                    <label for="department_id" class="form-label">Department</label>
                                    <select name="department_id" id="department_id" class="form-select select2-single">
                                        <option value="">Select Department</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" 
                                                data-description="{{ $department->description ?? '' }}"
                                                {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('department_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div> --}}
                            </div>

                            <div class="row g-3 mt-2">
                                <!-- Hypercare -->
                                <div class="col-md-2">
                                    <label for="hypercare" class="form-label">Hypercare <span
                                            class="text-danger">*</span></label>
                                    <select name="hypercare" id="hypercare" class="form-select form-control" required>
                                        <option value="0" {{ old('hypercare') == '0' ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ old('hypercare') == '1' ? 'selected' : '' }}>Yes</option>
                                    </select>
                                    @error('hypercare')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Hypercare Months -->
                                <div class="col-md-4" id="hypercare_months_div" style="display: none;">
                                    <label for="hypercare_months" class="form-label">Hypercare Months <span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="hypercare_months" id="hypercare_months" class="form-control"
                                        min="1" value="{{ old('hypercare_months') }}">
                                    @error('hypercare_months')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Estimated Hours -->
                                <div class="col-md-3">
                                    <label for="estimated_hours" class="form-label">Estimated Hours</label>
                                    <input type="number" name="estimated_hours" id="estimated_hours" class="form-control"
                                        min="0" value="{{ old('estimated_hours') }}">
                                    @error('estimated_hours')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Progress -->
                                <div class="col-md-3">
                                    <label for="progress" class="form-label">Progress (%)</label>
                                    <input type="number" name="progress" id="progress" class="form-control"
                                        min="0" max="100" value="{{ old('progress', 0) }}">
                                    @error('progress')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                 <div class="col-md-3">
                                    <label for="budget" class="form-label">Budget</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" name="budget" id="budget" class="form-control" 
                                            step="0.01" min="0" value="{{ old('budget') }}">
                                    </div>
                                    @error('budget')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                
                            </div>

                            <!-- Tags -->
                            <div class="row g-3 mt-2">
                                <div class="col-12">
                                    <label for="tags" class="form-label">Tags</label>
                                    <select name="tags[]" id="tags" class="form-select select2-tags" multiple>
                                        @if(old('tags'))
                                            @foreach(explode(',', old('tags')) as $tag)
                                                <option value="{{ trim($tag) }}" selected>{{ trim($tag) }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <small class="text-muted">Type to add new tags or search existing ones</small>
                                    @error('tags')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Additional Notes -->
                            <div class="mb-3 mt-3">
                                <label for="notes" class="form-label">Additional Notes</label>
                                <textarea name="notes" id="notes" rows="3" class="form-control" 
                                    placeholder="Any additional notes or requirements...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Create Project</button>
                                <button type="reset" class="btn btn-secondary">Reset Form</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    
    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Select2 for single select dropdowns
            $('.select2-single').select2({
                theme: 'bootstrap',
                placeholder: function() {
                    return $(this).data('placeholder') || 'Please select...';
                },
                allowClear: true,
                templateResult: formatUser,
                templateSelection: formatUserSelection
            });

            // Initialize Select2 for multiple select (team members)
            $('#team_members').select2({
                theme: 'bootstrap',
                placeholder: 'Search and select team members...',
                allowClear: true,
                templateResult: formatUserDetailed,
                templateSelection: formatUserSelection
            });

            // Initialize Select2 for tags with tagging enabled
            $('#tags').select2({
                theme: 'bootstrap',
                placeholder: 'Add tags...',
                allowClear: true,
                tags: true,
                tokenSeparators: [',', ' '],
                createTag: function(params) {
                    var term = $.trim(params.term);
                    if (term === '') {
                        return null;
                    }
                    return {
                        id: term,
                        text: term,
                        newTag: true
                    };
                },
                templateResult: function(state) {
                    if (state.newTag) {
                        return $('<span><i class="fa fa-plus"></i> Add "' + state.text + '"</span>');
                    }
                    return state.text;
                }
            });

            // Format function for user dropdowns
            function formatUser(user) {
                if (!user.id) {
                    return user.text;
                }
                
                var email = $(user.element).data('email');
                var role = $(user.element).data('role');
                
                if (email) {
                    return $(
                        '<div>' +
                        '<strong>' + user.text + '</strong>' +
                        '<div><small class="text-muted">' + email + (role ? ' - ' + role : '') + '</small></div>' +
                        '</div>'
                    );
                }
                
                return user.text;
            }

            // Format function for detailed user display (team members)
            function formatUserDetailed(user) {
                if (!user.id) {
                    return user.text;
                }
                
                var email = $(user.element).data('email');
                var role = $(user.element).data('role');
                var department = $(user.element).data('department');
                
                if (email) {
                    return $(
                        '<div>' +
                        '<strong>' + user.text + '</strong>' +
                        '<div><small class="text-muted">' + email + '</small></div>' +
                        '<div><small class="text-info">' + (role || 'Member') + 
                        (department && department !== 'N/A' ? ' - ' + department : '') + '</small></div>' +
                        '</div>'
                    );
                }
                
                return user.text;
            }

            // Format function for selected items
            function formatUserSelection(user) {
                return user.text;
            }

            // Hypercare toggle functionality
            const hypercareSelect = document.getElementById('hypercare');
            const hypercareMonthsDiv = document.getElementById('hypercare_months_div');

            function toggleHypercareMonths() {
                if (hypercareSelect.value === '1') {
                    hypercareMonthsDiv.style.display = 'block';
                    document.getElementById('hypercare_months').setAttribute('required', 'required');
                } else {
                    hypercareMonthsDiv.style.display = 'none';
                    document.getElementById('hypercare_months').removeAttribute('required');
                }
            }

            hypercareSelect.addEventListener('change', toggleHypercareMonths);
            toggleHypercareMonths();

            // Date validation
            const startDateInput = document.getElementById('starting_date');
            const endDateInput = document.getElementById('ending_date');

            function validateDates() {
                const startDate = new Date(startDateInput.value);
                const endDate = new Date(endDateInput.value);

                if (startDate && endDate && startDate > endDate) {
                    endDateInput.setCustomValidity('End date must be after start date');
                } else {
                    endDateInput.setCustomValidity('');
                }
            }

            startDateInput.addEventListener('change', validateDates);
            endDateInput.addEventListener('change', validateDates);

            // Form reset handling
            $('button[type="reset"]').on('click', function() {
                $('.select2-single, .select2-multiple, .select2-tags').val(null).trigger('change');
            });

            // Add search functionality for large datasets
            $('#team_members').on('select2:opening', function() {
                $(this).data('select2').$dropdown.find(':input.select2-search__field').attr('placeholder', 'Search team members...');
            });

            $('#project_manager_id').on('select2:opening', function() {
                $(this).data('select2').$dropdown.find(':input.select2-search__field').attr('placeholder', 'Search managers...');
            });

            $('#client_id').on('select2:opening', function() {
                $(this).data('select2').$dropdown.find(':input.select2-search__field').attr('placeholder', 'Search clients...');
            });

            $('#department_id').on('select2:opening', function() {
                $(this).data('select2').$dropdown.find(':input.select2-search__field').attr('placeholder', 'Search departments...');
            });
        });
    </script>
    @endsection

    