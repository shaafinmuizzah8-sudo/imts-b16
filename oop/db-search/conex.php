<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "imts_1";

try {
    $myDB = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die;
}
