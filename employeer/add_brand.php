<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $country = $_POST['country'];
    $founded_year = $_POST['founded_year'];
    $website = $_POST['website'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO brands (name, country, founded_year, website) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $name, $country, $founded_year, $website);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Watch Brand</title>
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
        <h2 class="title is-4">Navigation</h2>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="brands.php" class="is-active">Watch Brands</a></li>
            <li><a href="add_brand.php" class="is-active">Add Brand</a></li>
            <li><a href="gadgets.php">Gadgets</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </div>

    <!-- Main content -->
    <div class="column">
        <h1 class="title">Add Watch Brand</h1>
        <form method="post">
            <div class="field">
                <label class="label" for="name">Name:</label>
                <div class="control">
                    <input class="input" type="text" id="name" name="name" required>
                </div>
            </div>
            
            <div class="field">
                <label class="label" for="country">Country:</label>
                <div class="control">
                    <input class="input" type="text" id="country" name="country" required>
                </div>
            </div>
            
            <div class="field">
                <label class="label" for="founded_year">Founded Year:</label>
                <div class="control">
                    <input class="input" type="number" id="founded_year" name="founded_year" min="1800" max="<?php echo date("Y"); ?>" required>
                </div>
            </div>
            
            <div class="field">
                <label class="label" for="website">Website:</label>
                <div class="control">
                    <input class="input" type="url" id="website" name="website">
                </div>
            </div>
            
            <div class="control">
                <input class="button is-primary" type="submit" value="Add Brand">
            </div>
        </form>
        <br>
        <a class="button is-link" href="index.php">Back to Brand List</a>
    </div>
</div>

<?php $conn->close(); ?>

</body>
</html>