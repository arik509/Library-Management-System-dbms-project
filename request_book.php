<?php
require 'auth.php';
require_student_or_teacher();
require 'db_config.php';
$message = '';
$user_id = $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_title = trim($_POST['book_title']);
    if ($book_title !== '') {
        $stmt = $conn->prepare("INSERT INTO book_requests (user_id, book_title) VALUES (?, ?)");
        $stmt->bind_param('is', $user_id, $book_title);
        if ($stmt->execute()) $message = 'Request submitted.';
    }
}
$stmt = $conn->prepare("SELECT id, book_title, request_date, status FROM book_requests WHERE user_id = ? ORDER BY id DESC");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$requests = $stmt->get_result();
$page_title = 'Request Book';
include 'bootstrap_head.php';
include 'navbar.php';
?>
<div class="container py-4"><div class="row g-4"><div class="col-lg-4"><div class="card form-card shadow-sm"><div class="card-body"><h4 class="fw-bold mb-3">Request a Book</h4><?php if ($message): ?><div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div><?php endif; ?><form method="post"><div class="mb-3"><label class="form-label">Book Title</label><input type="text" name="book_title" class="form-control" placeholder="Enter title you want" required></div><button class="btn btn-primary">Submit Request</button></form></div></div></div><div class="col-lg-8"><div class="card table-card shadow-sm"><div class="card-body"><h4 class="fw-bold mb-3">My Requests</h4><div class="table-responsive"><table class="table table-striped"><thead><tr><th>ID</th><th>Book Title</th><th>Date</th><th>Status</th></tr></thead><tbody><?php while($row = $requests->fetch_assoc()): ?><tr><td><?php echo $row['id']; ?></td><td><?php echo htmlspecialchars($row['book_title']); ?></td><td><?php echo $row['request_date']; ?></td><td><?php echo $row['status']; ?></td></tr><?php endwhile; ?></tbody></table></div></div></div></div></div></div>
<?php include 'footer.php'; ?>
