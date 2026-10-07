<?php
include 'conex.php';

//insrert multiple records using prepared statements
try {
    $conn->beginTransaction();

    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email) 
    VALUES (:firstname, :lastname, :email)");

    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':email', $email);

    $data = [
        ["shaafin", "muizzah", "shaafinmuizzah8@gmail.com"],
        ["muizzah", "shadir", "muizzahshadir@gmail.com"],
        ["shaafin", "shadir", "shaafinshadir@gmail.com"]
    ];

    foreach ($data as $row) {
        $firstname = $row[0];
        $lastname = $row[1];
        $email = $row[2];
        $stmt->execute();
    }

    $conn->commit();
    echo "Records inserted successfully using prepared statements";
} catch (PDOException $e) {
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}
