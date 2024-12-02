<?php
// Start the session
session_start();

// Include your database connection file
include "db.php"; 

// Initialize variables
$gadget = null;

// Check if we are editing a gadget
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Prepare the SQL statement to fetch the gadget
    $sql = "SELECT * FROM gadgets WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $gadget = $result->fetch_assoc();
        } else {
            echo "No gadget found with that ID.";
            exit();
        }
        $stmt->close();
    }
}

// Handle form submission for adding or updating a gadget
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    
    // Check if we are updating or inserting
    if (isset($_POST['id']) && $_POST['id'] != '') {
        // Update existing gadget
        $sql = "UPDATE Gadgets SET name = ?, brand = ?, category = ?, price = ? WHERE id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssssi", $name, $brand, $category, $price, $_POST['id']);
            $stmt->execute();
            $stmt->close();
            header("Location: Gadgets.php"); // Redirect after update
            exit();
        }
    } else {
        // Insert new gadget
        $sql = "INSERT INTO gadgets (name, brand, category, price) VALUES (?, ?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssd", $name, $brand, $category, $price);
            $stmt->execute();
            $stmt->close();
            header("Location: Gadgets.php"); // Redirect after insert
            exit();
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gadgets Database</title>
    <!-- Include Bulma CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
    <style>
        /* Custom styles for the sidebar */
        .sidebar {
            background-color: #f5f5f5;
            padding: 20px;
            height: 100vh;
        }
    </style>
</head>
<body>

<div class="columns">
    <!-- Sidebar -->
    <div class="column is-one-fifth sidebar">
        <h2 class="title is-4">Menu</h2>
        <ul>
            <li><a href="Index.php">Home</a></li>
            <li><a href="Gadgets.php">Gadgets</a></li>
        </ul>
    </div>

    <!-- Main content -->
    <div class="column">
        <h1 class="title">Watch Center</h1>

        <form method="POST">
            <input type="hidden" name="id" value="<?= isset($gadget) ? $gadget['id'] : '' ?>">
            <div class="field">
                <label class="label">Watch Name</label>
                <div class="control">
                    <input class="input" type="text" name="name" placeholder="Watch Name" value="<?= isset($gadget) ? htmlspecialchars($gadget['name']) : '' ?>" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Brand</label>
                <div class="control">
                    <input class="input" type="text" name="brand" placeholder="Brand" value="<?= isset($gadget) ? htmlspecialchars($gadget['brand']) : '' ?>" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Category</label>
                <div class="control">
                    <input class="input" type="text" name="category" placeholder="Category" value="<?= isset($gadget) ? htmlspecialchars($gadget['category']) : '' ?>" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Price</label>
                <div class="control">
                    <input class="input" type="number" name="price" placeholder="Price" value="<?= isset($gadget) ? htmlspecialchars($gadget['price']) : '' ?>" required step="0.01">
                </div>
            </div>
            <div class="control">
                <input class="button is-primary" type="submit" name="submit" value="Save Gadget">
            </div>
        </form>

        <br>
        <a class="button is-link" href="Index.php">Back to Home</a>
    </div>
</div>

</body>
</html>