<?php
require 'auth.php';
require_login();
require 'db_config.php';
$books = $conn->query("SELECT b.*, c.name AS category_name FROM books b LEFT JOIN categories c ON b.category_id = c.id ORDER BY b.id DESC");
$page_title = 'View Books';
include 'bootstrap_head.php';
include 'navbar.php';
?>
<div class="container py-4"><div class="card table-card shadow-sm"><div class="card-body"><h3 class="fw-bold mb-3">Book List</h3><div class="table-responsive"><table class="table table-striped table-hover align-middle"><thead><tr><th>ID</th><th>Title</th><th>Author</th><th>ISBN</th><th>Category</th><th>Total</th><th>Available</th><th>Status</th></tr></thead><tbody><?php while ($row = $books->fetch_assoc()): ?><tr><td><?php echo $row['id']; ?></td><td><?php echo htmlspecialchars($row['title']); ?></td><td><?php echo htmlspecialchars($row['author']); ?></td><td><?php echo htmlspecialchars($row['isbn']); ?></td><td><?php echo htmlspecialchars($row['category_name'] ?? 'Uncategorized'); ?></td><td><?php echo $row['total_copies']; ?></td><td><?php echo $row['available_copies']; ?></td><td><span class="badge text-bg-<?php echo $row['available_copies'] > 0 ? 'success' : 'secondary'; ?>"><?php echo $row['status']; ?></span></td></tr><?php endwhile; ?></tbody></table></div></div></div></div>
<?php include 'footer.php'; ?>
