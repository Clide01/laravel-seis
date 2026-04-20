@extends('layouts.adminlte')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Add New User</h3>
            </div>
            
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter full name" value="{{ old('name') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password (Min 8 characters)" required>
                    </div>

                    <div class="form-group">
                        <label for="role">User Role</label>
                        <select name="role" class="form-control" id="role" required>
                            <option value="">Select a role...</option>
                            <option value="admin">Admin</option>
                            <option value="staff">Staff</option>
                            <option value="student">Student</option>
                        </select>
                    </div>
                </div>

                <div class="card-footer text-right">
                    <a href="{{ route('users.index') }}" class="btn btn-default">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection