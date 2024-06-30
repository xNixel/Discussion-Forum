<?php
include 'db.php'; // Include the database connection script

session_start(); // Start the session to manage user sessions

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $content = $_POST['content'];

        $sql = "INSERT INTO posts (user_id, content) VALUES ('$user_id', '$content')";

        if ($conn->query($sql) === TRUE) {
            // Redirect back to index.html after successful post
            header("Location: index.html");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Please log in to post";
    }

    $conn->close();
}
?>
