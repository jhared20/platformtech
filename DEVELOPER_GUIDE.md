# Developer Guide - Modular Architecture

## Quick Start for Developers

### Understanding the Structure

Your application now follows a **modular MVC-like architecture**:

```
index.php (Router/Controller)
    ↓
    Includes: config/db.php, modules/*.php
    ↓
Routes requests to appropriate module
    ↓
modules/*.php (Views + Database calls)
    ↓
Renders HTML response
```

### The Four Layers

1. **Routing** (index.php)
   - Parse URL → Determine which page
   - Check authentication
   - Route to module

2. **Database** (config/db.php)
   - PDO connection
   - Available to all modules via `$pdo`

3. **Form Processing** (index.php)
   - Handle POST requests
   - Execute database operations
   - Redirect with success/error message

4. **Views** (modules/*.php)
   - Render HTML
   - Display data
   - Embed Bootstrap styling

---

## Adding a New Feature

### Example: Add "Reports" Section

#### Step 1: Create Module File
Create `modules/reports.php`:

```php
<?php
/**
 * Reports Module
 */

function showReports($pdo, $message = '', $message_type = '') {
    // Get data from database
    $stats = $pdo->query("SELECT COUNT(*) as total_students FROM students")->fetch();
    
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Reports</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important; }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">📊 Reports</a>
            </div>
        </nav>
        
        <div class="container mt-5">
            <h1>System Reports</h1>
            <p>Total Students: <?php echo $stats['total_students']; ?></p>
        </div>
    </body>
    </html>
    <?php
}
```

#### Step 2: Update index.php
Add to the include section:
```php
require_once 'modules/reports.php';
```

Add to the switch statement:
```php
case '/reports':
    showReports($pdo, $message, $message_type);
    break;
```

#### Step 3: Done!
Now `/reports` is accessible and fully integrated.

---

## Working with Forms

### Understanding the Form Flow

```
User fills form in module view
        ↓
Submits POST to index.php
        ↓
Form includes: <input type="hidden" name="action" value="create_student">
        ↓
index.php checks: if ($_POST['action'] === 'create_student')
        ↓
Executes database operation
        ↓
Redirects with: header('Location: /students?success=Student created')
        ↓
Module renders with success message displayed
```

### Creating a Form

In module file (e.g., `modules/students.php`):

```php
<form method="POST">
    <!-- Must include action -->
    <input type="hidden" name="action" value="create_student">
    
    <!-- Form fields -->
    <div class="mb-3">
        <label class="form-label">Student Number</label>
        <input type="text" class="form-control" name="student_no" required>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" class="form-control" name="name" required>
    </div>
    
    <button type="submit">Create Student</button>
</form>
```

### Creating the Handler

In `index.php`:

```php
elseif (isset($_POST['action']) && $_POST['action'] === 'create_student') {
    try {
        // Validate input
        if (empty($_POST['student_no']) || empty($_POST['name'])) {
            $message = 'All fields are required';
            $message_type = 'danger';
        } else {
            // Execute database operation
            $stmt = $pdo->prepare("INSERT INTO students (student_no, name, email) VALUES (?, ?, ?)");
            $stmt->execute([$_POST['student_no'], $_POST['name'], $_POST['email']]);
            
            // Redirect with success message
            header('Location: /students?success=Student created successfully');
            exit;
        }
    } catch (PDOException $e) {
        $message = 'Error: ' . $e->getMessage();
        $message_type = 'danger';
    }
}
```

---

## Database Operations

### SELECT (Read)
```php
// Single record
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

// Multiple records
$result = $pdo->query("SELECT * FROM students ORDER BY name");
$students = $result->fetchAll(PDO::FETCH_ASSOC);

// Usage in view
foreach ($students as $student) {
    echo $student['name'];
}
```

### INSERT (Create)
```php
$stmt = $pdo->prepare("INSERT INTO students (student_no, name, email) VALUES (?, ?, ?)");
$stmt->execute([$student_no, $name, $email]);
```

### UPDATE (Modify)
```php
$stmt = $pdo->prepare("UPDATE students SET name = ?, email = ? WHERE id = ?");
$stmt->execute([$name, $email, $id]);
```

### DELETE (Remove)
```php
$stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
$stmt->execute([$id]);
```

---

## Security Best Practices

### 1. Always Use Prepared Statements
```php
// Good ✅
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);

// Bad ❌
$result = $pdo->query("SELECT * FROM students WHERE id = $id");
```

### 2. Always Escape Output
```php
// Good ✅
<?php echo htmlspecialchars($user_data); ?>

// Bad ❌
<?php echo $user_data; ?>
```

### 3. Validate Input
```php
// Good ✅
if (!empty($_POST['name']) && strlen($_POST['name']) > 0) {
    // Process
}

// Bad ❌
$name = $_POST['name']; // Could be anything
```

### 4. Use Sessions for Authentication
```php
// Check login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: /login');
    exit;
}

