<?php
include 'db.php';

// Check if the ID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// Prepare and bind
$stmt = $conn->prepare("DELETE FROM brands WHERE id = ?");
$stmt->bind_param("i", $id);

// Execute the statement
if ($stmt->execute()) {
    // Redirect to index.php after successful deletion
    header("Location: index.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>