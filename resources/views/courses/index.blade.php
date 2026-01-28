@extends('layouts.app')

@section('title', 'Courses')

@section('content')
    <div class="page-header">
        <h1>Courses</h1>
        <a href="{{ route('courses.create') }}" class="btn btn-success">➕ Add New Course</a>
    </div>

    @if ($courses->isEmpty())
        <div class="alert alert-info text-center">
            <p>No courses found. <a href="{{ route('courses.create') }}">Create one now</a></p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Course Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        <tr>
                            <td>{{ $course->course_name }}</td>
                            <td>{{ Str::limit($course->description, 100) }}</td>
                            <td>
                                <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-info btn-action">👁️ View</a>
                                <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-warning btn-action">✏️ Edit</a>
                                <form action="{{ route('courses.destroy', $course) }}" method="POST" style="display:inline;">
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
