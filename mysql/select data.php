<?php
include 'conex.php';

// select data from the users table
try {
    $stmt = $conn->prepare("SELECT * FROM users");
    $stmt->execute();

    $result = $stmt->fetchAll();
    foreach ($result as $row) {
        echo $row['id'] . "|";
        echo $row['firstname'] . "|";
        echo $row['lastname'] . "|";
        echo $row['email'] . "<br>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
