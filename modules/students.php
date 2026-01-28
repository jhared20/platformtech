<?php
/**
 * Students Module
 */

function showStudents($pdo, $message = '', $message_type = '') {
    $students = $pdo->query("SELECT * FROM students ORDER BY created_at ASC")->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Students</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body { background: #f8f9fa; }
            .navbar { background: linear-gradient(135deg, #064232 0%, #064232 100%) !important; }
            .navbar-brand { color: white !important; font-weight: bold; }
            .nav-link { color: rgba(255,255,255,0.9) !important; }
            .nav-link:hover { color: white !important; }
            .container { margin-top: 30px; }
            .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 2px solid #eee; padding-bottom: 20px; }
            .table { background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
            .table thead { background: linear-gradient(135deg, #064232 0%, #064232 100%); color: white; }
            .btn-sm { margin-right: 5px; }
            .empty-state { text-align: center; padding: 60px 20px; }
            .empty-state p { font-size: 1.1em; color: #666; }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">🏫 Student Enrollment System</a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto">
                        <!-- <li class="nav-item"><a class="nav-link" href="/students">👨‍🎓 Students</a></li> -->
                        <li class="nav-item"><a class="nav-link" href="/courses">📖 Subjects</a></li>
                        <li class="nav-item"><a class="nav-link" href="/enrollments">✅ Enrollments</a></li>
                        <li class="nav-item">
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="logout">
                                <button type="submit" class="btn btn-sm btn-light ms-2">🚪 Log out (<?php echo htmlspecialchars($_SESSION['username']); ?>)</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="page-header">
                <h1>Students</h1>
                <a href="/students/create" class="btn btn-success btn-lg">➕ Add New Student</a>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (empty($students)): ?>
                <div class="empty-state">
                    <h3>No students found</h3>
                    <p><a href="/students/create">Create the first student</a></p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Student No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($students as $student): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($student['student_no']); ?></strong></td>
                                <td><?php echo htmlspecialchars($student['name']); ?></td>
                                <td><?php echo htmlspecialchars($student['email']); ?></td>
                                <td><?php echo date('d M Y', strtotime($student['created_at'])); ?></td>
                                <td>
                                    <a href="/students/<?php echo $student['id']; ?>" class="btn btn-sm btn-info">👁️ View</a>
                                    <a href="/students/<?php echo $student['id']; ?>/edit" class="btn btn-sm btn-warning">✏️ Edit</a>
                                    <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                        <input type="hidden" name="action" value="delete_student">
                                        <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-danger">🗑️ Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    <?php
}

function showCreateStudent($message = '', $message_type = '') {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create Student</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body { background: #f8f9fa; }
            .navbar { background: linear-gradient(135deg, #064232 0%, #064232 100%) !important; }
            .navbar-brand { color: white !important; font-weight: bold; }
            .container { margin-top: 50px; }
            .form-card { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
            .form-card h2 { margin-bottom: 30px; color: #064232; }
            .form-control:focus { border-color: #064232; box-shadow: 0 0 0 0.2rem rgba(6, 66, 50, 0.25); }
            .btn-primary { background: linear-gradient(135deg, #1F4529 0%, #1F4529 100%); border: none; }
            .btn-secondary { background: #ff0808; border: none; }
            .btn-secondary:hover { background: #ff0808; }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">📚 Student Enrollment System</a>
            </div>
        </nav>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="form-card">
                        <h2>Create New Student</h2>
                        <?php if ($message): ?>
                            <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                                <?php echo $message; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        <form method="POST">
                            <input type="hidden" name="action" value="create_student">
                            <div class="mb-3">
                                <label class="form-label">Student Number *</label>
                                <input type="text" class="form-control" name="student_no" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Name *</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">✅ Create Student</button>
                                <a href="/students" class="btn btn-secondary btn-lg">❌ Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    <?php
}

function showStudentDetail($pdo, $id) {
    $student = $pdo->prepare("SELECT * FROM students WHERE id = ?");
    $student->execute([$id]);
    $result = $student->fetch(PDO::FETCH_ASSOC);
    
    if (!$result) {
        return false;
    }
    
    $enrollments = $pdo->prepare("SELECT c.*, e.enrollment_date FROM enrollments e JOIN courses c ON e.course_id = c.id WHERE e.student_id = ?");
    $enrollments->execute([$id]);
    $courses = $enrollments->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo htmlspecialchars($result['name']); ?> - Student Details</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body { background: #f8f9fa; }
            .navbar { background: linear-gradient(135deg, #064232 0%, #064232 100%) !important; }
            .navbar-brand { color: white !important; font-weight: bold; }
            .nav-link { color: rgba(255,255,255,0.9) !important; }
            .container { margin-top: 30px; }
            .detail-card { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 30px; }
            .table { background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
            .table thead { background: linear-gradient(135deg, #064232 0%, #064232 100%); color: white; }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">📚 Student Enrollment System</a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="/students">👨‍🎓 Students</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <a href="/students" class="btn btn-secondary mb-3">← Back to Students</a>
            
            <div class="detail-card">
                <h2><?php echo htmlspecialchars($result['name']); ?></h2>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Student Number:</strong> <?php echo htmlspecialchars($result['student_no']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($result['email']); ?></p>
                        <p><strong>Created:</strong> <?php echo date('d M Y H:i', strtotime($result['created_at'])); ?></p>
                    </div>
                </div>
            </div>

            <h3>Enrolled Courses</h3>
            <?php if (empty($courses)): ?>
                <div class="alert alert-info">No courses enrolled yet.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Course Name</th>
                                <th>Enrollment Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($courses as $course): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                                <td><?php echo date('d M Y', strtotime($course['enrollment_date'])); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    <?php
}

function showEditStudent($pdo, $id, $message = '', $message_type = '') {
    $student = $pdo->prepare("SELECT * FROM students WHERE id = ?");
    $student->execute([$id]);
    $result = $student->fetch(PDO::FETCH_ASSOC);
    
    if (!$result) {
        return false;
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Student</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body { background: #f8f9fa; }
            .navbar { background: linear-gradient(135deg, #064232 0%, #064232 100%) !important; }
            .navbar-brand { color: white !important; font-weight: bold; }
            .container { margin-top: 50px; }
            .form-card { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
            .form-card h2 { margin-bottom: 30px; color: #064232; }
            .form-control:focus { border-color: #064232; box-shadow: 0 0 0 0.2rem rgba(6, 66, 50, 0.25); }
            .btn-primary { background: linear-gradient(135deg, #1F4529 0%, #1F4529 100%); border: none; }
            .btn-secondary { background: #ff0808; border: none; }
            .btn-secondary:hover { background: #ff0808; }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">📚 Student Enrollment System</a>
            </div>
        </nav>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="form-card">
                        <h2>Edit Student</h2>
                        <?php if ($message): ?>
                            <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                                <?php echo $message; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        <form method="POST">
                            <input type="hidden" name="action" value="update_student">
                            <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                            <div class="mb-3">
                                <label class="form-label">Student Number *</label>
                                <input type="text" class="form-control" name="student_no" value="<?php echo htmlspecialchars($result['student_no']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Name *</label>
                                <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($result['name']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($result['email']); ?>" required>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">✅ Update Student</button>
                                <a href="/students/<?php echo $result['id']; ?>" class="btn btn-secondary btn-lg">❌ Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    <?php
}
