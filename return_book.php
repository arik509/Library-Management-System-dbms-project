<?php
require 'auth.php';
require_admin();
require 'db_config.php';
$id = (int)($_GET['id'] ?? 0);
if ($id > 0) {
    $stmt = $conn->prepare("UPDATE issued_books SET status='Returned', return_date=CURDATE() WHERE id=? AND status <> 'Returned'");
    $stmt->bind_param('i', $id);
    $stmt->execute();
}
header('Location: issue_book.php');
exit();
?>
