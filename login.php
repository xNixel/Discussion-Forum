<?php
include 'db.php'; // Include the database connection script

session_start(); // Start the session to manage user sessions

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL query to fetch user details from `users` table
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, start a new session and store user_id
            $_SESSION['user_id'] = $row['id'];
            // Redirect to index.html upon successful login
            header("Location: index.html");
            exit(); // Ensure script execution stops after redirect
        } else {
            echo "Invalid password"; // Output message for incorrect password
        }
    } else {
        echo "No user found"; // Output message if no user found with given username
    }

    $conn->close(); // Close the database connection
}
?>
