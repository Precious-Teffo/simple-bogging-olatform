<?php
// Include database connection file
require_once 'db_connection.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    // Redirect to login page
    header('Location: login.php');
    exit;
}

// Get post ID from URL
$post_id = $_GET['id'];

// Retrieve post data from database
$query = "SELECT * FROM posts WHERE id = '$post_id'";
$result = mysqli_query($conn, $query);
$post = mysqli_fetch_assoc($result);

// Check if post exists
if (!$post) {
    // Redirect to dashboard
    header('Location: dashboard.php');
    exit;
}

// Retrieve comments for post from database
$query = "SELECT * FROM comments WHERE post_id = '$post_id'";
$result = mysqli_query($conn, $query);
$comments = '';
while ($row = mysqli_fetch_assoc($result)) {
    $comments .= '<p><strong>' . $row['author'] . ':</strong> ' . $row['comment'] . '</p>';
}

// Check if form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $comment = $_POST['comment'];

    // Validate form data
    if (empty($comment)) {
        $error = 'Please enter a comment.';
    } else {
        // Insert comment into database
        $query = "INSERT INTO comments (post_id, author, comment) VALUES ('$post_id', '" . $_SESSION['username'] . "', '$comment')";
        if (mysqli_query($conn, $query)) {
            // Redirect to comments page
            header('Location: comments.php?id=' . $post_id);
            exit;
        } else {
            $error = 'Error adding comment.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
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

        textarea {
            width: 100%;
            height: 100px;
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
    <h1>Comments for <?php echo $post['title']; ?></h1>
    <?php echo $comments; ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $post_id; ?>" method="post">
        <?php if (isset($error)) { echo '<p style="color: red;">' . $error . '</p>'; } ?>
        <label for="comment">Add a comment:</label>
        <textarea id="comment" name="comment"></textarea><br><br>
        <button type="submit">Add Comment</button>
    </form>
</body>
</html>

