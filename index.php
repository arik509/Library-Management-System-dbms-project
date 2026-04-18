<?php
$page_title = 'Login - LMS';
include 'bootstrap_head.php';
?>
<div class="container login-wrap py-4">
  <div class="row g-4 align-items-stretch w-100">
    <div class="col-lg-6">
      <div class="brand-panel h-100 d-flex flex-column justify-content-between">
        <div>
          <span class="brand-chip"><i class="bi bi-stars"></i> Premium Dark Interface</span>
          <h1 class="hero-title mt-4 mb-3">Library Management System</h1>
          <p class="hero-subtitle">Manage books, users, issues, and requests through one centralized library management portal.
</p>
        </div>
        <ul class="feature-list">
          <li><span class="feature-icon"><i class="bi bi-shield-check"></i></span><span>Role-based login for admin, student, and teacher.</span></li>
          <li><span class="feature-icon"><i class="bi bi-book-half"></i></span><span>Book issue, return, request, and availability tracking.</span></li>
          <li><span class="feature-icon"><i class="bi bi-bar-chart-line"></i></span><span>Structured tables and dashboards suitable for demo and viva.</span></li>
        </ul>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="login-panel h-100 d-flex flex-column justify-content-center">
        <div class="mb-4 text-center text-lg-start">
          <span class="login-side-badge mb-3"><i class="bi bi-box-arrow-in-right"></i> Welcome back</span>
          <h2 class="hero-title fs-1 mb-2">Sign in</h2>
          <p class="hero-subtitle mb-0">Access your portal with your registered credentials.</p>
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
        <div class="mt-3 text-center text-lg-start">
          <a href="register.php" class="fw-semibold text-white">Create new account</a>
        </div>
        <hr class="my-4">
        <p class="footer-note mb-0">Demo admin: <strong class="text-white">admin@test.com</strong> / <strong class="text-white">admin123</strong></p>
      </div>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>
