@extends('layouts.adminlte')

@section('content')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Student Portal</h1>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-4">
        <div class="card card-primary card-outline shadow">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                         src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D8ABC&color=fff"
                         alt="User profile picture">
                </div>

                <h3 class="profile-username text-center mt-2">{{ $user->name }}</h3>
                <p class="text-muted text-center">{{ $user->email }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Student ID</b> <a class="float-right">STU-{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Enrollment Status</b> 
                        @if($enrollment)
                            <a class="float-right text-success font-weight-bold"><i class="fas fa-check-circle"></i> Enrolled</a>
                        @else
                            <a class="float-right text-warning font-weight-bold"><i class="fas fa-clock"></i> Pending Section</a>
                        @endif
                    </li>
                    <li class="list-group-item">
                        <b>Section</b> 
                        <a class="float-right">{{ $enrollment ? $enrollment->section->section_name : 'Not Assigned' }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title font-weight-bold"><i class="fas fa-calendar-alt mr-1"></i> My Class Schedule</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover m-0">
                    <thead>
                        <tr>
                            <th>Day</th>
                            <th>Time</th>
                            <th>Room</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($enrollment && count($schedules) > 0)
                            @foreach($schedules as $sched)
                            <tr>
                                <td><span class="badge badge-info">{{ $sched->day }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($sched->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($sched->end_time)->format('g:i A') }}</td>
                                <td>{{ $sched->room }}</td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">
                                    <i class="fas fa-bed fa-3x mb-3 d-block text-gray"></i>
                                    <h5>No schedule available</h5>
                                    <p>You have not been assigned to a schedule yet. Please check back later.</p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection