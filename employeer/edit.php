<!-- edit.php -->
<?php
include 'db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM persons WHERE id=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Record</title>
</head>
<body>
    <h2>Edit Record</h2>
    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        
        <label>Full Name:</label>
        <input type="text" name="full_name" value="<?php echo $row['full_name']; ?>"><br>

        <label>Date of Birth:</label>
        <input type="date" name="date_of_birth" value="<?php echo $row['date_of_birth']; ?>"><br>

        <label>Place of Birth:</label>
        <input type="text" name="place_of_birth" value="<?php echo $row['place_of_birth']; ?>"><br>

        <label>Nationality:</label>
        <input type="text" name="nationality" value="<?php echo $row['nationality']; ?>"><br>

        <label>Education:</label>
        <input type="text" name="education" value="<?php echo $row['education']; ?>"><br>

        <label>Marital Status:</label>
        <input type="text" name="marital_status" value="<?php echo $row['marital_status']; ?>"><br>

        <label>Address:</label>
        <textarea name="address" value="<?php echo $row['address']; ?>"></textarea><br>

        <label>Age:</label>
        <input type="number" name="age" value="<?php echo $row['age']; ?>"><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>
