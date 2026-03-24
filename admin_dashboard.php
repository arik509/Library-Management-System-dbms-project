<?php
require 'auth.php';
require_admin();
$page_title = 'Admin Dashboard';
include 'bootstrap_head.php';
include 'navbar.php';
?>
<div class="container py-4">
  <h2 class="fw-bold mb-1">Admin Dashboard</h2>
  <p class="text-muted mb-4">Manage books, categories, users, and issues</p>
  <div class="row g-4">
    <div class="col-md-4 col-lg-3"><a class="text-decoration-none" href="manage_categories.php"><div class="card dashboard-card shadow-sm"><div class="card-body"><div class="icon-box bg-primary-subtle text-primary mb-3"><i class="bi bi-tags"></i></div><h5>Categories</h5><p class="text-muted mb-0">Add and manage categories</p></div></div></a></div>
    <div class="col-md-4 col-lg-3"><a class="text-decoration-none" href="add_book.php"><div class="card dashboard-card shadow-sm"><div class="card-body"><div class="icon-box bg-success-subtle text-success mb-3"><i class="bi bi-book"></i></div><h5>Add Book</h5><p class="text-muted mb-0">Insert new books</p></div></div></a></div>
    <div class="col-md-4 col-lg-3"><a class="text-decoration-none" href="view_books.php"><div class="card dashboard-card shadow-sm"><div class="card-body"><div class="icon-box bg-info-subtle text-info mb-3"><i class="bi bi-collection"></i></div><h5>View Books</h5><p class="text-muted mb-0">See all books</p></div></div></a></div>
    <div class="col-md-4 col-lg-3"><a class="text-decoration-none" href="issue_book.php"><div class="card dashboard-card shadow-sm"><div class="card-body"><div class="icon-box bg-warning-subtle text-warning mb-3"><i class="bi bi-arrow-left-right"></i></div><h5>Issue/Return</h5><p class="text-muted mb-0">Handle borrowing</p></div></div></a></div>
    <div class="col-md-4 col-lg-3"><a class="text-decoration-none" href="view_students.php"><div class="card dashboard-card shadow-sm"><div class="card-body"><div class="icon-box bg-danger-subtle text-danger mb-3"><i class="bi bi-people"></i></div><h5>Users</h5><p class="text-muted mb-0">Students and teachers</p></div></div></a></div>
    <div class="col-md-4 col-lg-3"><a class="text-decoration-none" href="profile.php"><div class="card dashboard-card shadow-sm"><div class="card-body"><div class="icon-box bg-secondary-subtle text-secondary mb-3"><i class="bi bi-person-circle"></i></div><h5>Profile</h5><p class="text-muted mb-0">View your account</p></div></div></a></div>
  </div>
</div>
<?php include 'footer.php'; ?>
