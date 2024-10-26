<?php 
$host = 'localhost'; // Your MySQL host
$dbname = 'cms'; // Replace with your database name
$username = 'root'; // Your MySQL username
$password = ''; // Your MySQL password

// Create a connection to the MySQL database
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>