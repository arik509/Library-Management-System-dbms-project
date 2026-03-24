<?php
require 'auth.php';
require_admin();
require 'db_config.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $isbn = trim($_POST['isbn']);
    $category_id = $_POST['category_id'] !== '' ? (int)$_POST['category_id'] : NULL;
    $total_copies = (int)$_POST['total_copies'];
    $available_copies = (int)$_POST['available_copies'];
    $stmt = $conn->prepare("INSERT INTO books (title, author, isbn, category_id, total_copies, available_copies) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sssiii', $title, $author, $isbn, $category_id, $total_copies, $available_copies);
    if ($stmt->execute()) $message = 'Book added successfully.'; else $message = 'Failed: ' . $conn->error;
}
$categories = $conn->query("SELECT id, name FROM categories ORDER BY name ASC");
$page_title = 'Add Book';
include 'bootstrap_head.php';
include 'navbar.php';
?>
<div class="container py-4"><div class="row justify-content-center"><div class="col-lg-8"><div class="card form-card shadow-sm"><div class="card-body p-4"><h3 class="fw-bold mb-3">Add New Book</h3><?php if ($message): ?><div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div><?php endif; ?><form method="post"><div class="row g-3"><div class="col-md-6"><label class="form-label">Title</label><input type="text" name="title" class="form-control" required></div><div class="col-md-6"><label class="form-label">Author</label><input type="text" name="author" class="form-control" required></div><div class="col-md-6"><label class="form-label">ISBN</label><input type="text" name="isbn" class="form-control"></div><div class="col-md-6"><label class="form-label">Category</label><select name="category_id" class="form-select"><option value="">Select category</option><?php while($c = $categories->fetch_assoc()): ?><option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['name']); ?></option><?php endwhile; ?></select></div><div class="col-md-6"><label class="form-label">Total Copies</label><input type="number" name="total_copies" value="1" min="1" class="form-control" required></div><div class="col-md-6"><label class="form-label">Available Copies</label><input type="number" name="available_copies" value="1" min="0" class="form-control" required></div></div><div class="mt-4"><button class="btn btn-primary">Add Book</button></div></form></div></div></div></div></div>
<?php include 'footer.php'; ?>
