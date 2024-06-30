<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_id'];
    $reaction = $_POST['reaction'];

    // Check if the user has already reacted to the post
    $check_sql = "SELECT * FROM post_reactions WHERE post_id='$post_id' AND user_id='$user_id'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        // User has already reacted, update the existing reaction
        $update_sql = "UPDATE post_reactions SET reaction='$reaction' WHERE post_id='$post_id' AND user_id='$user_id'";
        if ($conn->query($update_sql) === TRUE) {
            echo "Reaction updated successfully";
        } else {
            echo "Error updating reaction: " . $conn->error;
        }
    } else {
        // User has not reacted yet, insert new reaction
        $insert_sql = "INSERT INTO post_reactions (post_id, user_id, reaction) VALUES ('$post_id', '$user_id', '$reaction')";
        if ($conn->query($insert_sql) === TRUE) {
            echo "Reaction added successfully";
        } else {
            echo "Error adding reaction: " . $conn->error;
        }
    }

    $conn->close();
}
?>
