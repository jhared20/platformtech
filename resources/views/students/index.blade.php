@extends('layouts.app')

@section('title', 'Students')

@section('content')
    <div class="page-header">
        <h1>Students</h1>
        <a href="{{ route('students.create') }}" class="btn btn-success">➕ Add New Student</a>
    </div>

    @if ($students->isEmpty())
        <div class="alert alert-info text-center">
            <p>No students found. <a href="{{ route('students.create') }}">Create one now</a></p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Student No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $student->student_no }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>
                                <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-info btn-action">👁️ View</a>
                                <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-warning btn-action">✏️ Edit</a>
                                <form action="{{ route('students.destroy', $student) }}" method="POST" style="display:inline;">
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
