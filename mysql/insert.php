<?php
include 'conex.php';

$tableName = "users";
$stmt = $conn->query("SHOW TABLES LIKE '$tableName'");
if ($stmt->rowCount() == 0) {
    $sql = "CREATE TABLE users (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(30) NOT NULL,
            lastname VARCHAR(30) NOT NULL,
            email VARCHAR(50),
            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

    try {
        $conn->exec($sql);
        echo "Table '$tableName' created successfully<br>";
    } catch (PDOException $e) {
        echo "Error creating table: " . $e->getMessage();
    }
} else {
    echo "Table '$tableName' already exists<br>";
}

try {
    $sql = "INSERT INTO users (firstname, lastname, email) 
    VALUES ( 'shaafin', 'muizzah', 'shaafinmuizzah8@gmail.com' )";

    $conn->exec($sql);

    $last_id = $conn->lastInsertId();

    echo "New record created successfully <br>";
    echo "record id is:" . $last_id;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

echo "<br><br><br><br>";


//multiple insert
try {
    $conn->beginTransaction();
    $conn->exec("INSERT INTO users (firstname, lastname, email) 
    VALUES ('muizzah', 'shadir', 'muizzahshadir@gmail.com')");

    $conn->exec("INSERT INTO users (firstname, lastname, email) 
    VALUES ('shaafin', 'shadir', 'shaafinshadir@gmail.com')");

    $conn->exec("INSERT INTO users (firstname, lastname, email) 
    VALUES ('shaafin', 'muizzah', 'shaafinmuizzah8@gmail.com')");

    $conn->commit();
    echo "Records inserted successfully";
} catch (PDOException $e) {
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

$conn = null;
