<?php
require 'auth.php';
require_login();
require 'db_config.php';

$page_title = 'Book Requests';
include 'bootstrap_head.php';
include 'navbar.php';
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
      <?php
      $sql = "SELECT book_requests.id, users.name, users.email, 
               book_requests.book_title, book_requests.request_date,
               book_requests.status
        FROM book_requests
        INNER JOIN users ON book_requests.user_id = users.id
        ORDER BY book_requests.request_date DESC";

      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          $i = 1;
          while ($row = $result->fetch_assoc()) {
      ?>
      <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['book_title']; ?></td>
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
        <td>
          <a href="approve_request.php?id=<?php echo $row['id']; ?>" 
             class="btn btn-success btn-sm">Approve</a>
          <a href="reject_request.php?id=<?php echo $row['id']; ?>" 
             class="btn btn-danger btn-sm">Reject</a>
        </td>
      </tr>
      <?php }} else { ?>
      <tr><td colspan="7">No requests found.</td></tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<?php include 'footer.php'; ?>