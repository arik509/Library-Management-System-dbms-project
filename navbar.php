<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$userType = $_SESSION['user_type'] ?? null;
$userName = $_SESSION['user_name'] ?? 'User';
$homeLink = 'index.php';
if ($userType === 'Admin') $homeLink = 'admin_dashboard.php';
if ($userType === 'Student' || $userType === 'Teacher') $homeLink = 'student_dashboard.php';
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?php echo $homeLink; ?>">LMS</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsExample">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php if ($userType === 'Admin'): ?>
          <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="manage_categories.php">Categories</a></li>
          <li class="nav-item"><a class="nav-link" href="add_book.php">Add Book</a></li>
          <li class="nav-item"><a class="nav-link" href="view_books.php">Books</a></li>
          <li class="nav-item"><a class="nav-link" href="issue_book.php">Issue/Return</a></li>
          <li class="nav-item"><a class="nav-link" href="view_students.php">Users</a></li>
        <?php elseif ($userType === 'Student' || $userType === 'Teacher'): ?>
          <li class="nav-item"><a class="nav-link" href="student_dashboard.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="view_books.php">Books</a></li>
          <li class="nav-item"><a class="nav-link" href="request_book.php">Request</a></li>
          <li class="nav-item"><a class="nav-link" href="my_books.php">My Books</a></li>
          <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
        <?php endif; ?>
      </ul>
      <span class="navbar-text text-white me-3"><?php echo htmlspecialchars($userName); ?> (<?php echo htmlspecialchars($userType ?? 'Guest'); ?>)</span>
      <?php if ($userType): ?><a class="btn btn-light btn-sm" href="logout.php">Logout</a><?php endif; ?>
    </div>
  </div>
</nav>
