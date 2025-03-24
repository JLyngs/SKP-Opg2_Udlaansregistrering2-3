<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'computer_loan_system';

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>