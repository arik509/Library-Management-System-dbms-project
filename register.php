<?php
require 'db_config.php';
$page_title = 'Register - LMS';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm = trim($_POST['confirm_password'] ?? '');
    $user_type = trim($_POST['user_type'] ?? 'Student');
    if ($name === '' || $email === '' || $password === '') {
        $error = 'All fields are required.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        $check = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $check->bind_param('s', $email);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $error = 'Email already exists.';
        } else {
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, user_type) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('ssss', $name, $email, $password, $user_type);
            if ($stmt->execute()) {
                header('Location: index.php?msg=registered');
                exit();
            } else {
                $error = 'Registration failed.';
            }
        }
    }
}
include 'bootstrap_head.php';
?>
<div class="container login-wrap py-4">
  <div class="row g-4 align-items-stretch w-100">
    <div class="col-lg-5">
      <div class="brand-panel h-100 d-flex flex-column justify-content-between">
        <div>
          <span class="brand-chip"><i class="bi bi-person-plus-fill"></i> Join the portal</span>
          <h2 class="hero-title mt-4 mb-3">Create an account</h2>
          <p class="hero-subtitle">Create accounts for students, teachers, or admins to access the library management system.</p>
        </div>
        <ul class="feature-list">
          <li><span class="feature-icon"><i class="bi bi-person-badge"></i></span><span>Unified users table with role-based access.</span></li>
          <li><span class="feature-icon"><i class="bi bi-database-check"></i></span><span>Connected directly with your normalized MySQL schema.</span></li>
          <li><span class="feature-icon"><i class="bi bi-window"></i></span><span>Modern pages for a better course presentation.</span></li>
        </ul>
      </div>
    </div>
    <div class="col-lg-7">
      <div class="login-panel h-100 d-flex flex-column justify-content-center">
        <div class="mb-4">
          <span class="login-side-badge mb-3"><i class="bi bi-person-lines-fill"></i> Registration form</span>
          <h2 class="hero-title fs-1 mb-2">Create your account</h2>
          <p class="hero-subtitle mb-0">Fill in the details below to continue.</p>
        </div>
        <?php if ($error): ?><div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
        <form method="post">
          <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Full Name</label><input type="text" name="name" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">Confirm Password</label><input type="password" name="confirm_password" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">User Type</label><select name="user_type" class="form-select"><option value="Student">Student</option><option value="Teacher">Teacher</option><option value="Admin">Admin</option></select></div>
          </div>
          <div class="mt-4 d-flex gap-2 flex-wrap">
            <button class="btn btn-primary"><i class="bi bi-check2-circle me-2"></i>Register</button>
            <a class="btn btn-outline-secondary" href="index.php">Back to Login</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>
