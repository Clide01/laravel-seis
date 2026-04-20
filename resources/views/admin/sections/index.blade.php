@extends('layouts.adminlte')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white"><h3 class="card-title">Academic Sections</h3></div>
            <div class="card-body p-0">
                <table class="table table-striped m-0">
                    <thead>
                        <tr>
                            <th>Section Name</th>
                            <th>Course</th> <th>Adviser (Staff)</th>
                            <th>Capacity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sections as $section)
                        <tr>
                            <td><strong>{{ $section->section_name }}</strong></td>
                            <td><span class="badge badge-info">{{ $section->course }}</span></td> <td>{{ $section->adviser ? $section->adviser->name : 'No Adviser Assigned' }}</td>
                            <td>{{ $section->max_capacity }}</td>
                            <td>
                                <a href="{{ route('sections.show', $section->id) }}" class="btn btn-sm btn-info text-white">
                                    <i class="fas fa-cog"></i> Manage Class
                                </a>
                                
                                <form action="{{ route('sections.destroy', $section->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this section? All schedules and enrollments inside will be lost.')">
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

    <div class="col-md-4">
        <div class="card shadow card-success">
            <div class="card-header"><h3 class="card-title">Create New Section</h3></div>
            <form action="{{ route('sections.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>Section Name (e.g. 1A)</label>
                        <input type="text" name="section_name" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Course</label>
                        <select name="course" class="form-control" required>
                            <option value="">Select Course...</option>
                            <option value="BS Information Technology">BS Information Technology</option>
                            <option value="BS Computer Science">BS Computer Science</option>
                            <option value="BS Business Administration">BS Business Administration</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Max Student Capacity</label>
                        <input type="number" name="max_capacity" class="form-control" value="30" required>
                    </div>
                    <div class="form-group">
                        <label>Assign Adviser (Staff)</label>
                        <select name="adviser_id" class="form-control">
                            <option value="">-- No Adviser Yet --</option>
                            @foreach($staffMembers as $staff)
                                <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success w-100">Create Section</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection