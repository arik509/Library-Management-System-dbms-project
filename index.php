<?php
$page_title = 'Login - LMS';
include 'bootstrap_head.php';
?>
<div class="container py-5">
  <div class="row justify-content-center align-items-center min-vh-100">
    <div class="col-lg-6">
      <div class="card hero-card shadow-lg">
        <div class="card-body p-5">
          <div class="mb-4 text-center">
            <span class="login-side-badge mb-3"><i class="bi bi-stars"></i> Modern Library Portal</span>
            <h1 class="hero-title mb-2">Library Management System</h1>
            <p class="hero-subtitle mb-0">A cleaner, modern interface for your DBMS project login.</p>
          </div>
          <?php if (isset($_GET['msg']) && $_GET['msg'] === 'registered'): ?>
            <div class="alert alert-success">Registration successful. Please log in.</div>
          <?php endif; ?>
          <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
          <?php endif; ?>
          <form action="login.php" method="post">
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
            </div>
            <div class="mb-4">
              <label class="form-label">User Type</label>
              <select name="user_type" class="form-select" required>
                <option value="Admin">Admin</option>
                <option value="Student">Student</option>
                <option value="Teacher">Teacher</option>
              </select>
            </div>
            <button class="btn btn-primary w-100 py-3"><i class="bi bi-box-arrow-in-right me-2"></i>Login</button>
          </form>
          <div class="text-center mt-3">
            <a href="register.php" class="text-decoration-none fw-semibold">Create new account</a>
          </div>
          <hr class="my-4">
          <p class="footer-note text-center mb-0">Default admin for demo: <strong>admin@test.com</strong> / <strong>admin123</strong></p>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>
