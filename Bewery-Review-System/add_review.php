<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    echo "You need to be logged in to add a review.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brewery_id = mysqli_real_escape_string($conn, $_POST['brewery_id']);
    $rating = (int) $_POST['rating'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $user_id = $_SESSION['user_id'];
    $sql = "INSERT INTO reviews (brewery_id,id, rating, description) VALUES ('$brewery_id', '$user_id', '$rating', '$description')";

    if (mysqli_query($conn, $sql)) {
        header("Location: brewery_info.php?id=$brewery_id");
        echo "Review submitted successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
