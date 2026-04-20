@extends('layouts.adminlte')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible shadow">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    {{ session('error') }}
                </div>
            @endif
            <div class="card-header bg-primary text-white"><h3 class="card-title">Applicant Information</h3></div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr><th>Full Name</th><td>{{ $application->first_name }} {{ $application->last_name }}</td></tr>
                    <tr><th>Email Address</th><td>{{ $application->email }}</td></tr>
                    <tr><th>Gender</th><td>{{ $application->gender }}</td></tr>
                    <tr><th>Birthdate</th><td>{{ $application->birthdate }}</td></tr>
                    <tr><th>Address</th><td>{{ $application->address }}</td></tr>
                    <tr><th>Previous School</th><td>{{ $application->previous_school }}</td></tr>
                    <tr><th>Preferred Course</th><td><span class="badge badge-info">{{ $application->preferred_course }}</span></td></tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow card-success">
            <div class="card-header"><h3 class="card-title">Approval Action</h3></div>
            <div class="card-body">
                <p>To approve this student, assign them a password. Provide these credentials to the student so they can access the Student Portal.</p>
                
                <form action="{{ route('admin.applications.approve', $application->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Assign Student Password:</label>
                        <input type="text" name="password" class="form-control" placeholder="e.g. Student2026!" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100 mt-2 text-bold">
                        <i class="fas fa-check-circle"></i> Approve & Generate Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection