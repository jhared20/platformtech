# Student Enrollment System - Modular Architecture

## Overview
The Student Enrollment System has been successfully refactored from a monolithic 1,381-line `index.php` into a clean, modular architecture following the separation of concerns principle.

## Project Structure

```
c:\xampp\htdocs\platform/
├── index.php                    # Main router & controller
├── config/
│   └── db.php                  # Database configuration (PDO connection)
├── modules/
│   ├── auth.php                # Authentication module (login page)
│   ├── dashboard.php           # Dashboard & 404 pages
│   ├── students.php            # Student CRUD view functions
│   ├── courses.php             # Course CRUD view functions
│   └── enrollments.php         # Enrollment CRUD view functions
├── database/                    # Laravel-related files (not used)
└── public/                      # Static files
```

## Architecture Overview

### 1. **Main Entry Point: index.php**
**Responsibility:** Router & Controller layer
- Session management
- Request routing (URL parsing)
- Form submission handling (CRUD operations)
- Authentication handling (login/logout)
- Database operations (INSERT, UPDATE, DELETE)

**Key Features:**
- ~135 lines (vs. original 1,381 lines)
- Clean switch statement for routing
- Modular includes for view functions
- Centralized form processing

### 2. **Configuration: config/db.php**
**Responsibility:** Database connection
- PDO connection setup
- Error handling
- Connection parameters

```php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'student_enrollment';

$pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
```

### 3. **Authentication Module: modules/auth.php**
**Responsibility:** Login functionality
- `showLogin($error)` - Displays login form with demo credentials

**Demo Credentials:**
- Username: `Jhared`
- Password: `qwerty098`

### 4. **Dashboard Module: modules/dashboard.php**
**Responsibility:** Main pages
- `showDashboard()` - Hero page with 3 action cards
- `show404()` - 404 error page

### 5. **Students Module: modules/students.php**
**Responsibility:** Student management views
- `showStudents()` - List all students
- `showCreateStudent()` - Create student form
- `showStudentDetail()` - View single student + enrolled courses
- `showEditStudent()` - Edit student form

**Database Operations Handled in index.php:**
- CREATE: `create_student`
- UPDATE: `update_student`
- DELETE: `delete_student` (cascades to delete enrollments)

### 6. **Courses Module: modules/courses.php**
**Responsibility:** Course management views
- `showCourses()` - List all courses
- `showCreateCourse()` - Create course form
- `showCourseDetail()` - View single course + enrolled students
- `showEditCourse()` - Edit course form

**Database Operations Handled in index.php:**
- CREATE: `create_course`
- UPDATE: `update_course`
- DELETE: `delete_course` (cascades to delete enrollments)

### 7. **Enrollments Module: modules/enrollments.php**
**Responsibility:** Enrollment management views
- `showEnrollments()` - List all enrollments
- `showCreateEnrollment()` - Create enrollment form
- `showEnrollmentDetail()` - View single enrollment

**Database Operations Handled in index.php:**
- CREATE: `create_enrollment`
- DELETE: `delete_enrollment`

## Design Patterns Used

### 1. **Separation of Concerns**
- **Router/Controller:** `index.php` handles routing and business logic
- **Views:** Modular files handle presentation (HTML/Bootstrap)
- **Configuration:** `config/db.php` centralizes database setup

