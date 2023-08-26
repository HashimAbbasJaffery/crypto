<?php
$servername = "localhost";
$username = "mirrorpool_project";
$password = "pk%GhIFQl-1s";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>