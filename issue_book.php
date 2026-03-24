<?php
require 'auth.php';
require_admin();
require 'db_config.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = (int)$_POST['user_id'];
    $book_id = (int)$_POST['book_id'];
    $issue_date = $_POST['issue_date'];
    $due_date = $_POST['due_date'];
    $stmt = $conn->prepare("INSERT INTO issued_books (user_id, book_id, issue_date, due_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('iiss', $user_id, $book_id, $issue_date, $due_date);
    if ($stmt->execute()) $message = 'Book issued successfully.'; else $message = 'Failed: ' . $conn->error;
}
$students = $conn->query("SELECT id, name, user_type FROM users WHERE user_type IN ('Student','Teacher') AND status='Active' ORDER BY name ASC");
$books = $conn->query("SELECT id, title, available_copies FROM books WHERE available_copies > 0 AND status='Active' ORDER BY title ASC");
$issues = $conn->query("SELECT i.id, u.name AS user_name, b.title AS book_title, i.issue_date, i.due_date, i.return_date, i.status FROM issued_books i JOIN users u ON i.user_id=u.id JOIN books b ON i.book_id=b.id ORDER BY i.id DESC");
$page_title = 'Issue Book';
include 'bootstrap_head.php';
include 'navbar.php';
?>
<div class="container py-4"><div class="row g-4"><div class="col-lg-4"><div class="card form-card shadow-sm"><div class="card-body"><h4 class="fw-bold mb-3">Issue Book</h4><?php if ($message): ?><div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div><?php endif; ?><form method="post"><div class="mb-3"><label class="form-label">Select User</label><select name="user_id" class="form-select" required><?php while($s = $students->fetch_assoc()): ?><option value="<?php echo $s['id']; ?>"><?php echo htmlspecialchars($s['name'].' ('.$s['user_type'].')'); ?></option><?php endwhile; ?></select></div><div class="mb-3"><label class="form-label">Select Book</label><select name="book_id" class="form-select" required><?php while($b = $books->fetch_assoc()): ?><option value="<?php echo $b['id']; ?>"><?php echo htmlspecialchars($b['title'].' - Available: '.$b['available_copies']); ?></option><?php endwhile; ?></select></div><div class="mb-3"><label class="form-label">Issue Date</label><input type="date" name="issue_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required></div><div class="mb-3"><label class="form-label">Due Date</label><input type="date" name="due_date" class="form-control" value="<?php echo date('Y-m-d', strtotime('+7 days')); ?>" required></div><button class="btn btn-primary">Issue</button></form></div></div></div><div class="col-lg-8"><div class="card table-card shadow-sm"><div class="card-body"><h4 class="fw-bold mb-3">Issue History</h4><div class="table-responsive"><table class="table table-striped align-middle"><thead><tr><th>ID</th><th>User</th><th>Book</th><th>Issue</th><th>Due</th><th>Return</th><th>Status</th><th>Action</th></tr></thead><tbody><?php while($row = $issues->fetch_assoc()): ?><tr><td><?php echo $row['id']; ?></td><td><?php echo htmlspecialchars($row['user_name']); ?></td><td><?php echo htmlspecialchars($row['book_title']); ?></td><td><?php echo $row['issue_date']; ?></td><td><?php echo $row['due_date']; ?></td><td><?php echo $row['return_date'] ?: '-'; ?></td><td><?php echo $row['status']; ?></td><td><?php if ($row['status'] !== 'Returned'): ?><a class="btn btn-sm btn-success" href="return_book.php?id=<?php echo $row['id']; ?>">Mark Returned</a><?php else: ?><span class="text-muted">Done</span><?php endif; ?></td></tr><?php endwhile; ?></tbody></table></div></div></div></div></div></div>
<?php include 'footer.php'; ?>
