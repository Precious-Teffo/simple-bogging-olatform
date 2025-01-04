<?php
// Include database connection file
require_once 'db_connection.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    // Redirect to login page
    header('Location: login.php');
    exit;
}

// Retrieve user data from database
$query = "SELECT * FROM users WHERE username = '" . $_SESSION['username'] . "'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Check if form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Validate form data
    if (empty($title) || empty($content)) {
        $error = 'Please fill in all fields.';
    } else {
        // Insert post into database
        $query = "INSERT INTO posts (title, content, author_id) VALUES ('$title', '$content', '" . $user['id'] . "')";
        if (mysqli_query($conn, $query)) {
            // Redirect to dashboard
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Error creating post.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
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

        input[type="text"], textarea {
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
        <h2>Create Post</h2>
        <?php if (isset($error)) { echo '<p style="color: red;">' . $error . '</p>'; } ?>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title"><br><br>
        <label for="content">Content:</label>
        <textarea id="content" name="content"></textarea><br><br>
        <button type="submit">Create Post</button>
    </form>
</body>
</html>