@extends('layouts.app')

@section('title', 'Enrollments')

@section('content')
    <div class="page-header">
        <h1>Enrollments</h1>
        <a href="{{ route('enrollments.create') }}" class="btn btn-success">➕ New Enrollment</a>
    </div>

    @if ($enrollments->isEmpty())
        <div class="alert alert-info text-center">
            <p>No enrollments found. <a href="{{ route('enrollments.create') }}">Create one now</a></p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Enrollment Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($enrollments as $enrollment)
                        <tr>
                            <td>
                                <strong>{{ $enrollment->student->name }}</strong><br>
                                <small class="text-muted">{{ $enrollment->student->student_no }}</small>
                            </td>
                            <td>{{ $enrollment->course->course_name }}</td>
                            <td>{{ $enrollment->enrollment_date->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('enrollments.show', $enrollment) }}" class="btn btn-sm btn-info btn-action">👁️ View</a>
                                <form action="{{ route('enrollments.destroy', $enrollment) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger btn-action" onclick="return confirm('Are you sure?')">🗑️ Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
