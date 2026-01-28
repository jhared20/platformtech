# API Reference & Route Documentation

Complete reference for all endpoints in the Student Enrollment System.

---

## 🏠 Dashboard Route

### Dashboard
```
GET /
Route Name: N/A
Controller: View function
View: dashboard.blade.php
Description: Welcome page with system overview
```

**Response:**
- Displays welcome page with three main cards
- Links to Students, Courses, and Enrollments

---

## 👤 Student Routes

### List Students
```
GET /students
Route Name: students.index
Controller: StudentController@index
View: students/index.blade.php
```

**Response:**
- Table of all students
- Columns: Student No, Name, Email, Actions
- Actions: View, Edit, Delete buttons

**Example:**
```
http://localhost:8000/students
```

---

### Show Create Form
```
GET /students/create
Route Name: students.create
Controller: StudentController@create
View: students/create.blade.php
```

**Response:**
- HTML form with fields:
  - Student Number (required, unique, max 20)
  - Name (required, max 255)
  - Email (required, unique, valid email)

**Example:**
```
http://localhost:8000/students/create
```

---

### Create Student
```
POST /students
Route Name: students.store
Controller: StudentController@store
Accepts: Form data
Redirects: students.index
```

**Request Body:**
```
{
  "student_no": "STU001",
  "name": "John Doe",
  "email": "john@example.com"
}
```

**Validation Rules:**
```
student_no: required|unique:students|string|max:20
name: required|string|max:255
email: required|email|unique:students
```

**Success Response:**
- Redirect to `/students`
- Flash message: "Student created successfully."

**Error Response:**
- Redirect back to form with errors
- Shows validation error messages

**Example:**
```html
<form action="{{ route('students.store') }}" method="POST">
  @csrf
  <input type="text" name="student_no">
  <input type="text" name="name">
  <input type="email" name="email">
  <button type="submit">Create</button>
</form>
```

---

### View Student Details
```
GET /students/{id}
Route Name: students.show
Controller: StudentController@show
View: students/show.blade.php
Parameters:
  - id (int): Student ID
```

**Response:**
- Student information card:
  - Student Number
  - Name
  - Email
  - Created/Updated timestamps
- Table of enrolled courses:
  - Course name
  - Description
  - Enrollment date

**Example:**
```
http://localhost:8000/students/1
```

---

### Show Edit Form
```
GET /students/{id}/edit
Route Name: students.edit
Controller: StudentController@edit
View: students/edit.blade.php
Parameters:
  - id (int): Student ID
```

**Response:**
- Pre-filled form with current student data
- Same fields as create form

**Example:**
```
http://localhost:8000/students/1/edit
```

---

### Update Student
```
PUT /students/{id}
Route Name: students.update
Controller: StudentController@update
Parameters:
  - id (int): Student ID
Accepts: Form data with _method=PUT
Redirects: students.index
```

**Request Body:**
```
{
  "student_no": "STU001",
  "name": "John Doe Updated",
  "email": "john.updated@example.com"
}
```

**Validation Rules:**
```
student_no: required|string|max:20|unique:students,student_no,{id}
name: required|string|max:255
email: required|email|unique:students,email,{id}
```

**Success Response:**
- Redirect to `/students`
- Flash message: "Student updated successfully."

**Example:**
```html
<form action="{{ route('students.update', $student) }}" method="POST">
  @csrf
  @method('PUT')
  {{-- form fields --}}
</form>
```

---

### Delete Student
```
DELETE /students/{id}
Route Name: students.destroy
Controller: StudentController@destroy
Parameters:
  - id (int): Student ID
Accepts: Form submission with _method=DELETE
Redirects: students.index
```

**Side Effects:**
- Deletes student record
- Cascades delete to related enrollments

**Success Response:**
- Redirect to `/students`
- Flash message: "Student deleted successfully."

**Example:**
```html
<form action="{{ route('students.destroy', $student) }}" method="POST">
  @csrf
  @method('DELETE')
  <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
</form>
```

---

## 📚 Course Routes

### List Courses
```
GET /courses
Route Name: courses.index
Controller: CourseController@index
View: courses/index.blade.php
```

**Response:**
- Table of all courses
- Columns: Course Name, Description, Actions
- Actions: View, Edit, Delete buttons

---

### Show Create Form
```
GET /courses/create
Route Name: courses.create
Controller: CourseController@create
View: courses/create.blade.php
```

**Response:**
- HTML form with fields:
  - Course Name (required, max 255)
  - Description (optional)

---

### Create Course
```
POST /courses
Route Name: courses.store
Controller: CourseController@store
Accepts: Form data
Redirects: courses.index
```

**Request Body:**
```
{
  "course_name": "Introduction to Laravel",
  "description": "Learn Laravel web framework basics"
}
```

**Validation Rules:**
```
course_name: required|string|max:255
description: nullable|string
```

