<?php
$page_title = 'Login - LMS';
include 'bootstrap_head.php';
?>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="card hero-card shadow">
        <div class="card-body p-5">
          <div class="text-center mb-4">
            <h1 class="fw-bold">Library Management System</h1>
            <p class="text-muted mb-0">Login with your account</p>
          </div>
          <?php if (isset($_GET['msg']) && $_GET['msg'] === 'registered'): ?>
            <div class="alert alert-success">Registration successful. Please log in.</div>
          <?php endif; ?>
          <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
          <?php endif; ?>
          <form action="login.php" method="post">
            <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
            <div class="mb-3"><label class="form-label">User Type</label><select name="user_type" class="form-select" required><option value="Admin">Admin</option><option value="Student">Student</option><option value="Teacher">Teacher</option></select></div>
            <button class="btn btn-primary w-100">Login</button>
          </form>
          <div class="text-center mt-3"><a href="register.php">Create new account</a></div>
          <hr><small class="text-muted d-block text-center">Default admin: admin@test.com / admin123</small>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>
