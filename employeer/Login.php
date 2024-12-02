<?php
// Start the session
session_start();

// Include database connection
include 'db.php';

$username = "";
$password = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate input
    if (empty($username) || empty($password)) {
        $error = "Username and password are required.";
    } else {
        // Prepare SQL query to prevent SQL injection
        $query = "SELECT * FROM tacdol WHERE username = ?"; // Ensure this matches the registration table
        $stmt = $conn->prepare($query);
        
        if ($stmt === false) {
            die('MySQL prepare error: ' . htmlspecialchars($conn->error));
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Directly compare the plain text password
            if ($password === $user['password']) {
                // Password is correct, set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                // Redirect to a protected page
                header("Location: Index.php");
                exit();
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "Invalid username or password.";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
    <style>
        body {
            background-color: #f4f4f4; /* Light background color */
        }
        .container {
            margin-top: 50px;
            max-width: 400px;
            background-color: #fff; /* White background for the form */
            padding: 20px;
            border-radius:  8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title has-text-centered">Login</h1>
        <?php if (!empty($error)): ?>
            <div class="notification is-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        <form method="post">
            <div class="field">
                <label class="label" for="username">Username:</label>
                <div class="control">
                    <input class="input" type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                </div>
            </div>

            <div class="field">
                <label class="label" for="password">Password:</label>
                <div class="control">
                    <input class="input" type="password" id="password" name="password" required>
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <button class="button is-primary" type="submit">Login</button>
                </div>
            </div>
        </form>
        <p class="has-text-centered">
            <a href="Registration.php">Don't have an account? Register here.</a>
        </p>
    </div>
</body>
</html>