// Get username
$username = $_SESSION['username'];
```

---

## Common Patterns

### List with Actions
```php
function showStudents($pdo, $message = '', $message_type = '') {
    // Fetch data
    $students = $pdo->query("SELECT * FROM students")->fetchAll(PDO::FETCH_ASSOC);
    
    // Render table with actions
    foreach ($students as $student) {
        echo '<tr>
            <td>' . htmlspecialchars($student['name']) . '</td>
            <td>
                <a href="/students/' . $student['id'] . '">View</a>
                <a href="/students/' . $student['id'] . '/edit">Edit</a>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="action" value="delete_student">
                    <input type="hidden" name="id" value="' . $student['id'] . '">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>';
    }
}
```

### Detail View
```php
function showStudentDetail($pdo, $id) {
    // Fetch single record
    $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->execute([$id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Check if exists
    if (!$student) {
        show404();
        return;
    }
    
    // Display details
    echo '<h2>' . htmlspecialchars($student['name']) . '</h2>';
    echo '<p>Email: ' . htmlspecialchars($student['email']) . '</p>';
}
```

### Edit Form
```php
function showEditStudent($pdo, $id, $message = '', $message_type = '') {
    // Fetch current data
    $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->execute([$id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$student) {
        show404();
        return;
    }
    
    // Display form with current values
    ?>
    <form method="POST">
        <input type="hidden" name="action" value="update_student">
        <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
        
        <input type="text" name="name" value="<?php echo htmlspecialchars($student['name']); ?>">
        <input type="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>">
        
        <button type="submit">Update</button>
    </form>
    <?php
}
```

---

## Debugging Tips

### See What's Being Submitted
```php
// At top of index.php
if ($method === 'POST') {
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
    exit;
}
```

### Check Database Query
```php
$students = $pdo->query("SELECT * FROM students");
echo "Rows: " . $students->rowCount(); // How many returned?
```

### View Database Error
```php
try {
    // database operation
} catch (PDOException $e) {
    echo $e->getMessage(); // Shows actual error
}
```

### Check Session Data
```php
echo '<pre>';
print_r($_SESSION);
echo '</pre>';
```

---

## Performance Optimization

### Cache Database Queries
```php
// For frequently accessed data
$cache_key = 'all_courses';
$courses = apcu_fetch($cache_key);

if ($courses === false) {
    $courses = $pdo->query("SELECT * FROM courses")->fetchAll();
    apcu_store($cache_key, $courses, 3600); // 1 hour
}
```

### Optimize Database Queries
```php
// Bad - N+1 problem
foreach ($students as $student) {
    $courses = $pdo->query("SELECT * FROM courses WHERE ... WHERE student_id = {$student['id']}")->fetchAll();
}

// Good - Single query with JOIN
$result = $pdo->query("
    SELECT s.*, c.course_name
    FROM students s
    LEFT JOIN enrollments e ON s.id = e.student_id
    LEFT JOIN courses c ON e.course_id = c.id
");
```

### Use Indexes
```sql
-- Add indexes for frequently queried columns
CREATE INDEX idx_student_no ON students(student_no);
CREATE INDEX idx_student_id ON enrollments(student_id);
CREATE INDEX idx_course_id ON enrollments(course_id);
```

---

## Testing Checklist

Before deploying changes:

- [ ] All forms submit correctly
- [ ] Create operations work
- [ ] Read operations display correct data
- [ ] Update operations save changes
- [ ] Delete operations remove data and handle cascades
- [ ] Error messages display properly
- [ ] Success messages display properly
- [ ] Navigation works on all pages
- [ ] Logout works and clears session
- [ ] Login redirects unauthenticated users
- [ ] Database connections are stable
- [ ] No SQL injection vulnerabilities
- [ ] All user input is escaped

---

## Deployment Checklist

- [ ] Set `php.ini` error reporting to production level
- [ ] Set database credentials securely
- [ ] Enable HTTPS
- [ ] Set secure session cookies
- [ ] Enable database backups
- [ ] Monitor error logs
- [ ] Set up performance monitoring
- [ ] Test all functionality in production environment

---

## Resources

- **PHP PDO:** https://www.php.net/manual/en/book.pdo.php
- **Bootstrap 5:** https://getbootstrap.com/docs/5.3
- **PHP Security:** https://www.php.net/manual/en/security.php

---

## Questions?

Common issues and solutions:

**Q: How do I add a new database table?**
A: Create table in MySQL, then write handlers in index.php and views in a new module file.

**Q: How do I modify the styling?**
A: Edit the `<style>` sections in the module files, or update Bootstrap classes.

**Q: How do I add validation?**
A: Add checks in the handler before database operation in index.php.

**Q: How do I export data?**
A: Create a new route that renders CSV/PDF instead of HTML.

**Q: How do I add an API?**
A: Create `api.php` that returns JSON instead of HTML, using same database logic.

---

**Last Updated:** January 28, 2026
**Version:** 2.0 (Modular)
**Status:** Production Ready
