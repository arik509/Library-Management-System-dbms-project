<?php
require 'auth.php';
require_admin();
require 'db_config.php';
$users = $conn->query("SELECT id, name, email, user_type, status, created_at FROM users ORDER BY id DESC");
$page_title = 'View Users';
include 'bootstrap_head.php';
include 'navbar.php';
?>
<div class="container py-4"><div class="card table-card shadow-sm"><div class="card-body"><h3 class="fw-bold mb-3">All Users</h3><div class="table-responsive"><table class="table table-striped"><thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Type</th><th>Status</th><th>Created</th></tr></thead><tbody><?php while($row = $users->fetch_assoc()): ?><tr><td><?php echo $row['id']; ?></td><td><?php echo htmlspecialchars($row['name']); ?></td><td><?php echo htmlspecialchars($row['email']); ?></td><td><?php echo $row['user_type']; ?></td><td><?php echo $row['status']; ?></td><td><?php echo $row['created_at']; ?></td></tr><?php endwhile; ?></tbody></table></div></div></div></div>
<?php include 'footer.php'; ?>
