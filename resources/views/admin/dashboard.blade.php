@extends('layouts.adminlte')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible shadow">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check"></i> Success!</h5>
        {{ session('success') }}
    </div>
@endif  
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['total_students'] ?? 0 }}</h3>
                <p>Total Students</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-graduate"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['total_staff'] ?? 0 }}</h3>
                <p>Total Staff</p>
            </div>
            <div class="icon">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $stats['pending_apps'] ?? 0 }}</h3>
                <p>Pending Applications</p>
            </div>
            <div class="icon">
                <i class="fas fa-file-alt"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $stats['sections'] ?? 0 }}</h3>
                <p>Active Sections</p>
            </div>
            <div class="icon">
                <i class="fas fa-layer-group"></i>
            </div>
        </div>
    </div>
</div>

<div class="card shadow">
    <div class="card-header border-0 bg-white">
        <h3 class="card-title font-weight-bold">Recent Admission Applications</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-valign-middle m-0">
                <thead>
                    <tr>
                        <th>Applicant Name</th>
                        <th>Preferred Course</th>
                        <th>Date Applied</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_applications ?? [] as $app)
                    <tr>
                        <td>{{ $app->first_name }} {{ $app->last_name }}</td>
                        <td>{{ $app->preferred_course }}</td>
                        <td>{{ $app->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('admin.applications.show', $app->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> View & Approve
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">No recent applications found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection