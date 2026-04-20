@extends('layouts.adminlte')

@section('content')
<h2 class="mb-4">Section: <strong>{{ $section->section_name }}</strong></h2>

<div class="row">
    <div class="col-md-6">
        @if(session('success') && !session('tracker_result')) {{-- Simple check to show generic success --}}
            <div class="alert alert-success text-sm py-2"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        <div class="card shadow card-success card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-users"></i> Student Enrollment</h3>
            </div>
            <div class="card-body bg-light">
                <form action="{{ route('sections.enroll', $section->id) }}" method="POST" class="mb-4">
                    @csrf
                    <label class="text-muted text-sm mb-1">Available Students for: <strong class="text-dark">{{ $section->course ?? 'All Courses' }}</strong></label>
                    
                    <div class="border bg-white rounded p-3 mb-2" style="max-height: 200px; overflow-y: auto;">
                        @forelse($available_students as $student)
                            <div class="custom-control custom-checkbox mb-1">
                                <input class="custom-control-input" type="checkbox" name="user_ids[]" id="student_{{ $student->id }}" value="{{ $student->id }}">
                                <label for="student_{{ $student->id }}" class="custom-control-label font-weight-normal cursor-pointer">
                                    {{ $student->name }} <span class="text-muted text-sm">({{ $student->email }})</span>
                                </label>
                            </div>
                        @empty
                            <div class="text-center text-muted py-3">
                                <i class="fas fa-user-slash fa-2x mb-2 opacity-50"></i>
                                <p class="mb-0">No pending students available.</p>
                            </div>
                        @endforelse
                    </div>

                    <button type="submit" class="btn btn-success w-100 font-weight-bold" {{ $available_students->isEmpty() ? 'disabled' : '' }}>
                        <i class="fas fa-user-plus mr-1"></i> Enroll Selected Students
                    </button>
                </form>

                <h6 class="font-weight-bold border-bottom pb-2 mb-3">Currently Enrolled: <span class="badge badge-success float-right">{{ count($enrolled_students) }}</span></h6>
                <ul class="list-group list-group-flush border rounded" style="max-height: 250px; overflow-y: auto;">
                    @forelse($enrolled_students as $enrollment)
                        <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
                            <div>
                                <strong>{{ $enrollment->student->name }}</strong><br>
                                <small class="text-muted">{{ $enrollment->student->email }}</small>
                            </div>
                            <div>
                                <span class="badge badge-primary badge-pill mr-2">STU-{{ str_pad($enrollment->student->id, 5, '0', STR_PAD_LEFT) }}</span>
                                <form action="{{ route('sections.unenroll', ['section' => $section->id, 'user' => $enrollment->student->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2" onclick="return confirm('Remove this student?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted py-3">No students in this section.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-calendar-alt"></i> Class Schedule</h3>
            </div>
            <div class="card-body bg-light">
                <form action="{{ route('sections.schedule', $section->id) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <label class="text-sm">Teacher</label>
                            <select name="teacher_id" class="form-control" required>
                                <option value="">-- Assign Teacher --</option>
                                @foreach($teachers as $t)
                                    <option value="{{ $t->id }}">{{ $t->name }}</option>
                                @endforeach
                            </select>
                            <br>
                            <label class="text-sm">Subject</label>
                            <select name="subject_id" class="form-control" required>
                                <option value="">-- Select Subject --</option>
                                @foreach($subjects as $subj)
                                    <option value="{{ $subj->id }}">{{ $subj->subject_code }}: {{ $subj->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="text-sm">Day</label>
                            <select name="day" class="form-control" required>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="text-sm">Start</label>
                            <input type="time" name="start_time" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="text-sm">End</label>
                            <input type="time" name="end_time" class="form-control" required>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="input-group">
                                <input type="text" name="room" class="form-control" placeholder="Room (e.g. Lab 1)" required>
                                <button type="submit" class="btn btn-primary">Add to Schedule</button>
                            </div>
                        </div>
                    </div>
                </form>

                <table class="table table-sm table-bordered bg-white shadow-sm">
                    <thead class="bg-gray-light">
                        <tr>
                            <th>Subject</th>
                            <th>Day</th>
                            <th>Time</th>
                            <th>Room</th>
                            <th class="text-center">Action</th> </tr>
                    </thead>
                    <tbody>
                        @foreach($schedules as $sched)
                            <tr>
                                <td><strong>{{ $sched->subject_code }}</strong></td>
                                <td>{{ $sched->day }}</td>
                                <td>{{ \Carbon\Carbon::parse($sched->start_time)->format('g:i A') }}</td>
                                <td>{{ $sched->room }}</td>
                                <td class="text-center">
                                    <form action="{{ route('schedules.destroy', $sched->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Delete this schedule?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection