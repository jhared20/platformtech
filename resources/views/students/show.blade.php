@extends('layouts.app')

@section('title', $student->name)

@section('content')
    <div class="page-header">
        <h1>{{ $student->name }}</h1>
        <div>
            <a href="{{ route('students.edit', $student) }}" class="btn btn-warning btn-action">✏️ Edit</a>
            <form action="{{ route('students.destroy', $student) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-action" onclick="return confirm('Are you sure?')">🗑️ Delete</button>
            </form>
            <a href="{{ route('students.index') }}" class="btn btn-secondary">← Back</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Student Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold">Student Number:</label>
                            <p>{{ $student->student_no }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold">Email:</label>
                            <p>{{ $student->email }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold">Created:</label>
                            <p>{{ $student->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold">Updated:</label>
                            <p>{{ $student->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if ($enrollments->isEmpty())
                <div class="alert alert-info">
                    <p class="mb-0">This student is not enrolled in any courses yet.</p>
                </div>
            @else
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Enrolled Courses</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Course</th>
                                    <th>Description</th>
                                    <th>Enrollment Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($enrollments as $enrollment)
                                    <tr>
                                        <td>{{ $enrollment->course->course_name }}</td>
                                        <td>{{ Str::limit($enrollment->course->description, 50) }}</td>
                                        <td>{{ $enrollment->enrollment_date->format('d M Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
