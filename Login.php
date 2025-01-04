<?php
// Include database connection file
require_once 'db_connection.php';

// Check if form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate form data
    if (empty($username) || empty($password)) {
        $error = 'Please fill in all fields.';
    } else {
        // Retrieve user from database
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Start session
                session_start();
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $username;
                // Redirect to dashboard
                header('Location: dashboard.php');
                exit;
            } else {
                $error = 'Invalid password.';
            }
        } else {
            $error = 'Invalid username.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Basic Styles */
        body {
            font-family: Arial, sans-serif;
        }

        form {
            width: 50%;
            margin: 40px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            height: 40px;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button[type="submit"] {
            width: 100%;
            height: 40px;
            background-color: #4CAF50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <h2>Login</h2>
        <?php if (isset($error)) { echo '<p style="color: red;">' . $error . '</p>'; } ?>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username"><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password"><br><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>