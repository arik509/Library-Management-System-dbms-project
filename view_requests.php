<?php
require 'auth.php';
require_admin();
require 'db_config.php';

// ✅ Approve / Reject হ্যান্ডল করা হচ্ছে same file এ
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id     = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action === 'approve') {
        $conn->query("UPDATE book_requests SET status='Approved' WHERE id=$id");
    } elseif ($action === 'reject') {
        $conn->query("UPDATE book_requests SET status='Rejected' WHERE id=$id");
    }

    header("Location: view_requests.php");
    exit;
}

$page_title = 'Book Requests';
include 'bootstrap_head.php';
include 'navbar.php';

$sql = "SELECT book_requests.id, users.name, users.email, 
               book_requests.book_title, book_requests.request_date,
               book_requests.status
        FROM book_requests
        INNER JOIN users ON book_requests.user_id = users.id
        ORDER BY book_requests.request_date DESC";

$result = $conn->query($sql);
?>

<div class="container py-4">
  <h3 class="fw-bold mb-4">📋 Book Requests</h3>

  <table class="table table-bordered table-hover text-center">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>Student / Teacher Name</th>
        <th>Email</th>
        <th>Requested Book</th>
        <th>Request Date</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result && $result->num_rows > 0):
            $i = 1;
            while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
        <td><?php echo htmlspecialchars($row['email']); ?></td>
        <td><?php echo htmlspecialchars($row['book_title']); ?></td>
        <td><?php echo $row['request_date']; ?></td>
        <td>
          <?php if ($row['status'] == 'Pending'): ?>
            <span class="badge bg-warning text-dark">Pending</span>
          <?php elseif ($row['status'] == 'Approved'): ?>
            <span class="badge bg-success">Approved</span>
          <?php else: ?>
            <span class="badge bg-danger">Rejected</span>
          <?php endif; ?>
        </td>

        <!-- ✅ Action Column -->
        <td>
          <?php if ($row['status'] == 'Pending'): ?>
            <a href="view_requests.php?action=approve&id=<?php echo $row['id']; ?>"
               class="btn btn-success btn-sm"
               onclick="return confirm('Approve this request?')">
               ✔ Approve
            </a>
            <a href="view_requests.php?action=reject&id=<?php echo $row['id']; ?>"
               class="btn btn-danger btn-sm"
               onclick="return confirm('Reject this request?')">
               ✖ Reject
            </a>
          <?php else: ?>
            <span class="text-muted fst-italic">—</span>
          <?php endif; ?>
        </td>
      </tr>
      <?php endwhile; else: ?>
      <tr><td colspan="7" class="text-muted">No requests found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php include 'footer.php'; ?>