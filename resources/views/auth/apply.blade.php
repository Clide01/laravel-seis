@extends('layouts.app')

@section('content')
<div class="container pb-5">
    
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="card shadow border-info">
                <div class="card-header bg-info text-white font-weight-bold">
                    <i class="fas fa-search"></i> Track Existing Application
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('apply.status') }}">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="tracking_code" class="form-control" placeholder="Enter your Tracking Code (e.g., TRK-XXXXXX)" required>
                            <button type="submit" class="btn btn-info text-white">Check Status</button>
                        </div>
                    </form>

                    @if(session('tracker_error'))
                        <div class="text-danger mt-2"><i class="fas fa-exclamation-circle"></i> {{ session('tracker_error') }}</div>
                    @endif

                    @if(session('tracker_result'))
                        @php $result = session('tracker_result'); @endphp
                        <div class="alert mt-3 {{ $result->status == 'approved' ? 'alert-success' : 'alert-warning' }}">
                            <h5>Application Status: <strong>{{ strtoupper($result->status) }}</strong></h5>
                            
                            @if($result->status == 'pending')
                                <p class="mb-0">Your application is still under review. Please check back later.</p>
                            @elseif($result->status == 'approved')
                                <p>Congratulations! You have been approved. Use the credentials below to log into the Student Portal:</p>
                                <hr>
                                <p class="mb-1"><strong>Username / Email:</strong> {{ $result->email }}</p>
                                <p class="mb-1"><strong>Password:</strong> <span class="badge bg-dark fs-6">{{ $result->assigned_password }}</span></p>
                                <div class="mt-3">
                                    <a href="{{ route('login') }}" class="btn btn-success btn-sm">Go to Student Login</a>
                                </div>
                            @endif
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white"><h4>Submit New Application</h4></div>

                <div class="card-body">
                    
                    @if(session('success'))
                        <div class="alert alert-success text-center">
                            <h4><i class="fas fa-check-circle"></i> {{ session('success') }}</h4>
                            <p class="mb-1">Please save your tracking code to check your status later:</p>
                            <h2 class="font-weight-bold text-dark border p-2 bg-light d-inline-block">{{ session('tracking_code') }}</h2>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('apply.submit') }}">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>First Name</label>
                                <input type="text" name="first_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Last Name</label>
                                <input type="text" name="last_name" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Email Address</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Birthdate</label>
                                <input type="date" name="birthdate" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Gender</label>
                                <select name="gender" class="form-control" required>
                                    <option value="">Select Gender...</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Preferred Course</label>
                                <select name="preferred_course" class="form-control" required>
                                    <option value="">Select Course...</option>
                                    <option value="BS Information Technology">BS Information Technology</option>
                                    <option value="BS Computer Science">BS Computer Science</option>
                                    <option value="BS Business Administration">BS Business Administration</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Home Address</label>
                            <textarea name="address" class="form-control" rows="2"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label>Previous School Attended</label>
                            <input type="text" name="previous_school" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-success w-100">Submit Application</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection