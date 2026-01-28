<?php
/**
 * Authentication Module
 */

// Default credentials
$DEFAULT_USERNAME = 'Jhared';
$DEFAULT_PASSWORD = 'qwerty098';

function showLogin($error = '') {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - Student Enrollment System</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body { 
                background: linear-gradient(135deg, #1b3d24 0%, #1b3d24 100%); 
                min-height: 100vh; 
                display: flex; 
                align-items: center; 
                justify-content: center;
            }
            .login-container {
                width: 100%;
                max-width: 400px;
            }
            .login-card {
                background: white;
                border-radius: 15px;
                box-shadow: 0 10px 40px rgba(0,0,0,0.3);
                padding: 40px;
            }
            .login-card h1 {
                color: #1b3d24;
                font-weight: bold;
                margin-bottom: 10px;
                text-align: center;
            }
            .login-card p {
                text-align: center;
                color: #666;
                margin-bottom: 30px;
                font-size: 0.9em;
            }
            .form-control {
                border-radius: 8px;
                padding: 12px 15px;
                border: 2px solid #eee;
                margin-bottom: 20px;
            }
            .form-control:focus {
                border-color: #1b3d24;
                box-shadow: 0 0 0 0.2rem rgba(64, 192, 132, 0.3);
            }
            .btn-login {
                background: linear-gradient(135deg, #1b3d24 0%, #1b3d24 100%);
                border: none;
                padding: 12px;
                font-weight: bold;
                border-radius: 8px;
                color: white;
                width: 100%;
                font-size: 1.1em;
            }
            .btn-login:hover {
                background: linear-gradient(135deg, #1b3d24 0%, #1b3d24 100%);
                color: white;
            }
            .credentials-info {
                background: #f8f9fa;
                padding: 15px;
                border-radius: 8px;
                margin-top: 30px;
                border-left: 4px solid #667eea;
            }
            .credentials-info p {
                margin: 5px 0;
                color: #333;
                font-size: 0.9em;
            }
            .credentials-info strong {
                color: #667eea;
            }
        </style>
    </head>
    <body>
        <div class="login-container">
            <div class="login-card">
                <h1>📚 Enrollment System</h1>
                <p>Student Management Platform</p>
                
                <?php if ($error): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <input type="hidden" name="action" value="login">
                    <div class="mb-3">
                        <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-login">Login</button>
                </form>

                <!-- <div class="credentials-info">
                    <p><strong>Demo Credentials:</strong></p>
                    <p>Username: <strong>Jhared</strong></p>
                    <p>Password: <strong>qwerty098</strong></p>
                </div> -->
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    <?php
}
