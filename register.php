<?php
include 'db.php'; // Include the database connection script

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password for security

    // Prepare SQL query to insert new user into `users` table
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to login page upon successful registration
        header("Location: login.html");
        exit(); // Ensure script execution stops after redirect
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error; // Output error message if there's an issue with SQL query execution
    }

    $conn->close(); // Close the database connection
}
?>
