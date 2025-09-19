<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
include '../config/db.php'; // Central DB connection

// SHOW ERRORS
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ✅ Handle POST (Update User)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST['id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $message = trim($_POST['message']);

    $stmt = $conn->prepare("UPDATE users SET name=?, email=?, phone=?, message=? WHERE id=?");
    $stmt->bind_param("ssssi", $name, $email, $phone, $message, $id);
    $stmt->execute();

    header("Location: dashboard.php");
    exit;
}

// ✅ Handle GET (Load User Info)
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid or missing user ID.");
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("User not found.");
}

$user = $result->fetch_assoc();
include 'includes/header.php';
?>

<style>
    .edit-form-container {
        background-color: #1e1e1e;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 0 20px rgba(0, 255, 255, 0.2);
        width: 100%;
        max-width: 500px;
        animation: fadeIn 0.8s ease-in-out;
        margin: 10% auto;
    }

    .form-label {
        color: #cccccc;
    }

    .form-control {
        background-color: #2a2a2a;
        color: #ffffff;
        border: 1px solid #444;
    }

    .form-control:focus {
        background-color: #333;
        border-color: #00bcd4;
        box-shadow: 0 0 0 0.2rem rgba(0, 188, 212, 0.25);
    }

    button {
        background-color: #00bcd4;
        border: none;
    }

    button:hover {
        background-color: #00acc1;
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
            transform: translateY(30px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="edit-form-container">
    <h3 class="text-center mb-4">Edit User</h3>
    <form method="POST" action="user_edit.php">
        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="tel" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Message</label>
            <input type="text" name="message" class="form-control" value="<?= htmlspecialchars($user['message']) ?>" required>
        </div>

        <button type="submit" class="btn btn-info w-100">Update</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>