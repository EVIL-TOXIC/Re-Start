<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  header("Location: login.php");
  exit;
}
include '../config/db.php'; // ✅ Use centralized DB connection
include 'includes/header.php';

// ✅ Fetch users
$result = $conn->query("SELECT * FROM users ORDER BY id DESC");
?>

<div class="container mt-4">
  <h2>User Submissions</h2>

  <table class="table table-bordered table-dark table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Message</th>
        <th>Submitted At</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
          <td><?= htmlspecialchars($row['id']) ?></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['phone']) ?></td>
          <td><?= htmlspecialchars($row['message']) ?></td>
          <td><?= htmlspecialchars($row['created_at']) ?></td>
          <td>
            <a href="user_edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
            <a href="user_delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')">Delete</a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<?php include 'includes/footer.php'; ?>