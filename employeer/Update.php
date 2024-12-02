<?php
// update.php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $Brand = $_POST['Brand'];
    $Price = $_POST['Price'];
    $Year = $_POST['Year'];
    $Color = $_POST['Color'];

    $sql = "UPDATE `guest` SET `Brand`='$Brand',`Price`='$Price',`Year`='$Year',`Color`='$Color' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}
?>