<?php
$host = 'localhost';
$user = 'root';
$pass = ''; // 👈 leave this empty
$dbname = 'livestock_management';

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
