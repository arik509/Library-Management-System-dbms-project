<?php
require 'auth.php';
require_student_or_teacher();
$page_title = 'Student Dashboard';
include 'bootstrap_head.php';
include 'navbar.php';
?>
<div class="container py-4">
  <h2 class="fw-bold mb-1">Student Dashboard</h2>
  <p class="text-muted mb-4">Browse books, request books, and check your issue history</p>
  <div class="row g-4">
    <div class="col-md-4"><a class="text-decoration-none" href="view_books.php"><div class="card dashboard-card shadow-sm"><div class="card-body"><div class="icon-box bg-info-subtle text-info mb-3"><i class="bi bi-book"></i></div><h5>View Books</h5><p class="text-muted mb-0">See available books</p></div></div></a></div>
    <div class="col-md-4"><a class="text-decoration-none" href="request_book.php"><div class="card dashboard-card shadow-sm"><div class="card-body"><div class="icon-box bg-primary-subtle text-primary mb-3"><i class="bi bi-journal-plus"></i></div><h5>Request Book</h5><p class="text-muted mb-0">Submit a new request</p></div></div></a></div>
    <div class="col-md-4"><a class="text-decoration-none" href="my_books.php"><div class="card dashboard-card shadow-sm"><div class="card-body"><div class="icon-box bg-warning-subtle text-warning mb-3"><i class="bi bi-clock-history"></i></div><h5>My Books</h5><p class="text-muted mb-0">View issued books</p></div></div></a></div>
    <div class="col-md-4"><a class="text-decoration-none" href="profile.php"><div class="card dashboard-card shadow-sm"><div class="card-body"><div class="icon-box bg-secondary-subtle text-secondary mb-3"><i class="bi bi-person"></i></div><h5>Profile</h5><p class="text-muted mb-0">Your account details</p></div></div></a></div>
  </div>
</div>
<?php include 'footer.php'; ?>
