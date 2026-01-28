<?php
/**
 * Dashboard Module
 */

function showDashboard() {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Student Enrollment System</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body { background: linear-gradient(135deg, #1b3d24 0%, #1b3d24 100%); min-height: 100vh; display: flex; flex-direction: column; }
            .navbar { background: rgba(255,255,255,0.1) !important; backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255, 255, 255, 0.2); }
            .navbar-brand { font-weight: bold; font-size: 1.5em; color: white !important; }
            .nav-link { color: rgba(255,255,255,0.9) !important; }
            .nav-link:hover { color: white !important; }
            .hero { flex: 1; display: flex; align-items: center; justify-content: center; color: white; text-align: center; padding: 40px; }
            .hero h1 { font-size: 3.5em; font-weight: bold; margin-bottom: 20px; text-shadow: 2px 2px 4px rgba(64, 192, 132, 0.3); }
            .hero p { font-size: 1.3em; margin-bottom: 40px; opacity: 0.95; }
            .card { background: white; border-radius: 15px; border: none; box-shadow: 0 10px 30px rgba(64, 192, 132, 0.3); transition: transform 0.3s, box-shadow 0.3s; }
            .card:hover { transform: translateY(-10px); box-shadow: 0 15px 40px rgba(64, 192, 132, 0.3); }
            .card-body { padding: 30px; text-align: center; }
            .card h5 { font-size: 1.5em; margin-bottom: 15px; color: #41644A; }
            .card p { color: #666; margin-bottom: 20px; }
            .btn-primary { background: linear-gradient(135deg, #1b3d24 0%, #1b3d24 100%); border: none; padding: 10px 30px; font-weight: bold; }
            .btn-primary:hover { background: linear-gradient(135deg, #1b3d24 0%, #1b3d24 100%); transform: scale(1.05); }
            .cards-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px; margin-top: 40px; }
            .icon { font-size: 3em; margin-bottom: 15px; }
        </style>
    </head>
    <body>
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">📚 Student Enrollment System</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="/students">👨‍🎓 Students</a></li>
                        <li class="nav-item"><a class="nav-link" href="/courses">📖 Courses</a></li>
                        <li class="nav-item"><a class="nav-link" href="/enrollments">✅ Enrollments</a></li>
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

        <!-- Hero Section -->
        <div class="hero">
            <div>
                <h1>Welcome to Student Enrollment System</h1>
                <p>Manage students, courses, and enrollments with ease</p>
                
                <div class="cards-grid">
                    <div class="card">
                        <div class="card-body">
                            <div class="icon">👨‍🎓</div>
                            <h5>Students</h5>
                            <p>Manage student information and track their enrollments</p>
                            <a href="/students" class="btn btn-primary">View Students</a>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-body">
                            <div class="icon">📖</div>
                            <h5>Courses</h5>
                            <p>Create and manage course information</p>
                            <a href="/courses" class="btn btn-primary">View Courses</a>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-body">
                            <div class="icon">✅</div>
                            <h5>Enrollments</h5>
                            <p>Manage student course enrollments</p>
                            <a href="/enrollments" class="btn btn-primary">View Enrollments</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    <?php
}

function show404() {
    http_response_code(404);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>404 - Not Found</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body { background: #f8f9fa; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
            .error-container { text-align: center; }
            h1 { font-size: 5em; color: #667eea; }
        </style>
    </head>
    <body>
        <div class="error-container">
            <h1>404</h1>
            <h2>Page Not Found</h2>
            <p><a href="/" class="btn btn-primary btn-lg">← Go to Home</a></p>
        </div>
    </body>
    </html>
    <?php
}
