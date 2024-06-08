<?php
include 'config.php';
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

$sql = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: dashboard.php?message=Deleted successfully&status=warning");
    exit();
} else {
    // $message = "Error: " . $stmt->error;
    header("Location: dashboard.php?message=Failed to delete&status=danger");
    exit();
}

?>
