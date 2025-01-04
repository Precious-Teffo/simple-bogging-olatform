<?php
// Include database connection file
require_once 'db_connection.php';

// Check if form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate form data
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = 'Please fill in all fields.';
    } elseif ($password != $confirm_password) {
        $error = 'Passwords do not match.';
    } else {
        // Check if username is already taken
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $error = 'Username is already taken.';
        } else {
            // Hash password
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // Insert user into database
            $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password_hash')";
            if (mysqli_query($conn, $query)) {
                // Redirect to login page
                header('Location: login.php');
                exit;
            } else {
                $error = 'Error registering user.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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

        input[type="text"], input[type="email"], input[type="password"] {
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
        <h2>Register</h2>
        <?php if (isset($error)) { echo '<p style="color: red;">' . $error . '</p>'; } ?>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username"><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email"><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password"><br><br>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password"><br><br>
        <button type="submit">Register</button>
    </form>
</body>
</html>
