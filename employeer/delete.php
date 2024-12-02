<?php
// delete.php
include 'db.php';

$id = $_GET['id'];
$sql = "DELETE FROM persons WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("location:./Gadgets.php");
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
