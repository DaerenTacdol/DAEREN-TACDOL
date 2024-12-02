<?php
include 'db.php';

$sql = "SELECT * FROM brands";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Watch Brand Database</title>
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
            <li><a href="Index.php">Home</a></li>
            <li><a href="Gadgets.php">Gadgets</a></li>
        </ul>
    </div>

    <!-- Main content -->
    <div class="column">
        <h1 class="title">Watch Brands</h1>
        <a class="button is-primary" href="add_brand.php">Add New Brand</a>
        <table class="table is-striped is-fullwidth">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Country</th>
                    <th>Founded Year</th>
                    <th>Website</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["id"] . "</td>
                                <td>" . htmlspecialchars($row["name"]) . "</td>
                                <td>" . htmlspecialchars($row["country"]) . "</td>
                                <td>" . htmlspecialchars($row["founded_year"]) . "</td>
                                <td><a href='" . htmlspecialchars($row["website"]) . "' target='_blank'>" . htmlspecialchars($row["website"]) . "</a></td>
                                <td>
                                    <a class='button is-small is-info' href='edit_brand.php?id=" . $row["id"] . "'>Edit</a>
                                    <a class='button is-small is-danger' href='delete_brand.php?id=" . $row["id"] . "' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No brands found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php $conn->close(); ?>

</body>
</html>