<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $content = $_POST['content'];

        $sql = "INSERT INTO posts (user_id, content) VALUES ('$user_id', '$content')";

        if ($conn->query($sql) === TRUE) {
            echo "Post added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Please log in to post";
    }

    $conn->close();
}
?>
