<?php
// Include database connection file
require_once 'db_connection.php';

// Start session
session_start();

// Check if user is logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    // Display dashboard link for logged-in users
    $dashboard_link = '<a href="dashboard.php">Dashboard</a>';
} else {
    // Display login and register links for non-logged-in users
    $dashboard_link = '<a href="login.php">Login</a> | <a href="register.php">Register</a>';
}

// Retrieve latest blog posts from database
$query = "SELECT * FROM posts ORDER BY id DESC LIMIT 5";
$result = mysqli_query($conn, $query);

// Check if query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Display latest blog posts
$posts = '';
while ($row = mysqli_fetch_assoc($result)) {
    $posts .= '<article class="post">
                    <h2><a href="post.php?id=' . $row['id'] . '">' . $row['title'] . '</a></h2>
                    <p>' . $row['content'] . '</p>
                </article>';
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Blogging Platform</title>
    <style>
        /* Global Styles */

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
        }

        /* Header Styles */

        header {
            background-color: #333;
            color: #fff;
            padding: 1em;
            text-align: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        header nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header nav ul li {
            margin-right: 20px;
        }

        header nav a {
            color: #fff;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        header nav a:hover {
            color: #ccc;
        }

        /* Main Styles */

        main {
            display: block;
            margin: 4em auto;
            padding: 2em;
            width: 80%;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Post Styles */

        .post {
            margin-bottom: 2em;
        }

        .post h2 {
            margin-top: 0;
        }

        .post p {
            margin-bottom: 1em;
        }

        /* Footer Styles */

        footer {
            background-color: #333;
            color: #fff;
            padding: 1em;
            text-align: center;
            clear: both;
            position: relative;
            bottom: 0;
            left: 0;
            width: 100%;
        }

        footer p {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><?php echo $dashboard_link; ?></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Latest Blog Posts</h1>
        <?php echo $posts; ?>
    </main>
    <footer>
        <p>&copy; 2024 Simple Blogging Platform</p>
    </footer>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Blogging Platform</title>
    <style>
        /* Global Styles */

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
        }

        /* Header Styles */

        header {
            background-color: #333;
            color: #fff;
            padding: 1em;
            text-align: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        header nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header nav ul li {
            margin-right: 20px;
        }

        header nav a {
            color: #fff;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        header nav a:hover {
            color: #ccc;
        }

        /* Main Styles */

        main {
            display: block;
            margin: 4em auto;
            padding: 2em;
            width: 80%;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Post Styles */

        .post {
            margin-bottom: 2em;
        }

        .post h2 {
            margin-top: 0;
        }

        .post p {
            margin-bottom: 1em;
        }

        /* Footer Styles */

        footer {
            background-color: #333;
            color: #fff;
            padding: 1em;
            text-align: center;
            clear: both;
            position: relative;
            bottom: 0;
            left: 0;
            width: 100%;
        }

        footer p {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><?php echo $dashboard_link; ?></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Latest Blog Posts</h1>
        <?php echo $posts; ?>
    </main>
    <footer>
        <p>&copy; 2024 Simple Blogging Platform</p>
    </footer>
</body>
</html>