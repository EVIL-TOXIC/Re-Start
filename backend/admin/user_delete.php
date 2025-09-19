<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
$conn = new mysqli("localhost", "root", "", "restart");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM users WHERE id = $id");
}

header("Location: dashboard.php");
exit;
