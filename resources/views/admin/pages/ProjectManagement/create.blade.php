@extends('admin.master')

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
                            </div>

                            <!-- Description -->
                            <div class="mb-3 mt-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="row g-3">
                                <!-- Hypercare -->
                                <div class="col-md-1">
                                    <label for="hypercare" class="form-label">Hypercare <span
                                            class="text-danger">*</span></label>
                                    <select id="hypercare" class="form-select">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                    @error('hypercare')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Hypercare Months -->
                                <div class="col-md-6" id="hypercare_months_div" style="display: none;">
                                    <label for="hypercare_months" class="form-label">Hypercare Months <span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="hypercare_months" id="hypercare_months" class="form-control"
                                        min="1" value="{{ old('hypercare_months') }}">
                                    @error('hypercare_months')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Create Project</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript to toggle Hypercare Months input -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
        });
    </script>
@endsection
