@extends('layouts.adminlte')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white"><h3 class="card-title">Subject Registry</h3></div>
            <div class="card-body p-0">
                <table class="table table-striped m-0">
<thead>
    <tr>
        <th>Code</th>
        <th>Subject Name</th>
        <th>Units</th>
        <th class="text-center">Action</th> </tr>
</thead>
<tbody>
    @foreach($subjects as $subject)
    <tr>
        <td>{{ $subject->subject_code }}</td>
        <td>{{ $subject->name }}</td>
        <td>{{ $subject->units }}</td>
        <td class="text-center">
            <a href="{{ route('subjects.edit', $subject->id) }}" class="btn btn-sm btn-warning">
                <i class="fas fa-edit"></i>
            </a>

            <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this subject?')">
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
            <div class="card-header"><h3 class="card-title">Add New Subject</h3></div>
            <form action="{{ route('subjects.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>Subject Code</label>
                        <input type="text" name="subject_code" class="form-control" placeholder="e.g. IT101" required>
                    </div>
                    <div class="form-group">
                        <label>Subject Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Programming 1" required>
                    </div>
                    <div class="form-group">
                        <label>Units</label>
                        <input type="number" name="units" class="form-control" value="3" required>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success w-100">Save Subject</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection