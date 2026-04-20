@extends('layouts.adminlte')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-warning shadow">
            <div class="card-header"><h3 class="card-title">Edit User: {{ $user->name }}</h3></div>
            
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf 
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                    </div>
                    <div class="form-group">
                        <label>New Password (Leave blank to keep current password)</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter new password">
                    </div>
                    <div class="form-group">
                        <label>User Role</label>
                        <select name="role" class="form-control" required>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Staff</option>
                            <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Student</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('users.index') }}" class="btn btn-default">Cancel</a>
                    <button type="submit" class="btn btn-warning">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection