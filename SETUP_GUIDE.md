# Student Enrollment System - Setup Guide

## Complete Implementation Overview

This document provides a complete overview of the Student Enrollment System implemented with Laravel 10 and MySQL.

## System Architecture

### MVC Structure
- **Models:** Student, Course, Enrollment (in `app/Models/`)
- **Views:** Blade templates with Bootstrap 5 (in `resources/views/`)
- **Controllers:** Resource controllers for Students, Courses, and Enrollments (in `app/Http/Controllers/`)

### Database Layer
- Three interconnected tables with foreign key relationships
- Automatic timestamps on all tables
- Unique constraints on duplicate enrollments

## File Structure

### Migrations (database/migrations/)

1. **2024_01_01_000001_create_students_table.php**
   - Creates students table with columns: id, student_no (unique), name, email (unique), timestamps

2. **2024_01_01_000002_create_courses_table.php**
   - Creates courses table with columns: id, course_name, description (nullable), timestamps

3. **2024_01_01_000003_create_enrollments_table.php**
   - Creates enrollments table with foreign keys to students and courses
   - Includes unique constraint on (student_id, course_id) pair
   - Prevents duplicate enrollments

### Models (app/Models/)

1. **Student.php**
   - Fillable: student_no, name, email
   - Relationships: hasMany('enrollments'), belongsToMany('courses')
   
2. **Course.php**
   - Fillable: course_name, description
   - Relationships: hasMany('enrollments'), belongsToMany('students')
   
3. **Enrollment.php**
   - Fillable: student_id, course_id, enrollment_date
   - Cast enrollment_date to date
   - Relationships: belongsTo('student'), belongsTo('course')

### Controllers (app/Http/Controllers/)

1. **StudentController.php**
   - index() - Display all students
   - create() - Show create form
   - store() - Validate and save new student
   - show() - Display student with enrollments
   - edit() - Show edit form
   - update() - Validate and update student
   - destroy() - Delete student (cascades enrollments)

2. **CourseController.php**
   - index() - Display all courses
   - create() - Show create form
   - store() - Validate and save new course
   - show() - Display course with enrolled students
   - edit() - Show edit form
   - update() - Validate and update course
   - destroy() - Delete course (cascades enrollments)

3. **EnrollmentController.php**
   - index() - Display all enrollments with student and course info
   - create() - Show form with student and course dropdowns
   - store() - Validate and create enrollment (checks duplicates)
   - show() - Display enrollment details
   - destroy() - Delete enrollment

### Views (resources/views/)

#### Layouts
- **app.blade.php** - Master layout with navbar, alerts, and Bootstrap

#### Students
- **students/index.blade.php** - List all students with action buttons
- **students/create.blade.php** - Form to create new student
- **students/edit.blade.php** - Form to edit student
- **students/show.blade.php** - Student details with enrolled courses

#### Courses
- **courses/index.blade.php** - List all courses with action buttons
- **courses/create.blade.php** - Form to create new course
- **courses/edit.blade.php** - Form to edit course
- **courses/show.blade.php** - Course details with enrolled students

#### Enrollments
- **enrollments/index.blade.php** - List all enrollments
- **enrollments/create.blade.php** - Form with student and course dropdowns
- **enrollments/show.blade.php** - Enrollment details

#### Pages
- **dashboard.blade.php** - Welcome page with system overview

### Routes (routes/web.php)

- `/` - Dashboard page
- `/students` - RESTful resource routes (all CRUD operations)
- `/courses` - RESTful resource routes (all CRUD operations)
- `/enrollments` - Partial resource routes (index, create, store, show, destroy only)

## Validation Rules

### Students
| Field | Rules |
|-------|-------|
| student_no | required, unique, max:20 |
| name | required, max:255 |
| email | required, email, unique |

### Courses
| Field | Rules |
|-------|-------|
| course_name | required, max:255 |
| description | nullable, string |

### Enrollments
| Field | Rules |
|-------|-------|
| student_id | required, exists in students |
| course_id | required, exists in courses |
| enrollment_date | required, date format |
| Duplicate Check | Student can't enroll twice in same course |

## Data Relationships

### One-to-Many Relationships
- One Student → Many Enrollments
- One Course → Many Enrollments

### Many-to-Many Relationships (through Pivot Table)
- Students ↔ Courses (via enrollments table)
- With pivot data: enrollment_date

## CRUD Operations Summary

### Students
| Operation | Route | Method | Controller Method |
|-----------|-------|--------|------------------|
| List | /students | GET | index |
| Create Form | /students/create | GET | create |
| Store | /students | POST | store |
| View | /students/{id} | GET | show |
| Edit Form | /students/{id}/edit | GET | edit |
| Update | /students/{id} | PUT | update |
| Delete | /students/{id} | DELETE | destroy |

### Courses
| Operation | Route | Method | Controller Method |
|-----------|-------|--------|------------------|
| List | /courses | GET | index |
| Create Form | /courses/create | GET | create |
| Store | /courses | POST | store |
| View | /courses/{id} | GET | show |
| Edit Form | /courses/{id}/edit | GET | edit |
| Update | /courses/{id} | PUT | update |
| Delete | /courses/{id} | DELETE | destroy |

### Enrollments
| Operation | Route | Method | Controller Method |
|-----------|-------|--------|------------------|
| List | /enrollments | GET | index |
| Create Form | /enrollments/create | GET | create |
| Store | /enrollments | POST | store |
| View | /enrollments/{id} | GET | show |
| Delete | /enrollments/{id} | DELETE | destroy |

## Features Implemented

✅ **MVC Architecture** - Clean separation of concerns
✅ **Resource Controllers** - RESTful design patterns
✅ **Eloquent ORM** - Object-relational mapping
✅ **Form Validation** - Server-side validation with error messages
✅ **Relationships** - One-to-many and many-to-many
✅ **Cascade Deletes** - Foreign key constraints
✅ **Bootstrap UI** - Responsive, modern interface
✅ **Blade Templating** - Clean view templates
✅ **Flash Messages** - Success and error notifications
✅ **Pagination Ready** - Structure supports pagination

## Security Features

- **CSRF Protection** - @csrf tokens on all forms
- **Mass Assignment Protection** - Fillable attributes
- **Input Validation** - Server-side validation
- **SQL Injection Prevention** - Using Eloquent ORM

## Performance Considerations

- Eager loading in controllers with `with()` method
- Indexed foreign keys
- Unique constraints prevent duplicate data
- Query optimization in relationships

## Testing Checklist

- [ ] Create a new student
- [ ] Edit student information
- [ ] View student with enrollments
- [ ] Delete a student
- [ ] Create a new course
- [ ] Edit course information
- [ ] View course with enrolled students
- [ ] Delete a course
- [ ] Enroll a student in a course
- [ ] View enrollment details
- [ ] Try to enroll same student twice (should error)
- [ ] Delete an enrollment
- [ ] Test form validations with invalid data
- [ ] Verify cascade delete works

Path
----
C:\xampp\htdocs\platform

Development Server (http://localhost:8000) started