### 2. **DRY (Don't Repeat Yourself)**
- Navbar and styling consistent across all modules
- Bootstrap 5 CDN used throughout
- Color scheme unified (#667eea → #764ba2 gradient)

### 3. **MVC-like Architecture**
```
Routes (index.php)
    ↓
Controllers (Form handlers in index.php)
    ↓
Models (Database operations in index.php)
    ↓
Views (Module files)
```

## Key Features

### Responsive Design
- Bootstrap 5 for responsive layouts
- Mobile-friendly cards and tables
- Gradient purple theme (#667eea → #764ba2)

### Form Handling
All POST requests routed through `index.php`:
1. Form submitted from module view
2. Action extracted from POST data
3. Database operation performed
4. Redirect with success/error message

### Authentication
- Session-based login
- Protected routes (redirect to login if not authenticated)
- Hardcoded default credentials for demo

### Database
- PDO for prepared statements (SQL injection prevention)
- Three main tables: `students`, `courses`, `enrollments`
- Foreign key relationships with cascading deletes

## Routing Logic

```php
// Unprotected route
/login → showLogin()

// Protected routes (require login)
/                          → showDashboard()
/students                  → showStudents()
/students/create           → showCreateStudent()
/students/{id}             → showStudentDetail()
/students/{id}/edit        → showEditStudent()
/courses                   → showCourses()
/courses/create            → showCreateCourse()
/courses/{id}              → showCourseDetail()
/courses/{id}/edit         → showEditCourse()
/enrollments               → showEnrollments()
/enrollments/create        → showCreateEnrollment()
/enrollments/{id}          → showEnrollmentDetail()
```

## Improvements Over Monolithic Approach

| Aspect | Before | After |
|--------|--------|-------|
| **Main File Size** | 1,381 lines | 135 lines |
| **Maintainability** | Difficult | Easy |
| **Code Organization** | Mixed concerns | Separated concerns |
| **Reusability** | Limited | Enhanced |
| **Testing** | Challenging | Easier (module-based) |
| **Scalability** | Poor | Good |

## How to Extend

### Add a New Module
1. Create `modules/new_module.php`
2. Define view functions (e.g., `showNewList()`, `showNewDetail()`)
3. Add routes to `index.php` switch statement
4. Add database operations to POST handler in `index.php`

Example:
```php
// In index.php
case '/new':
    showNewList($pdo, $message, $message_type);
    break;
case '/new/create':
    showCreateNew($message, $message_type);
    break;
```

### Modify Styling
- Update CSS in individual modules for module-specific styles
- Update styles in all modules for global changes
- Bootstrap 5 classes used for responsive design

## Error Handling

- **Database Errors:** Try-catch blocks with PDO::ERRMODE_EXCEPTION
- **Missing Records:** show404() function redirects to 404 page
- **Form Validation:** HTML5 required attributes + basic validation
- **Authentication:** Redirect to login for unauthenticated users

## Performance Considerations

- **Database Queries:** Prepared statements for security
- **Sessions:** Session-based authentication (lightweight)
- **Includes:** PHP requires files once at startup
- **Caching:** Could be enhanced with Redis/Memcached

## Security Features

1. **SQL Injection Prevention:** PDO prepared statements
2. **Session Security:** Session-based authentication
3. **Output Escaping:** htmlspecialchars() for user data
4. **CSRF Protection:** Form-based POST submissions
5. **Input Validation:** HTML5 + server-side validation

## Running the Application

```bash
cd c:\xampp\htdocs\platform
php -S localhost:8000
```

Then visit: `http://localhost:8000`

Login with:
- Username: `Jhared`
- Password: `qwerty098`

## Database Setup

The application requires MySQL database `student_enrollment` with tables:
- `students` (id, student_no, name, email, created_at)
- `courses` (id, course_name, description, created_at)
- `enrollments` (id, student_id, course_id, enrollment_date)

## Future Enhancements

1. **Database Abstraction Layer:** Create models for each entity
2. **Request/Response Objects:** Formal HTTP abstraction
3. **Validation Layer:** Separate validation logic
4. **Template Engine:** Use Twig or Blade for templates
5. **Unit Tests:** Add PHPUnit tests for each module
6. **API Layer:** Create REST API endpoints
7. **Admin Panel:** Add user management features
8. **Logging:** Implement application logging
9. **Error Pages:** Enhanced error handling pages
10. **Caching:** Add caching layer for performance

## Conclusion

The modular architecture provides a solid foundation for a Student Enrollment System while maintaining clean code principles and separation of concerns. The project is now easier to maintain, test, and extend.
