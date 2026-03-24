<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
function require_login() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php');
        exit();
    }
}
function require_admin() {
    require_login();
    if (($_SESSION['user_type'] ?? '') !== 'Admin') {
        header('Location: index.php');
        exit();
    }
}
function require_student_or_teacher() {
    require_login();
    $t = $_SESSION['user_type'] ?? '';
    if ($t !== 'Student' && $t !== 'Teacher') {
        header('Location: index.php');
        exit();
    }
}
?>
