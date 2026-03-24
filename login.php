<?php
session_start();
require 'db_config.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit();
}
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');
$user_type = trim($_POST['user_type'] ?? '');
$stmt = $conn->prepare("SELECT id, name, email, password, user_type, status FROM users WHERE email = ? AND user_type = ? LIMIT 1");
$stmt->bind_param('ss', $email, $user_type);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $ok = ($password === $row['password']) || password_verify($password, $row['password']);
    if ($ok && $row['status'] === 'Active') {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['user_type'] = $row['user_type'];
        $audit = $conn->prepare("INSERT INTO login_audit (user_id, email, user_type, status) VALUES (?, ?, ?, 'Success')");
        $audit->bind_param('iss', $row['id'], $row['email'], $row['user_type']);
        $audit->execute();
        header('Location: ' . ($row['user_type'] === 'Admin' ? 'admin_dashboard.php' : 'student_dashboard.php'));
        exit();
    }
}
$uid = null;
$fail = $conn->prepare("INSERT INTO login_audit (user_id, email, user_type, status) VALUES (?, ?, ?, 'Failed')");
$fail->bind_param('iss', $uid, $email, $user_type);
$fail->execute();
header('Location: index.php?error=' . urlencode('Invalid credentials'));
exit();
?>
