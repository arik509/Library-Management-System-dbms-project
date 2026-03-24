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
<div class="container py-5">
  <div class="row justify-content-center align-items-center min-vh-100">
    <div class="col-lg-8">
      <div class="card hero-card shadow-lg">
        <div class="card-body p-5">
          <div class="mb-4">
            <span class="login-side-badge mb-3"><i class="bi bi-person-plus-fill"></i> New account</span>
            <h2 class="hero-title fs-1 mb-2">Create your account</h2>
            <p class="hero-subtitle mb-0">Register students, teachers, or admins with a more polished interface.</p>
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
</div>
<?php include 'footer.php'; ?>
