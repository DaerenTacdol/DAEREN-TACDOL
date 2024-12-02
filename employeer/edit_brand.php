<?php
include 'db.php';

// Check if the ID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// Fetch the existing brand data
$sql = "SELECT * FROM brands WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "No brand found with the specified ID.";
    exit();
}

$brand = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $country = $_POST['country'];
    $founded_year = $_POST['founded_year'];
    $website = $_POST['website'];

    // Prepare and bind
    $update_stmt = $conn->prepare("UPDATE brands SET name = ?, country = ?, founded_year = ?, website = ? WHERE id = ?");
    $update_stmt->bind_param("ssisi", $name, $country, $founded_year, $website, $id);

    if ($update_stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $update_stmt->error;
    }

    $update_stmt->close();
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Watch Brand</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
    <link rel="stylesheet" href="style.css"> <!-- Optional: Include your CSS file -->
</head>
<body>

    <div class="columns">
        <!-- Sidebar -->
        <aside class="menu column is-3">
            <p class="menu-label">
                Navigation
            </p>
            <ul class="menu-list">
                <li><a href="index.php">Brand List</a></li>
                <li><a href="add_brand.php">Add Brand</a></li>
                <li><a href="edit_brand.php">Edit Brand</a></li>
                <li><a href="about.php">About</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="column is-9">
            <h1 class="title">Edit Watch Brand</h1>
            <form method="post">
                <div class="field">
                    <label class="label" for="name">Name:</label>
                    <div class="control">
                        <input class="input" type="text" id="name" name="name" value="<?php echo htmlspecialchars($brand['name']); ?>" required>
                    </div>
                </div>
                
                <div class="field">
                    <label class="label" for="country">Country:</label>
                    <div class="control">
                        <input class="input" type="text" id="country" name="country" value="<?php echo htmlspecialchars($brand['country']); ?>" required>
                    </div>
                </div>
                
                <div class="field">
                    <label class="label" for="founded_year">Founded Year:</label>
                    <div class="control">
                        <input class="input" type="number" id="founded_year" name="founded_year" value="<?php echo htmlspecialchars($brand['founded_year']); ?>" min="1800" max="<?php echo date("Y"); ?>">
                    </div>
                </div>
                
                <div class="field">
                    <label class="label" for="website">Website:</label>
                    <div class="control">
                        <input class="input" type="url" id="website" name="website" value="<?php echo htmlspecialchars($brand['website']); ?>">
                    </div>
                </div>
                
                <div class="field">
                    <div class="control">
                        <input class="button is-primary" type="submit" value="Update Brand">
                    </div>
                </div>
            </form>
            <br>
            <a class="button is-link" href="index.php">Back to Brand List</a>
        </div>
    </div>

    <?php $conn->close(); ?>
</body>
</html>