**Success Response:**
- Redirect to `/courses`
- Flash message: "Course created successfully."

---

### View Course Details
```
GET /courses/{id}
Route Name: courses.show
Controller: CourseController@show
View: courses/show.blade.php
Parameters:
  - id (int): Course ID
```

**Response:**
- Course information card:
  - Course Name
  - Description
  - Created/Updated timestamps
- Table of enrolled students:
  - Student Number
  - Name
  - Email
  - Enrollment date
  - Student count

---

### Show Edit Form
```
GET /courses/{id}/edit
Route Name: courses.edit
Controller: CourseController@edit
View: courses/edit.blade.php
Parameters:
  - id (int): Course ID
```

**Response:**
- Pre-filled form with current course data

---

### Update Course
```
PUT /courses/{id}
Route Name: courses.update
Controller: CourseController@update
Parameters:
  - id (int): Course ID
Accepts: Form data with _method=PUT
Redirects: courses.index
```

**Request Body:**
```
{
  "course_name": "Advanced Laravel",
  "description": "Advanced Laravel techniques and best practices"
}
```

**Validation Rules:**
```
course_name: required|string|max:255
description: nullable|string
```

**Success Response:**
- Redirect to `/courses`
- Flash message: "Course updated successfully."

---

### Delete Course
```
DELETE /courses/{id}
Route Name: courses.destroy
Controller: CourseController@destroy
Parameters:
  - id (int): Course ID
Accepts: Form submission with _method=DELETE
Redirects: courses.index
```

**Side Effects:**
- Deletes course record
- Cascades delete to related enrollments

---

## ✅ Enrollment Routes

### List Enrollments
```
GET /enrollments
Route Name: enrollments.index
Controller: EnrollmentController@index
View: enrollments/index.blade.php
```

**Response:**
- Table of all enrollments
- Columns: Student, Course, Enrollment Date, Actions
- Actions: View, Delete buttons
- Shows student name, number, and course name

---

### Show Create Form
```
GET /enrollments/create
Route Name: enrollments.create
Controller: EnrollmentController@create
View: enrollments/create.blade.php
```

**Response:**
- HTML form with fields:
  - Student (dropdown, required)
  - Course (dropdown, required)
  - Enrollment Date (date input, required)

**Form Data:**
```php
$students = Student::all();  // All available students
$courses = Course::all();     // All available courses
```

---

### Create Enrollment
```
POST /enrollments
Route Name: enrollments.store
Controller: EnrollmentController@store
Accepts: Form data
Redirects: enrollments.index
```

**Request Body:**
```
{
  "student_id": 1,
  "course_id": 2,
  "enrollment_date": "2024-01-28"
}
```

**Validation Rules:**
```
student_id: required|exists:students,id
course_id: required|exists:courses,id
enrollment_date: required|date
```

**Additional Checks:**
- Prevents duplicate enrollments (student already enrolled in course)
- Returns error if duplicate found

**Success Response:**
- Redirect to `/enrollments`
- Flash message: "Enrollment created successfully."

**Error Response (Duplicate):**
- Redirect back with error message: "Student is already enrolled in this course."

**Example:**
```html
<form action="{{ route('enrollments.store') }}" method="POST">
  @csrf
  <select name="student_id" required>
    <option value="">-- Select Student --</option>
    @foreach($students as $student)
      <option value="{{ $student->id }}">
        {{ $student->student_no }} - {{ $student->name }}
      </option>
    @endforeach
  </select>
  
  <select name="course_id" required>
    <option value="">-- Select Course --</option>
    @foreach($courses as $course)
      <option value="{{ $course->id }}">
        {{ $course->course_name }}
      </option>
    @endforeach
  </select>
  
  <input type="date" name="enrollment_date" value="{{ date('Y-m-d') }}" required>
  <button type="submit">Create Enrollment</button>
</form>
```

---

### View Enrollment Details
```
GET /enrollments/{id}
Route Name: enrollments.show
Controller: EnrollmentController@show
View: enrollments/show.blade.php
Parameters:
  - id (int): Enrollment ID
```

**Response:**
- Enrollment information card:
  - Student info (name, number, email)
  - Course info (name, description)
  - Enrollment date
  - Enrollment creation timestamp
- Delete button

---

### Delete Enrollment
```
DELETE /enrollments/{id}
Route Name: enrollments.destroy
Controller: EnrollmentController@destroy
Parameters:
  - id (int): Enrollment ID
Accepts: Form submission with _method=DELETE
Redirects: enrollments.index
```

**Side Effects:**
- Deletes enrollment record
- Student is unenrolled from course

**Success Response:**
- Redirect to `/enrollments`
- Flash message: "Enrollment deleted successfully."

**Example:**
```html
<form action="{{ route('enrollments.destroy', $enrollment) }}" method="POST">
  @csrf
  @method('DELETE')
  <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
</form>
```

---

