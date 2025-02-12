<?php
$servername   = "localhost";
$database = "rommel_photography ";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
  echo"". $conn->connect_error;
   die("Connection failed: " . $conn->connect_error);
}
  echo "Connected successfully";
?>