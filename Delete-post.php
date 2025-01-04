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

// Check if post exists and belongs to current user
if (!$post || $post['author_id'] != $_SESSION['user_id']) {
    // Redirect to dashboard
    header('Location: dashboard.php');
    exit;
}

// Delete post from database
$query = "DELETE FROM posts WHERE id = '$post_id'";
if (mysqli_query($conn, $query)) {
    // Redirect to dashboard
    header('Location: dashboard.php');
    exit;
} else {
    echo 'Error deleting post.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Post</title>
</head>
<body>
    <h1>Delete Post</h1>
    <p>Are you sure you want to delete this post?</p>
    <p><a href="delete_post.php?id=<?php echo $post_id; ?>">Yes, delete post</a></p>
</body>
</html>