<?php
$servername = "localhost";
$user = "root";
$password = "";
$db = "chat_web";

// Create connection
$conn = new mysqli($servername, $user, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>