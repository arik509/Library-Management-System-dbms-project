<?php
require 'auth.php';
require_admin();
require 'db_config.php';

$totalBooks    = $conn->query("SELECT COUNT(*) AS c FROM books")->fetch_assoc()['c'] ?? 0;
$totalUsers    = $conn->query("SELECT COUNT(*) AS c FROM users")->fetch_assoc()['c'] ?? 0;
$activeIssues  = $conn->query("SELECT COUNT(*) AS c FROM issued_books WHERE status <> 'Returned'")->fetch_assoc()['c'] ?? 0;
$totalRequests = $conn->query("SELECT COUNT(*) AS c FROM book_requests WHERE status = 'Pending'")->fetch_assoc()['c'] ?? 0;

$page_title = 'Admin Dashboard';
include 'bootstrap_head.php';
include 'navbar.php';
?>

<div class="container py-4">
  <div class="page-header">
    <div>
      <h2 class="page-title">Admin Dashboard</h2>
      <p class="page-subtitle">Manage books, categories, users, and issue records with a modern panel.</p>
    </div>
  </div>

  <!-- Stat Cards -->
  <div class="row g-3 mb-4">
    <div class="col-md-6 col-lg-3">
      <div class="stat-card">
        <div class="stat-label">Total Books</div>
        <div class="stat-value"><?php echo $totalBooks; ?></div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="stat-card">
        <div class="stat-label">Total Users</div>
        <div class="stat-value"><?php echo $totalUsers; ?></div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="stat-card">
        <div class="stat-label">Active Issues</div>
        <div class="stat-value"><?php echo $activeIssues; ?></div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="stat-card">
        <div class="stat-label">Pending Requests</div>
        <div class="stat-value text-warning"><?php echo $totalRequests; ?></div>
      </div>
    </div>
  </div>

  <!-- Dashboard Cards -->
  <div class="row g-4">
    <div class="col-md-4 col-lg-3">
      <a class="text-decoration-none" href="manage_categories.php">
        <div class="card dashboard-card shadow-sm"><div class="card-body">
          <div class="icon-box bg-primary-subtle text-primary mb-3"><i class="bi bi-tags"></i></div>
          <h5>Categories</h5>
          <p class="text-muted mb-0">Create and organize book categories.</p>
        </div></div>
      </a>
    </div>

    <div class="col-md-4 col-lg-3">
      <a class="text-decoration-none" href="add_book.php">
        <div class="card dashboard-card shadow-sm"><div class="card-body">
          <div class="icon-box bg-success-subtle text-success mb-3"><i class="bi bi-book-half"></i></div>
          <h5>Add Book</h5>
          <p class="text-muted mb-0">Insert new books with copies and ISBN.</p>
        </div></div>
      </a>
    </div>

    <div class="col-md-4 col-lg-3">
      <a class="text-decoration-none" href="view_books.php">
        <div class="card dashboard-card shadow-sm"><div class="card-body">
          <div class="icon-box bg-info-subtle text-info mb-3"><i class="bi bi-collection"></i></div>
          <h5>View Books</h5>
          <p class="text-muted mb-0">Browse all books and availability.</p>
        </div></div>
      </a>
    </div>

    <div class="col-md-4 col-lg-3">
      <a class="text-decoration-none" href="issue_book.php">
        <div class="card dashboard-card shadow-sm"><div class="card-body">
          <div class="icon-box bg-warning-subtle text-warning mb-3"><i class="bi bi-arrow-left-right"></i></div>
          <h5>Issue & Return</h5>
          <p class="text-muted mb-0">Track borrowed and returned books.</p>
        </div></div>
      </a>
    </div>

    <div class="col-md-4 col-lg-3">
      <a class="text-decoration-none" href="view_students.php">
        <div class="card dashboard-card shadow-sm"><div class="card-body">
          <div class="icon-box bg-danger-subtle text-danger mb-3"><i class="bi bi-people"></i></div>
          <h5>Users</h5>
          <p class="text-muted mb-0">Manage students, teachers, and admins.</p>
        </div></div>
      </a>
    </div>

    <div class="col-md-4 col-lg-3">
      <a class="text-decoration-none" href="view_requests.php">
        <div class="card dashboard-card shadow-sm"><div class="card-body">
          <div class="icon-box bg-warning-subtle text-warning mb-3"><i class="bi bi-envelope-open"></i></div>
          <h5>Book Requests</h5>
          <p class="text-muted mb-0">
            View and manage book requests from users.
            <?php if ($totalRequests > 0): ?>
              <span class="badge bg-danger ms-1"><?php echo $totalRequests; ?> Pending</span>
            <?php endif; ?>
          </p>
        </div></div>
      </a>
    </div>

    <div class="col-md-4 col-lg-3">
      <a class="text-decoration-none" href="profile.php">
        <div class="card dashboard-card shadow-sm"><div class="card-body">
          <div class="icon-box bg-secondary-subtle text-secondary mb-3"><i class="bi bi-person-circle"></i></div>
          <h5>Profile</h5>
          <p class="text-muted mb-0">Check your admin account details.</p>
        </div></div>
      </a>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>