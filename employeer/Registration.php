<?php
// Start the session
session_start();

// Include database connection
require 'db.php'; // Ensure you have a file for database connection

$username = "";
$password = "";
$error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from POST request
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate input
    if (empty($username) || empty($password)) {
        $error = "All fields are required.";
    } else {
        // Check if the username already exists
        $query = "SELECT * FROM tacdol WHERE username = ?"; // Check in the tacdol table
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Username already exists.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user into the database
            $insert_query = "INSERT INTO tacdol (username, password) VALUES (?, ?)";
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->bind_param("ss", $username, $hashed_password);

            if ($insert_stmt->execute()) {
                // Registration successful, redirect to login page
                header("Location: Login.php");
                exit();
            } else {
                $error = "Error: Could not register user.";
            }
        }
    }
}

// Close the database connection
if (isset($conn)) {
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Register</title>
    <style>
        /* Basic reset */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f4f4f4; /* Light background color */
        }

        .container {
            background-color: #fff; /* White background for the form */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px; /* Set a fixed width for the form */
        }

        .field {
            margin-bottom: 15px;
        }

        .field input {
            width: 100%; /* Full width input */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn {
            background-color: #28a745; /* Green background for the button */
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        .btn:hover {
            background-color: #218838; /* Darker green on hover */
        }

        .link {
            text-align: center;
            margin-top: 10px;
        }

        .error {
            color: red; /* Red color for error messages */
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div class="container">
    <form action="" method="post">
        <h2 style="text-align: center;">Register</h2> <!-- Centering the title -->
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div> <!-- Display error message -->
        <?php endif; ?>
        <div class="field input">
            <label for="username"><b>Username</b></label>
            <input type="text" name="username" id="username" required> <!-- Only username field -->
        </div>
        <div class="field input">
            <label for="password"><b>Password</b></label>
            <input type="password" name="password" id="password" required> <!-- Only password field -->
        </div>
        <div class="field">
            <input type="submit" class="btn" name="submit" value="Register">
        </div>
        <div class="link">
            Already have an account? <a href="Login.php">Log In Now</a>
        </div>
    </form>
</div>
</body>
</html>