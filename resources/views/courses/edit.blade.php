@extends('layouts.app')

@section('title', 'Edit Course')

@section('content')
    <div class="page-header">
        <h1>Edit Course</h1>
    </div>

    <div class="row">
        <div class="col-md-8">
            <form action="{{ route('courses.update', $course) }}" method="POST" class="needs-validation">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="course_name" class="form-label">Course Name *</label>
                    <input type="text" class="form-control @error('course_name') is-invalid @enderror" 
                           id="course_name" name="course_name" value="{{ old('course_name', $course->course_name) }}" required>
                    @error('course_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="5">{{ old('description', $course->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">💾 Update Course</button>
                    <a href="{{ route('courses.index') }}" class="btn btn-secondary">❌ Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
