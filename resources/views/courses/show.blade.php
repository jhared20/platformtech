@extends('layouts.app')

@section('title', $course->course_name)

@section('content')
    <div class="page-header">
        <h1>{{ $course->course_name }}</h1>
        <div>
            <a href="{{ route('courses.edit', $course) }}" class="btn btn-warning btn-action">✏️ Edit</a>
            <form action="{{ route('courses.destroy', $course) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-action" onclick="return confirm('Are you sure?')">🗑️ Delete</button>
            </form>
            <a href="{{ route('courses.index') }}" class="btn btn-secondary">← Back</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Course Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="fw-bold">Description:</label>
                        <p>{{ $course->description ?? 'No description provided' }}</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="fw-bold">Created:</label>
                            <p>{{ $course->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold">Updated:</label>
                            <p>{{ $course->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if ($enrollments->isEmpty())
                <div class="alert alert-info">
                    <p class="mb-0">No students are enrolled in this course yet.</p>
                </div>
            @else
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Enrolled Students ({{ $enrollments->count() }})</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Student No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Enrollment Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($enrollments as $enrollment)
                                    <tr>
                                        <td>{{ $enrollment->student->student_no }}</td>
                                        <td>{{ $enrollment->student->name }}</td>
                                        <td>{{ $enrollment->student->email }}</td>
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
