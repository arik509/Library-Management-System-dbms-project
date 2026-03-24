<?php
require 'auth.php';
require_student_or_teacher();
require 'db_config.php';
$userId = $_SESSION['user_id'];
$totalAvailable = $conn->query("SELECT COUNT(*) AS c FROM books WHERE available_copies > 0")->fetch_assoc()['c'] ?? 0;
$myIssuedStmt = $conn->prepare("SELECT COUNT(*) AS c FROM issued_books WHERE user_id = ? AND status <> 'Returned'");
$myIssuedStmt->bind_param('i', $userId);
$myIssuedStmt->execute();
$myIssued = $myIssuedStmt->get_result()->fetch_assoc()['c'] ?? 0;
$myRequestsStmt = $conn->prepare("SELECT COUNT(*) AS c FROM book_requests WHERE user_id = ?");
$myRequestsStmt->bind_param('i', $userId);
$myRequestsStmt->execute();
$myRequests = $myRequestsStmt->get_result()->fetch_assoc()['c'] ?? 0;
$page_title = 'Student Dashboard';
include 'bootstrap_head.php';
include 'navbar.php';
?>
<div class="container py-4">
  <div class="page-header">
    <div>
      <h2 class="page-title">Student Dashboard</h2>
      <p class="page-subtitle">Browse books, request titles, and monitor your issue history with a cleaner UI.</p>
    </div>
  </div>

  <div class="row g-3 mb-4">
    <div class="col-md-4"><div class="stat-card"><div class="stat-label">Available Books</div><div class="stat-value"><?php echo $totalAvailable; ?></div></div></div>
    <div class="col-md-4"><div class="stat-card"><div class="stat-label">My Active Issues</div><div class="stat-value"><?php echo $myIssued; ?></div></div></div>
    <div class="col-md-4"><div class="stat-card"><div class="stat-label">My Requests</div><div class="stat-value"><?php echo $myRequests; ?></div></div></div>
  </div>

  <div class="row g-4">
    <div class="col-md-4"><a class="text-decoration-none" href="view_books.php"><div class="card dashboard-card shadow-sm"><div class="card-body"><div class="icon-box bg-info-subtle text-info mb-3"><i class="bi bi-book"></i></div><h5>View Books</h5><p class="text-muted mb-0">See all available books and details.</p></div></div></a></div>
    <div class="col-md-4"><a class="text-decoration-none" href="request_book.php"><div class="card dashboard-card shadow-sm"><div class="card-body"><div class="icon-box bg-primary-subtle text-primary mb-3"><i class="bi bi-journal-plus"></i></div><h5>Request Book</h5><p class="text-muted mb-0">Send a request for a desired title.</p></div></div></a></div>
    <div class="col-md-4"><a class="text-decoration-none" href="my_books.php"><div class="card dashboard-card shadow-sm"><div class="card-body"><div class="icon-box bg-warning-subtle text-warning mb-3"><i class="bi bi-clock-history"></i></div><h5>My Books</h5><p class="text-muted mb-0">Check issue date, due date, and status.</p></div></div></a></div>
    <div class="col-md-4"><a class="text-decoration-none" href="profile.php"><div class="card dashboard-card shadow-sm"><div class="card-body"><div class="icon-box bg-secondary-subtle text-secondary mb-3"><i class="bi bi-person"></i></div><h5>Profile</h5><p class="text-muted mb-0">View your personal account details.</p></div></div></a></div>
  </div>
</div>
<?php include 'footer.php'; ?>
