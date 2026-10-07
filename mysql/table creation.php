<?php include 'conex.php';

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
