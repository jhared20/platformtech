<?php
/**
 * Student Enrollment System - Modular Router & Controller
 */

session_start();

require_once 'config/db.php';
require_once 'modules/auth.php';
require_once 'modules/dashboard.php';
require_once 'modules/students.php';
require_once 'modules/courses.php';
require_once 'modules/enrollments.php';

$DEFAULT_USERNAME = 'Jhared';
$DEFAULT_PASSWORD = 'qwerty098';

$request_uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$path = parse_url($request_uri, PHP_URL_PATH);
$path = str_replace('/platform', '', $path);
$path = ($path === '' || $path === '/') ? '/' : rtrim($path, '/');

$message = '';
$message_type = '';

if ($method === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'create_student') {
        try {
            $stmt = $pdo->prepare("INSERT INTO students (student_no, name, email) VALUES (?, ?, ?)");
            $stmt->execute([$_POST['student_no'], $_POST['name'], $_POST['email']]);
            header('Location: /students?success=Student created successfully');
            exit;
        } catch (PDOException $e) {
            $message = 'Error: ' . $e->getMessage();
            $message_type = 'danger';
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'update_student') {
        try {
            $stmt = $pdo->prepare("UPDATE students SET student_no = ?, name = ?, email = ? WHERE id = ?");
            $stmt->execute([$_POST['student_no'], $_POST['name'], $_POST['email'], $_POST['id']]);
            header('Location: /students?success=Student updated successfully');
            exit;
        } catch (PDOException $e) {
            $message = 'Error: ' . $e->getMessage();
            $message_type = 'danger';
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'delete_student') {
        try {
            $stmt = $pdo->prepare("DELETE FROM enrollments WHERE student_id = ?");
            $stmt->execute([$_POST['id']]);
            $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
            $stmt->execute([$_POST['id']]);
            header('Location: /students?success=Student deleted successfully');
            exit;
        } catch (PDOException $e) {
            $message = 'Error: ' . $e->getMessage();
            $message_type = 'danger';
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'create_course') {
        try {
            $stmt = $pdo->prepare("INSERT INTO courses (course_name, description) VALUES (?, ?)");
            $stmt->execute([$_POST['course_name'], $_POST['description']]);
            header('Location: /courses?success=Course created successfully');
            exit;
        } catch (PDOException $e) {
            $message = 'Error: ' . $e->getMessage();
            $message_type = 'danger';
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'update_course') {
        try {
            $stmt = $pdo->prepare("UPDATE courses SET course_name = ?, description = ? WHERE id = ?");
            $stmt->execute([$_POST['course_name'], $_POST['description'], $_POST['id']]);
            header('Location: /courses?success=Course updated successfully');
            exit;
        } catch (PDOException $e) {
            $message = 'Error: ' . $e->getMessage();
            $message_type = 'danger';
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'delete_course') {
        try {
            $stmt = $pdo->prepare("DELETE FROM enrollments WHERE course_id = ?");
            $stmt->execute([$_POST['id']]);
            $stmt = $pdo->prepare("DELETE FROM courses WHERE id = ?");
            $stmt->execute([$_POST['id']]);
            header('Location: /courses?success=Course deleted successfully');
            exit;
        } catch (PDOException $e) {
            $message = 'Error: ' . $e->getMessage();
            $message_type = 'danger';
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'create_enrollment') {
        try {
            $stmt = $pdo->prepare("INSERT INTO enrollments (student_id, course_id, enrollment_date) VALUES (?, ?, ?)");
            $stmt->execute([$_POST['student_id'], $_POST['course_id'], $_POST['enrollment_date']]);
            header('Location: /enrollments?success=Enrollment created successfully');
            exit;
        } catch (PDOException $e) {
            $message = 'Error: ' . $e->getMessage();
            $message_type = 'danger';
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'delete_enrollment') {
        try {
            $stmt = $pdo->prepare("DELETE FROM enrollments WHERE id = ?");
            $stmt->execute([$_POST['id']]);
            header('Location: /enrollments?success=Enrollment deleted successfully');
            exit;
        } catch (PDOException $e) {
            $message = 'Error: ' . $e->getMessage();
            $message_type = 'danger';
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'login') {
        if ($_POST['username'] === $DEFAULT_USERNAME && $_POST['password'] === $DEFAULT_PASSWORD) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $_POST['username'];
            header('Location: /');
            exit;
        } else {
            $_SESSION['login_error'] = 'Invalid username or password';
            header('Location: /login');
            exit;
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'logout') {
        session_destroy();
        header('Location: /login');
        exit;
    }
}

$is_logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$login_error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : '';
if (isset($_SESSION['login_error'])) {
    unset($_SESSION['login_error']);
}

if (isset($_GET['success'])) {
    $message = htmlspecialchars($_GET['success']);
    $message_type = 'success';
}

if ($path === '/login') {
    showLogin($login_error);
    exit;
} elseif (!$is_logged_in) {
    header('Location: /login');
    exit;
}

switch ($path) {
    case '/':
        showDashboard();
        break;
    case '/students':
        showStudents($pdo, $message, $message_type);
        break;
    case '/students/create':
        showCreateStudent($message, $message_type);
        break;
    case '/courses':
        showCourses($pdo, $message, $message_type);
        break;
    case '/courses/create':
        showCreateCourse($message, $message_type);
        break;
    case '/enrollments':
        showEnrollments($pdo, $message, $message_type);
        break;
    case '/enrollments/create':
        showCreateEnrollment($pdo, $message, $message_type);
        break;
    default:
        if (preg_match('/^\/students\/(\d+)\/edit$/', $path, $matches)) {
            showEditStudent($pdo, $matches[1], $message, $message_type);
        } elseif (preg_match('/^\/students\/(\d+)$/', $path, $matches)) {
            showStudentDetail($pdo, $matches[1]);
        } elseif (preg_match('/^\/courses\/(\d+)\/edit$/', $path, $matches)) {
            showEditCourse($pdo, $matches[1], $message, $message_type);
        } elseif (preg_match('/^\/courses\/(\d+)$/', $path, $matches)) {
            showCourseDetail($pdo, $matches[1]);
        } elseif (preg_match('/^\/enrollments\/(\d+)$/', $path, $matches)) {
            showEnrollmentDetail($pdo, $matches[1]);
        } else {
            show404();
        }
}
