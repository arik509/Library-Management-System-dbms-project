<?php
session_start();
require 'db_config.php';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_type = $_SESSION['user_type'];
    $stmt = $conn->prepare("INSERT INTO logout_logs (user_id, user_type) VALUES (?, ?)");
    $stmt->bind_param('is', $user_id, $user_type);
    $stmt->execute();
}
session_unset();
session_destroy();
header('Location: index.php');
exit();
?>
