<?php
require 'auth.php';
require_admin();
require 'db_config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = trim($_POST['name']);
    if ($name !== '') {
        $stmt = $conn->prepare("INSERT IGNORE INTO categories (name) VALUES (?)");
        $stmt->bind_param('s', $name);
        $stmt->execute();
    }
    header('Location: manage_categories.php');
    exit();
}
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    header('Location: manage_categories.php');
    exit();
}
$categories = $conn->query("SELECT * FROM categories ORDER BY name ASC");
$page_title = 'Manage Categories';
include 'bootstrap_head.php';
include 'navbar.php';
?>
<div class="container py-4"><div class="row g-4"><div class="col-lg-4"><div class="card form-card shadow-sm"><div class="card-body"><h4 class="fw-bold mb-3">Add Category</h4><form method="post"><div class="mb-3"><label class="form-label">Category Name</label><input type="text" name="name" class="form-control" required></div><button class="btn btn-primary">Save</button></form></div></div></div><div class="col-lg-8"><div class="card table-card shadow-sm"><div class="card-body"><h4 class="fw-bold mb-3">Category List</h4><div class="table-responsive"><table class="table table-striped align-middle"><thead><tr><th>ID</th><th>Name</th><th>Action</th></tr></thead><tbody><?php while ($row = $categories->fetch_assoc()): ?><tr><td><?php echo $row['id']; ?></td><td><?php echo htmlspecialchars($row['name']); ?></td><td><a class="btn btn-sm btn-outline-danger" href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this category?')">Delete</a></td></tr><?php endwhile; ?></tbody></table></div></div></div></div></div></div>
<?php include 'footer.php'; ?>
