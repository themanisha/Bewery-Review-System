<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_BCRYPT);

    // Check if the username or email already exists
    $checkQuery = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        // Username or email already exists
        echo "<script>alert('Username or email already exists.'); window.location.href='signup.html';</script>";
    } else {
        // Insert new user into the database
        $insertQuery = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        if (mysqli_query($conn, $insertQuery)) {
            echo "<script>alert('Signup successful!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Error during signup. Please try again.'); window.location.href='signup.html';</script>";
        }
    }

    mysqli_close($conn);
}
?>
