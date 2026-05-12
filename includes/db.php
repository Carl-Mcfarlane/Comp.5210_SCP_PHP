<?php
// Database connection credentials
$host = 'localhost';
$dbname = 'a9975352_scp_database';
$username = 'a9975352_Carl';
$password = 'Toiohomai1234';

try {
    // Create a new PDO connection with UTF-8 charset
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Set error mode to throw exceptions on failure
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Display error message if connection fails
    die("Connection failed: " . $e->getMessage());
}
?>