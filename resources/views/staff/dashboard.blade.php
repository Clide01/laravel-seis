@extends('layouts.adminlte')

@section('content')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Teacher Portal</h1>
    </div>
</div>

@if($has_classes) {{-- Changed from $my_section --}}
<div class="row mt-3">
    <div class="col-md-5">
        <div class="card shadow card-primary card-outline">
            <div class="card-header bg-white">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-calendar-alt mr-1 text-primary"></i> My Teaching Schedule
                </h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-striped m-0">
                    <thead>
                        <tr>
                            <th>Section/Subject</th>
                            <th>Time/Room</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($my_schedules as $sched)
                        <tr>
                            <td>
                                <span class="badge badge-secondary">{{ $sched->section_name }}</span><br>
                                <strong>{{ $sched->subject_code }}</strong>
                            </td>
                            <td>
                                <small>{{ $sched->day }}</small><br>
                                {{ \Carbon\Carbon::parse($sched->start_time)->format('g:i A') }} | <strong>{{ $sched->room }}</strong>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card shadow card-success card-outline">
            <div class="card-header bg-white">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-users mr-1 text-success"></i> My Students
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 400px;">
                    <table class="table table-striped table-hover m-0">
                        <thead>
                            <tr>
                                <th>Section</th>
                                <th>Name</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($my_students as $enrollment)
                            <tr>
                                <td><span class="badge badge-info">{{ $enrollment->section->section_name }}</span></td>
                                <td><strong>{{ $enrollment->student->name }}</strong></td>
                                <td>{{ $enrollment->student->email }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="row mt-4">
    <div class="col-12 text-center">
        <div class="alert alert-warning shadow-sm">
            <h5><i class="icon fas fa-exclamation-triangle"></i> No Classes Assigned</h5>
            You have not been assigned to any subjects in the class schedule yet.
        </div>
    </div>
</div>
@endif
@endsection