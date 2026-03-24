<?php
require 'auth.php';
require_student_or_teacher();
require 'db_config.php';
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT i.id, b.title, i.issue_date, i.due_date, i.return_date, i.fine_amount, i.status FROM issued_books i JOIN books b ON i.book_id = b.id WHERE i.user_id = ? ORDER BY i.id DESC");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$page_title = 'My Books';
include 'bootstrap_head.php';
include 'navbar.php';
?>
<div class="container py-4"><div class="card table-card shadow-sm"><div class="card-body"><h3 class="fw-bold mb-3">My Issued Books</h3><div class="table-responsive"><table class="table table-striped"><thead><tr><th>ID</th><th>Book</th><th>Issue Date</th><th>Due Date</th><th>Return Date</th><th>Fine</th><th>Status</th></tr></thead><tbody><?php while($row = $result->fetch_assoc()): ?><tr><td><?php echo $row['id']; ?></td><td><?php echo htmlspecialchars($row['title']); ?></td><td><?php echo $row['issue_date']; ?></td><td><?php echo $row['due_date']; ?></td><td><?php echo $row['return_date'] ?: '-'; ?></td><td><?php echo $row['fine_amount']; ?></td><td><?php echo $row['status']; ?></td></tr><?php endwhile; ?></tbody></table></div></div></div></div>
<?php include 'footer.php'; ?>
