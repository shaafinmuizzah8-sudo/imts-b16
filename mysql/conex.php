<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "imts_1";

// Create connection
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    echo "Connected successfully|| DBName: " . $dbname . "<br>";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die;
}
