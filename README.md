# Student Enrollment System - Laravel 10 CRUD

A complete CRUD system for managing student enrollments using Laravel 10 and MySQL.

## Features

- ✅ **Full CRUD for Students** - Create, Read, Update, Delete student records
- ✅ **Full CRUD for Courses** - Manage course information
- ✅ **Enrollment Management** - Enroll students in courses with dates
- ✅ **Responsive UI** - Bootstrap 5 with modern design
- ✅ **Form Validation** - Server-side validation for all forms
- ✅ **Relationships** - Eloquent ORM relationships between models

## Database Schema

### students
- id (Primary Key)
- student_no (Unique)
- name
- email (Unique)
- created_at
- updated_at

### courses
- id (Primary Key)
- course_name
- description (Optional)
- created_at
- updated_at

### enrollments
- id (Primary Key)
- student_id (Foreign Key → students)
- course_id (Foreign Key → courses)
- enrollment_date
- created_at
- updated_at

## Project Structure

```
platform/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── StudentController.php
│   │       ├── CourseController.php
│   │       └── EnrollmentController.php
│   └── Models/
│       ├── Student.php
│       ├── Course.php
│       └── Enrollment.php
├── database/
│   └── migrations/
│       ├── 2024_01_01_000001_create_students_table.php
│       ├── 2024_01_01_000002_create_courses_table.php
│       └── 2024_01_01_000003_create_enrollments_table.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── students/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   └── show.blade.php
│       ├── courses/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   └── show.blade.php
│       ├── enrollments/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   └── show.blade.php
│       └── dashboard.blade.php
└── routes/
    └── web.php
```

## Installation & Setup

### Prerequisites
- PHP 8.1+
- MySQL 5.7+
- Composer

### Steps

1. **Navigate to the project directory**
   ```bash
   cd c:\xampp\htdocs\platform
   ```

2. **Install dependencies** (if not already installed)
   ```bash
   composer install
   ```

3. **Configure .env file**
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=student_enrollment
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Create database**
   ```bash
   mysql -u root -e "CREATE DATABASE student_enrollment;"
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```

7. **Open in browser**
   ```
   http://localhost:8000
   ```

## API Routes

### Students
- `GET /students` - List all students
- `GET /students/create` - Show create form
- `POST /students` - Store new student
- `GET /students/{id}` - View student details
- `GET /students/{id}/edit` - Show edit form
- `PUT /students/{id}` - Update student
- `DELETE /students/{id}` - Delete student

### Courses
- `GET /courses` - List all courses
- `GET /courses/create` - Show create form
- `POST /courses` - Store new course
- `GET /courses/{id}` - View course details
- `GET /courses/{id}/edit` - Show edit form
- `PUT /courses/{id}` - Update course
- `DELETE /courses/{id}` - Delete course

### Enrollments
- `GET /enrollments` - List all enrollments
- `GET /enrollments/create` - Show create form
- `POST /enrollments` - Create enrollment
- `GET /enrollments/{id}` - View enrollment details
- `DELETE /enrollments/{id}` - Delete enrollment

## Validation Rules

### Student Validation
- `student_no` - Required, unique, max 20 characters
- `name` - Required, max 255 characters
- `email` - Required, valid email, unique

### Course Validation
- `course_name` - Required, max 255 characters
- `description` - Optional, text field

### Enrollment Validation
- `student_id` - Required, must exist in students table
- `course_id` - Required, must exist in courses table
- `enrollment_date` - Required, valid date
- Prevents duplicate enrollments (student can't enroll twice in same course)

## Key Features

### Models
- **Student** - Has many enrollments and courses
- **Course** - Has many enrollments and students
- **Enrollment** - Belongs to student and course

### Controllers
- Resource controllers for Students and Courses
- Custom controller for Enrollments (only index, create, store, show, destroy)
- Input validation in all controllers
- Eloquent eager loading for performance

### Views
- Blade templating with Bootstrap 5
- Responsive design
- Form validation feedback
- Success/error messages
- Navigation menu

## Technologies Used

- **Framework:** Laravel 10
- **Database:** MySQL
- **UI Framework:** Bootstrap 5
- **Template Engine:** Blade
- **ORM:** Eloquent

## License

MIT License
