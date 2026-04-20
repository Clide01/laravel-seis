@extends('layouts.adminlte')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow card-warning mt-4">
            <div class="card-header">
                <h3 class="card-title">Edit Subject: {{ $subject->subject_code }}</h3>
            </div>
            
            <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="subject_code">Subject Code</label>
                        <input type="text" name="subject_code" class="form-control" id="subject_code" value="{{ $subject->subject_code }}" required>
                    </div>

                    <div class="form-group">
                        <label for="name">Subject Name</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ $subject->name }}" required>
                    </div>

                    <div class="form-group">
                        <label for="units">Units</label>
                        <input type="number" name="units" class="form-control" id="units" value="{{ $subject->units }}" required>
                    </div>
                </div>

                <div class="card-footer text-right">
                    <a href="{{ route('subjects.index') }}" class="btn btn-default">Cancel</a>
                    <button type="submit" class="btn btn-warning font-weight-bold">
                        <i class="fas fa-save mr-1"></i> Update Subject
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection