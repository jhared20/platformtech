@extends('layouts.app')

@section('title', 'Create Student')

@section('content')
    <div class="page-header">
        <h1>Create New Student</h1>
    </div>

    <div class="row">
        <div class="col-md-8">
            <form action="{{ route('students.store') }}" method="POST" class="needs-validation">
                @csrf

                <div class="mb-3">
                    <label for="student_no" class="form-label">Student Number *</label>
                    <input type="text" class="form-control @error('student_no') is-invalid @enderror" 
                           id="student_no" name="student_no" value="{{ old('student_no') }}" required>
                    @error('student_no')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Name *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">✅ Create Student</button>
                    <a href="{{ route('students.index') }}" class="btn btn-secondary">❌ Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
