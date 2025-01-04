<?php
// Include database connection file
require_once 'db_connection.php';

// Check if search query is set
if (!isset($_GET['query'])) {
    // Redirect to homepage
    header('Location: index.php');
    exit;
}

// Get search query from URL
$query = $_GET['query'];

// Retrieve search results from database
$query = "SELECT * FROM posts WHERE title LIKE '%$query%' OR content LIKE '%$query%'";
$result = mysqli_query($conn, $query);
$results = '';
while ($row = mysqli_fetch_assoc($result)) {
    $results .= '<article class="post">
                    <h2><a href="post.php?id=' . $row['id'] . '">' . $row['title'] . '</a></h2>
                    <p>' . $row['content'] . '</p>
                </article>';
}

// Check if search results are empty
if (empty($results)) {
    $results = '<p>No search results found.</p>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
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
        <h1>Search Results</h1>
    </header>
    <main>
        <?php echo $results; ?>
    </main>
</body>
</html>