## 🔗 Route Summary Table

| Method | Route | Name | Controller Method |
|--------|-------|------|-------------------|
| GET | / | - | - |
| GET | /students | students.index | StudentController@index |
| GET | /students/create | students.create | StudentController@create |
| POST | /students | students.store | StudentController@store |
| GET | /students/{id} | students.show | StudentController@show |
| GET | /students/{id}/edit | students.edit | StudentController@edit |
| PUT | /students/{id} | students.update | StudentController@update |
| DELETE | /students/{id} | students.destroy | StudentController@destroy |
| GET | /courses | courses.index | CourseController@index |
| GET | /courses/create | courses.create | CourseController@create |
| POST | /courses | courses.store | CourseController@store |
| GET | /courses/{id} | courses.show | CourseController@show |
| GET | /courses/{id}/edit | courses.edit | CourseController@edit |
| PUT | /courses/{id} | courses.update | CourseController@update |
| DELETE | /courses/{id} | courses.destroy | CourseController@destroy |
| GET | /enrollments | enrollments.index | EnrollmentController@index |
| GET | /enrollments/create | enrollments.create | EnrollmentController@create |
| POST | /enrollments | enrollments.store | EnrollmentController@store |
| GET | /enrollments/{id} | enrollments.show | EnrollmentController@show |
| DELETE | /enrollments/{id} | enrollments.destroy | EnrollmentController@destroy |

---

## 📥 Request/Response Examples

### Example 1: Create Student

**Request:**
```
POST /students HTTP/1.1
Content-Type: application/x-www-form-urlencoded

student_no=STU001&name=John+Doe&email=john@example.com&_token=xyz...
```

**Response:**
```
HTTP/1.1 302 Found
Location: /students
Set-Cookie: XSRF-TOKEN=...

Success message: "Student created successfully."
```

---

### Example 2: View Student with Enrollments

**Request:**
```
GET /students/1 HTTP/1.1
```

**Response:**
```
HTTP/1.1 200 OK
Content-Type: text/html

<h1>John Doe</h1>
<p>Student Number: STU001</p>
<p>Email: john@example.com</p>

<h3>Enrolled Courses</h3>
<table>
  <tr>
    <td>Introduction to Laravel</td>
    <td>2024-01-28</td>
  </tr>
</table>
```

---

### Example 3: Create Enrollment (Duplicate Check)

**Request:**
```
POST /enrollments HTTP/1.1

student_id=1&course_id=1&enrollment_date=2024-01-28&_token=xyz...
```

**Response (if already enrolled):**
```
HTTP/1.1 302 Found
Location: /enrollments/create

Error message: "Student is already enrolled in this course."
```

---

## 🛡️ HTTP Methods Explanation

| Method | Purpose | Safe | Idempotent | Body |
|--------|---------|------|-----------|------|
| GET | Retrieve data | Yes | Yes | No |
| POST | Create data | No | No | Yes |
| PUT | Update data | No | Yes | Yes |
| DELETE | Delete data | No | Yes | No |

---

## 📝 Status Codes

| Code | Meaning | Example Scenario |
|------|---------|------------------|
| 200 | OK | Successfully retrieved page |
| 302 | Redirect | After successful form submission |
| 404 | Not Found | Invalid student/course ID |
| 422 | Unprocessable | Validation error |
| 500 | Server Error | Unexpected server error |

---

## 🔐 CSRF Protection

All POST, PUT, DELETE requests require CSRF token:

```blade
<form method="POST" action="/students">
    @csrf
    <!-- Token automatically included -->
</form>
```

Or in request:
```
X-CSRF-TOKEN: token_value
```

---

## 📧 Response Messages

### Success Messages
- "Student created successfully."
- "Student updated successfully."
- "Student deleted successfully."
- "Course created successfully."
- "Course updated successfully."
- "Course deleted successfully."
- "Enrollment created successfully."
- "Enrollment deleted successfully."

### Error Messages
- Validation error messages (displayed per field)
- "Student is already enrolled in this course."
- Any server error messages

---

## 🚀 Integration Examples

### Using cURL

```bash
# Create student
curl -X POST http://localhost:8000/students \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "student_no=STU001&name=John&email=john@example.com&_token=token"

# Get student
curl http://localhost:8000/students/1

# Delete student
curl -X DELETE http://localhost:8000/students/1 \
  -H "X-CSRF-TOKEN: token"
```

### Using JavaScript Fetch

```javascript
// Create student
fetch('/students', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded',
    'X-CSRF-TOKEN': document.querySelector('[name=_token]').value
  },
  body: 'student_no=STU001&name=John&email=john@example.com'
})
.then(response => response.text())
.then(data => console.log(data));
```

---

**End of API Reference**

For questions, see [CODE_EXPLANATION.md](CODE_EXPLANATION.md) or [QUICK_REFERENCE.md](QUICK_REFERENCE.md)
