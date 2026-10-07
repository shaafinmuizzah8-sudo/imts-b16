<?php
include 'conex.php';

//delete data
try {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute([':id' => 1]); // delete user with id 1
    echo "Records deleted successfully";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
