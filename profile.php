<?php
require 'auth.php';
require_login();
require 'db_config.php';
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT id, name, email, user_type, status, created_at FROM users WHERE id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$page_title = 'Profile';
include 'bootstrap_head.php';
include 'navbar.php';
?>
<div class="container py-4"><div class="row justify-content-center"><div class="col-lg-8"><div class="card form-card shadow-sm"><div class="card-body p-4"><h3 class="fw-bold mb-3">My Profile</h3><div class="row g-3"><div class="col-md-6"><label class="form-label text-muted">Name</label><div class="form-control bg-light"><?php echo htmlspecialchars($user['name']); ?></div></div><div class="col-md-6"><label class="form-label text-muted">Email</label><div class="form-control bg-light"><?php echo htmlspecialchars($user['email']); ?></div></div><div class="col-md-6"><label class="form-label text-muted">User Type</label><div class="form-control bg-light"><?php echo htmlspecialchars($user['user_type']); ?></div></div><div class="col-md-6"><label class="form-label text-muted">Status</label><div class="form-control bg-light"><?php echo htmlspecialchars($user['status']); ?></div></div><div class="col-md-6"><label class="form-label text-muted">Created At</label><div class="form-control bg-light"><?php echo htmlspecialchars($user['created_at']); ?></div></div></div></div></div></div></div></div>
<?php include 'footer.php'; ?>
