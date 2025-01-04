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

// Retrieve user's posts from database
$query = "SELECT * FROM posts WHERE author_id = '" . $user['id'] . "'";
$result = mysqli_query($conn, $query);
$posts = '';
while ($row = mysqli_fetch_assoc($result)) {
    $posts .= '<article class="post">
                    <h2><a href="post.php?id=' . $row['id'] . '">' . $row['title'] . '</a></h2>
                    <p>' . $row['content'] . '</p>
                </article>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        /* Basic Styles */
        body {
            font-family: Arial, sans-serif;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 1em;
            text-align: center;
        }

        main {
            display: block;
            margin: 2em auto;
            padding: 1em;
            width: 80%;
        }

        .post {
            margin-bottom: 2em;
        }
    </style>
</head>
<body>
    <header>
        <h1>Profile</h1>
    </header>
    <main>
        <h2><?php echo $user['username']; ?></h2>
        <p>Email: <?php echo $user['email']; ?></p>
        <h2>My Posts</h2>
        <?php echo $posts; ?>
    </main>
</body>
</html>
