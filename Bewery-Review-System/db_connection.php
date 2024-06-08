<?php
$servername = "localhost"; 
$username = "if0_36693858"; 
$password = "themanisha"; 
$dbname = "if0_36693858_MyDB"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
