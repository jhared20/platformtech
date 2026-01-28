@extends('layouts.app')

@section('title', 'Create Enrollment')

@section('content')
    <div class="page-header">
        <h1>Create New Enrollment</h1>
    </div>

    <div class="row">
        <div class="col-md-8">
            <form action="{{ route('enrollments.store') }}" method="POST" class="needs-validation">
                @csrf

                <div class="mb-3">
                    <label for="student_id" class="form-label">Student *</label>
                    <select class="form-select @error('student_id') is-invalid @enderror" 
                            id="student_id" name="student_id" required>
                        <option value="">-- Select a Student --</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->student_no }} - {{ $student->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="course_id" class="form-label">Course *</label>
                    <select class="form-select @error('course_id') is-invalid @enderror" 
                            id="course_id" name="course_id" required>
                        <option value="">-- Select a Course --</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->course_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="enrollment_date" class="form-label">Enrollment Date *</label>
                    <input type="date" class="form-control @error('enrollment_date') is-invalid @enderror" 
                           id="enrollment_date" name="enrollment_date" value="{{ old('enrollment_date', date('Y-m-d')) }}" required>
                    @error('enrollment_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">✅ Create Enrollment</button>
                    <a href="{{ route('enrollments.index') }}" class="btn btn-secondary">❌ Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
