<?php
/**
 * Courses Module
 */

function showCourses($pdo, $message = '', $message_type = '') {
    $courses = $pdo->query("SELECT * FROM courses ORDER BY created_at ASC")->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Courses</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body { background: #f8f9fa; }
            .navbar { background: linear-gradient(135deg, #1C352D 0%, #1C352D 100%) !important; }
            .navbar-brand { color: white !important; font-weight: bold; }
            .nav-link { color: rgba(255,255,255,0.9) !important; }
            .nav-link:hover { color: white !important; }
            .container { margin-top: 30px; }
            .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 2px solid #eee; padding-bottom: 20px; }
            .table { background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
            .table thead { background: linear-gradient(135deg, #1C352D 0%, #1C352D 100%); color: white; }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">🏫 Student Enrollment System</a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="/students">👨‍🎓 Students</a></li>
                        <!-- <li class="nav-item"><a class="nav-link" href="/courses">📖 Courses</a></li> -->
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
                <h1>Subjects</h1>
                <a href="/courses/create" class="btn btn-success btn-lg">Add New Subject</a>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (empty($courses)): ?>
                <div class="text-center">
                    <p><a href="/courses/create">Create the first subject</a></p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Subject Name</th>
                                <th>Description</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($courses as $course): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($course['course_name']); ?></strong></td>
                                <td><?php echo substr(htmlspecialchars($course['description'] ?? ''), 0, 50); ?></td>
                                <td><?php echo date('d M Y', strtotime($course['created_at'])); ?></td>
                                <td>
                                    <a href="/courses/<?php echo $course['id']; ?>" class="btn btn-sm btn-info">👁️</a>
                                    <a href="/courses/<?php echo $course['id']; ?>/edit" class="btn btn-sm btn-warning">✏️</a>
                                    <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                        <input type="hidden" name="action" value="delete_course">
                                        <input type="hidden" name="id" value="<?php echo $course['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-danger">🗑️</button>
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

function showCreateCourse($message = '', $message_type = '') {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create Subject</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body { background: #f8f9fa; }
            .navbar { background: linear-gradient(135deg, #1C352D 0%, #1C352D 100%) !important; }
            .navbar-brand { color: white !important; font-weight: bold; }
            .container { margin-top: 50px; }
            .form-card { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
            .form-card h2 { margin-bottom: 30px; color: #1C352D; }
            .form-control:focus { border-color: #1C352D; box-shadow: 0 0 0 0.2rem rgba(28, 53, 45, 0.25); }
            .btn-primary { background: linear-gradient(135deg, #B4DEBD 0%, #B4DEBD 100%); border: none; }
            .btn-secondary { background: #f08282; border: none; }
            .btn-secondary:hover { background: #f08282; }
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
                        <h2>Create New Subject</h2>
                        <?php if ($message): ?>
                            <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                                <?php echo $message; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        <form method="POST">
                            <input type="hidden" name="action" value="create_course">
                            <div class="mb-3">
                                <label class="form-label">Subject Name *</label>
                                <input type="text" class="form-control" name="course_name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="5"></textarea>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">✔️</button>
                                <a href="/courses" class="btn btn-secondary btn-lg">❌</a>
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

function showCourseDetail($pdo, $id) {
    $course = $pdo->prepare("SELECT * FROM courses WHERE id = ?");
    $course->execute([$id]);
    $result = $course->fetch(PDO::FETCH_ASSOC);
    
    if (!$result) {
        return false;
    }
    
    $students = $pdo->prepare("SELECT s.*, e.enrollment_date FROM enrollments e JOIN students s ON e.student_id = s.id WHERE e.course_id = ?");
    $students->execute([$id]);
    $enrolled_students = $students->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo htmlspecialchars($result['course_name']); ?> - Subject Details</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body { background: #f8f9fa; }
            .navbar { background: linear-gradient(135deg, #1C352D 0%, #1C352D 100%) !important; }
            .navbar-brand { color: white !important; font-weight: bold; }
            .nav-link { color: rgba(255,255,255,0.9) !important; }
            .container { margin-top: 30px; }
            .detail-card { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 30px; }
            .table { background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
            .table thead { background: linear-gradient(135deg, #1C352D 0%, #1C352D 100%); color: white; }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">📚 Student Enrollment System</a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="/courses">📖 Subjects</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <a href="/courses" class="btn btn-secondary mb-3">←</a>
            
            <div class="detail-card">
                <h2><?php echo htmlspecialchars($result['course_name']); ?></h2>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Description:</strong></p>
                        <p><?php echo htmlspecialchars($result['description'] ?? 'N/A'); ?></p>
                        <p><strong>Created:</strong> <?php echo date('d M Y H:i', strtotime($result['created_at'])); ?></p>
                    </div>
                </div>
            </div>

            <h3>Enrolled Students</h3>
            <?php if (empty($enrolled_students)): ?>
                <div class="alert alert-info">No students enrolled in this subject yet.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Student Number</th>
                                <th>Name</th>
                                <th>Enrollment Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($enrolled_students as $student): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($student['student_no']); ?></td>
                                <td><?php echo htmlspecialchars($student['name']); ?></td>
                                <td><?php echo date('d M Y', strtotime($student['enrollment_date'])); ?></td>
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

function showEditCourse($pdo, $id, $message = '', $message_type = '') {
    $course = $pdo->prepare("SELECT * FROM courses WHERE id = ?");
    $course->execute([$id]);
    $result = $course->fetch(PDO::FETCH_ASSOC);
    
    if (!$result) {
        return false;
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Subject</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body { background: #f8f9fa; }
            .navbar { background: linear-gradient(135deg, #1C352D 0%, #1C352D 100%) !important; }
            .navbar-brand { color: white !important; font-weight: bold; }
            .container { margin-top: 50px; }
            .form-card { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
            .form-card h2 { margin-bottom: 30px; color: #1C352D; }
            .form-control:focus { border-color: #1C352D; box-shadow: 0 0 0 0.2rem rgba(28, 53, 45, 0.25); }
            .btn-primary { background: linear-gradient(135deg, #B4DEBD 0%, #B4DEBD 100%); border: none; }
            .btn-secondary { background: #f08282; border: none; }
            .btn-secondary:hover { background: #f08282; }
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
                        <h2>Edit Subject</h2>
                        <?php if ($message): ?>
                            <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                                <?php echo $message; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        <form method="POST">
                            <input type="hidden" name="action" value="update_course">
                            <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                            <div class="mb-3">
                                <label class="form-label">Subject Name *</label>
                                <input type="text" class="form-control" name="course_name" value="<?php echo htmlspecialchars($result['course_name']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="5"><?php echo htmlspecialchars($result['description'] ?? ''); ?></textarea>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">✔️</button>
                                <a href="/courses/<?php echo $result['id']; ?>" class="btn btn-secondary btn-lg">❌</a>
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
