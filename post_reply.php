<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_id'];
    $content = $_POST['content'];

    $sql = "INSERT INTO replies (post_id, user_id, content) VALUES ('$post_id', '$user_id', '$content')";

    if ($conn->query($sql) === TRUE) {
        echo "Reply added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
