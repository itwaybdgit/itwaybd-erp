@extends('admin.master')

@section('content')
    <section id="">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h4 class="card-title">{{ $page_heading ?? 'Project List' }}</h4>

                        <a href="{{ route('project.create') }}" class="btn btn-rounded btn-info text-right">
                            <span class="btn-icon-start text-white">
                                <i class="fa fa-plus"></i>
                            </span>
                            Add
                        </a>

                    </div>
                    <div class="card-datatable table-responsive">
                        <table id="project_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Project Name</th>
                                    <th>Description</th>
                                    <th>Starting Time</th>
                                    <th>Ending Time</th>
                                    <th>Status</th>
                                    <th>Hypercare</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($projects) && $projects->count())
                                    @foreach ($projects as $project)
                                        <tr>

                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $project->name }}</td>
                                            <td>{{ $project->description ?? '-' }}</td>
                                            <td>{{ $project->starting_date ?? '-' }}</td>
                                            <td>{{ $project->ending_date ?? '-' }}</td>
                                            {{-- <td>
                                                @if ($project->status)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </td> --}}

                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                        style="width: {{ $project->completionPercentage }}%;"
                                                        aria-valuenow="{{ $project->completionPercentage }}"
                                                        aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <small class="text-muted">
                                                    {{ $project->completionPercentage }}% Complete
                                                </small>
                                            </td>
                                            <td>
                                                @if ($project->hypercare_months)
                                                    Yes ({{ $project->hypercare_months }} months)
                                                @else
                                                    No
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('project.show', $project->id) }}"
                                                    class="btn btn-sm btn-info">View</a>
                                                <a href="{{ route('project.edit', $project->id) }}"
                                                    class="btn btn-sm btn-primary">Edit</a>
                                                <form action="{{ route('project.destroy', $project->id) }}" method="POST"
                                                    style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Are you sure?')"
                                                        class="btn btn-sm btn-danger">Delete</button>
                                                </form>

                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center">No projects found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
