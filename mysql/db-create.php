<?php
// Create database
$servername = "localhost";
$username = "root";
$password = "";
try {
    $conn = new PDO("mysql:host=$servername", $username, $password);

    $sql = "CREATE DATABASE imts_2";
    $conn->exec($sql);
    echo "Database created successfully<br>";
} catch (PDOException $e) {
    echo "Error creating database: " . $e->getMessage();
}

$conn = null;
