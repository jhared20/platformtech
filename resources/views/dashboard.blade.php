@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="text-center py-5">
                <h1 class="display-4 mb-4">Welcome to Student Enrollment System</h1>
                <p class="lead mb-4">Manage students, courses, and enrollments with ease</p>
                
                <div class="row mt-5">
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body text-center">
                                <h5 class="card-title">👨‍🎓 Students</h5>
                                <p class="card-text">Manage student information</p>
                                <a href="{{ route('students.index') }}" class="btn btn-primary">View Students</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body text-center">
                                <h5 class="card-title">📖 Courses</h5>
                                <p class="card-text">Manage course information</p>
                                <a href="{{ route('courses.index') }}" class="btn btn-primary">View Courses</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body text-center">
                                <h5 class="card-title">✅ Enrollments</h5>
                                <p class="card-text">Manage student enrollments</p>
                                <a href="{{ route('enrollments.index') }}" class="btn btn-primary">View Enrollments</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
