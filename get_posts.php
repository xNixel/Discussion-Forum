<?php
include 'db.php';

$sql = "SELECT p.id, p.content, p.created_at, u.username,
               (SELECT COUNT(*) FROM post_reactions WHERE post_id = p.id AND reaction = 'thumbs_up') AS thumbs_up_count,
               (SELECT COUNT(*) FROM post_reactions WHERE post_id = p.id AND reaction = 'thumbs_down') AS thumbs_down_count
        FROM posts p
        JOIN users u ON p.user_id = u.id
        ORDER BY p.created_at DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='post'>";
        echo "<h4>" . $row['username'] . " posted at " . $row['created_at'] . "</h4>";
        echo "<p>" . $row['content'] . "</p>";
        
        // Display reactions (thumbs-up/down)
        echo "<div class='reactionButtons'>";
        echo "<button class='thumbsUpButton' data-post-id='" . $row['id'] . "' data-reaction='thumbs_up'>👍 (" . $row['thumbs_up_count'] . ")</button>";
        echo "<button class='thumbsDownButton' data-post-id='" . $row['id'] . "' data-reaction='thumbs_down'>👎 (" . $row['thumbs_down_count'] . ")</button>";
        echo "</div>";

        // Reply form for each post
        echo "<form class='replyForm' data-post-id='" . $row['id'] . "' method='POST'>";
        echo "<textarea placeholder='Write a reply...' required></textarea>";
        echo "<button type='submit'>Reply</button>";
        echo "</form>";

        // Fetch and display replies for each post
        $replies_sql = "SELECT r.content, r.created_at, u.username 
                        FROM replies r
                        JOIN users u ON r.user_id = u.id
                        WHERE r.post_id = " . $row['id'] . "
                        ORDER BY r.created_at ASC";
        $replies_result = $conn->query($replies_sql);

        if ($replies_result->num_rows > 0) {
            echo "<div class='replies'>";
            while ($reply = $replies_result->fetch_assoc()) {
                echo "<div class='reply'>";
                echo "<p><strong>" . $reply['username'] . ":</strong> " . $reply['content'] . " <em>at " . $reply['created_at'] . "</em></p>";
                echo "</div>";
            }
            echo "</div>";
        }

        echo "</div>";
    }
} else {
    echo "No posts found";
}

$conn->close();
?>
