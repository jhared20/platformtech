# Quick Reference Guide

## System Overview
**Student Enrollment System** - A Laravel 10 CRUD application for managing students, courses, and enrollments.

---

## 🏃 Quick Start

```bash
# 1. Navigate to project
cd c:\xampp\htdocs\platform

# 2. Create MySQL database
mysql -u root -e "CREATE DATABASE student_enrollment;"

# 3. Configure .env file (set DB_DATABASE, DB_USERNAME, DB_PASSWORD)

# 4. Run migrations
php artisan migrate

# 5. Start Laravel development server
php artisan serve

# 6. Open in browser
http://localhost:8000
```

---

## 📍 Main Pages

| Page | URL | Description |
|------|-----|-------------|
| Dashboard | `/` | Welcome page with overview |
| Students | `/students` | List all students |
| Courses | `/courses` | List all courses |
| Enrollments | `/enrollments` | List all enrollments |

---

## 👤 Student Management

### Create Student
- Route: `GET /students/create`
- Fields: Student No, Name, Email
- Validation: All required, student_no and email must be unique

### View Student
- Route: `GET /students/{id}`
- Shows: Student details + list of enrolled courses

### Edit Student
- Route: `GET /students/{id}/edit` or `PUT /students/{id}`
- Fields: Student No, Name, Email

### Delete Student
- Route: `DELETE /students/{id}`
- Note: Automatically deletes related enrollments (cascade)

---

## 📚 Course Management

### Create Course
- Route: `GET /courses/create`
- Fields: Course Name, Description (optional)

### View Course
- Route: `GET /courses/{id}`
- Shows: Course details + list of enrolled students

### Edit Course
- Route: `GET /courses/{id}/edit` or `PUT /courses/{id}`
- Fields: Course Name, Description

### Delete Course
- Route: `DELETE /courses/{id}`
- Note: Automatically deletes related enrollments (cascade)

---

## ✅ Enrollment Management

### Create Enrollment
- Route: `GET /enrollments/create` or `POST /enrollments`
- Fields: Student (dropdown), Course (dropdown), Enrollment Date
- Validation: Prevents duplicate enrollments

### View Enrollment
- Route: `GET /enrollments/{id}`
- Shows: Student info + Course info + Enrollment date

### Delete Enrollment
- Route: `DELETE /enrollments/{id}`
- Removes student from course

---

## 🗂️ File Reference

### Controllers (app/Http/Controllers/)
- **StudentController** - Student CRUD operations
- **CourseController** - Course CRUD operations
- **EnrollmentController** - Enrollment operations (no edit/update)

### Models (app/Models/)
- **Student** - Student model with relationships
- **Course** - Course model with relationships
- **Enrollment** - Enrollment model with relationships

### Migrations (database/migrations/)
- Students table creation
- Courses table creation
- Enrollments table creation with foreign keys

### Views (resources/views/)
- **layouts/app.blade.php** - Base template
- **students/** - Student views (4 files)
- **courses/** - Course views (4 files)
- **enrollments/** - Enrollment views (3 files)

### Routes (routes/web.php)
- RESTful routes for all three resources

---

## 🔍 HTTP Methods

| Method | Purpose | Example |
|--------|---------|---------|
| GET | Retrieve data | `/students` → List students |
| POST | Create data | `/students` → Create student |
| PUT | Update data | `/students/1` → Update student |
| DELETE | Delete data | `/students/1` → Delete student |

---

## 📋 Validation Rules

### Student Fields
```
student_no: required, unique, max:20
name: required, max:255
email: required, email, unique
```

### Course Fields
```
course_name: required, max:255
description: nullable, string
```

### Enrollment Fields
```
student_id: required, exists:students
course_id: required, exists:courses
enrollment_date: required, date
```

---

## 💾 Database Tables

### students
- id (Primary Key)
- student_no (Unique)
- name
- email (Unique)
- created_at, updated_at

### courses
- id (Primary Key)
- course_name
- description (Nullable)
- created_at, updated_at

### enrollments
- id (Primary Key)
- student_id (Foreign Key)
- course_id (Foreign Key)
- enrollment_date
- created_at, updated_at
- Unique(student_id, course_id)

---

## 🔗 Relationships

```
Student
  ├─ hasMany → Enrollments
  └─ belongsToMany → Courses (through enrollments)

Course
  ├─ hasMany → Enrollments
  └─ belongsToMany → Students (through enrollments)

Enrollment
  ├─ belongsTo → Student
  └─ belongsTo → Course
```

---

## 🧪 Testing Scenarios

1. **Create & List**
   - Create a student → View in list → Verify details

2. **Update**
   - Edit student data → Verify changes saved

3. **Relationships**
   - Create student → Enroll in course → View student → Check enrollment list

4. **Validation**
   - Try creating student with duplicate student_no → Should error
   - Try enrolling same student twice → Should error

5. **Cascade Delete**
   - Create student → Enroll in courses → Delete student → Check enrollments gone

---

## 🎨 UI Features

- **Bootstrap 5** responsive design
- **Navbar** with navigation links
- **Tables** with action buttons
- **Forms** with validation feedback
- **Alerts** for success/error messages
- **Emoji icons** for visual appeal

---

## 🛡️ Security

✅ CSRF protection on all forms
✅ Input validation
✅ SQL injection prevention (Eloquent ORM)
✅ Mass assignment protection
✅ Foreign key constraints

---

## 📞 Troubleshooting

**Migration Error:**
- Ensure MySQL is running
- Check database name in .env file
- Run: `php artisan migrate`

**Page Not Found:**
- Verify routes in `routes/web.php`
- Check controller methods match route
- Review route names in views

**Validation Errors:**
- Check field names match form inputs
- Verify validation rules in controller
- Check database column types

**Styling Issues:**
- Bootstrap CSS should load from CDN
- Check network tab in browser dev tools
- Clear browser cache

---

## 📚 File Locations Quick Reference

```
Controllers:     c:\xampp\htdocs\platform\app\Http\Controllers\
Models:          c:\xampp\htdocs\platform\app\Models\
Migrations:      c:\xampp\htdocs\platform\database\migrations\
Views:           c:\xampp\htdocs\platform\resources\views\
Routes:          c:\xampp\htdocs\platform\routes\web.php
Documentation:   c:\xampp\htdocs\platform\README.md
```

---

## 🚀 Deployment Notes

Before deploying to production:
1. Update `.env` with production database
2. Run `php artisan key:generate`
3. Set `APP_DEBUG=false`
4. Configure proper authentication (if needed)
5. Set up proper error logging
6. Configure mail settings for notifications

---

**Version:** 1.0
**Framework:** Laravel 10
**Database:** MySQL
**UI:** Bootstrap 5
**Status:** Ready for Use ✅
