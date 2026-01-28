<?php
/**
 * Enrollments Module
 */

function showEnrollments($pdo, $message = '', $message_type = '') {
    $enrollments = $pdo->query("SELECT e.*, s.name as student_name, s.student_no, c.course_name FROM enrollments e JOIN students s ON e.student_id = s.id JOIN courses c ON e.course_id = c.id ORDER BY e.enrollment_date DESC")->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Enrollments</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body { background: #f8f9fa; }
            .navbar { background: linear-gradient(135deg, #1b3d24 0%, #1b3d24 100%) !important; }
            .navbar-brand { color: white !important; font-weight: bold; }
            .nav-link { color: rgba(255,255,255,0.9) !important; }
            .nav-link:hover { color: white !important; }
            .container { margin-top: 30px; }
            .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 2px solid #eee; padding-bottom: 20px; }
            .table { background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
            .table thead { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">📚 Student Enrollment System</a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="/students">👨‍🎓 Students</a></li>
                        <li class="nav-item"><a class="nav-link" href="/courses">📖 Courses</a></li>
                        <!-- <li class="nav-item"><a class="nav-link" href="/enrollments">✅ Enrollments</a></li> -->
                        <li class="nav-item">
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="logout">
                                <button type="submit" class="btn btn-sm btn-light ms-2">🚪 Logout (<?php echo htmlspecialchars($_SESSION['username']); ?>)</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="page-header">
                <h1>Enrollments</h1>
                <a href="/enrollments/create" class="btn btn-success btn-lg">➕ Create Enrollment</a>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (empty($enrollments)): ?>
                <div class="text-center">
                    <p><a href="/enrollments/create">Create the first enrollment</a></p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Course</th>
                                <th>Enrollment Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($enrollments as $enrollment): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($enrollment['student_name']); ?></strong> <span class="text-muted">(<?php echo htmlspecialchars($enrollment['student_no']); ?>)</span></td>
                                <td><?php echo htmlspecialchars($enrollment['course_name']); ?></td>
                                <td><?php echo date('d M Y', strtotime($enrollment['enrollment_date'])); ?></td>
                                <td>
                                    <a href="/enrollments/<?php echo $enrollment['id']; ?>" class="btn btn-sm btn-info">👁️ View</a>
                                    <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                        <input type="hidden" name="action" value="delete_enrollment">
                                        <input type="hidden" name="id" value="<?php echo $enrollment['id']; ?>">
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

function showCreateEnrollment($pdo, $message = '', $message_type = '') {
    $students = $pdo->query("SELECT * FROM students ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
    $courses = $pdo->query("SELECT * FROM courses ORDER BY course_name")->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create Enrollment</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body { background: #f8f9fa; }
            .navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important; }
            .navbar-brand { color: white !important; font-weight: bold; }
            .container { margin-top: 50px; }
            .form-card { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
            .form-card h2 { margin-bottom: 30px; color: #667eea; }
            .form-control:focus { border-color: #667eea; box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25); }
            .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; }
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
                        <h2>Create New Enrollment</h2>
                        <?php if ($message): ?>
                            <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                                <?php echo $message; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        <form method="POST">
                            <input type="hidden" name="action" value="create_enrollment">
                            <div class="mb-3">
                                <label class="form-label">Student *</label>
                                <select class="form-control" name="student_id" required>
                                    <option value="">-- Select a student --</option>
                                    <?php foreach ($students as $student): ?>
                                    <option value="<?php echo $student['id']; ?>"><?php echo htmlspecialchars($student['name']); ?> (<?php echo htmlspecialchars($student['student_no']); ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Course *</label>
                                <select class="form-control" name="course_id" required>
                                    <option value="">-- Select a course --</option>
                                    <?php foreach ($courses as $course): ?>
                                    <option value="<?php echo $course['id']; ?>"><?php echo htmlspecialchars($course['course_name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Enrollment Date</label>
                                <input type="date" class="form-control" name="enrollment_date" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">✅ Create Enrollment</button>
                                <a href="/enrollments" class="btn btn-secondary btn-lg">❌ Cancel</a>
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

function showEnrollmentDetail($pdo, $id) {
    $enrollment = $pdo->prepare("SELECT e.*, s.name as student_name, s.student_no, c.course_name FROM enrollments e JOIN students s ON e.student_id = s.id JOIN courses c ON e.course_id = c.id WHERE e.id = ?");
    $enrollment->execute([$id]);
    $result = $enrollment->fetch(PDO::FETCH_ASSOC);
    
    if (!$result) {
        return false;
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Enrollment Details</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body { background: #f8f9fa; }
            .navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important; }
            .navbar-brand { color: white !important; font-weight: bold; }
            .nav-link { color: rgba(255,255,255,0.9) !important; }
            .container { margin-top: 30px; }
            .detail-card { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 30px; }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">📚 Student Enrollment System</a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="/enrollments">✅ Enrollments</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <a href="/enrollments" class="btn btn-secondary mb-3">← Back to Enrollments</a>
            
            <div class="detail-card">
                <h2>Enrollment Details</h2>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Student:</strong> <?php echo htmlspecialchars($result['student_name']); ?></p>
                        <p><strong>Student Number:</strong> <?php echo htmlspecialchars($result['student_no']); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Course:</strong> <?php echo htmlspecialchars($result['course_name']); ?></p>
                        <p><strong>Enrollment Date:</strong> <?php echo date('d M Y', strtotime($result['enrollment_date'])); ?></p>
                    </div>
                </div>
                <hr>
                <a href="/enrollments" class="btn btn-secondary">Back</a>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    <?php
}
