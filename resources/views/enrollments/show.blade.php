@extends('layouts.app')

@section('title', 'Enrollment Details')

@section('content')
    <div class="page-header">
        <h1>Enrollment Details</h1>
        <div>
            <form action="{{ route('enrollments.destroy', $enrollment) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-action" onclick="return confirm('Are you sure?')">🗑️ Delete Enrollment</button>
            </form>
            <a href="{{ route('enrollments.index') }}" class="btn btn-secondary">← Back</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Enrollment Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="fw-bold">Student</label>
                            <div class="mb-2">
                                <p class="mb-0"><strong>{{ $enrollment->student->name }}</strong></p>
                                <p class="text-muted mb-0">{{ $enrollment->student->student_no }}</p>
                                <p class="text-muted mb-0">{{ $enrollment->student->email }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold">Course</label>
                            <p><strong>{{ $enrollment->course->course_name }}</strong></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="fw-bold">Enrollment Date</label>
                            <p>{{ $enrollment->enrollment_date->format('d M Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold">Enrolled On</label>
                            <p>{{ $enrollment->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>

                    @if ($enrollment->course->description)
                        <div class="mt-4 pt-3 border-top">
                            <label class="fw-bold">Course Description</label>
                            <p>{{ $enrollment->course->description }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
