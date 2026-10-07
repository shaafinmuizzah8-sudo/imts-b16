<?php
include 'conex.php';

// select data from the users table
echo "<table border='1'>
<tr>
    <th>ID</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Email</th>
    <th>Registration Date</th>
</tr>";

try {
    $stmt = $conn->prepare("SELECT * FROM users where lastname = :lastname");
    $stmt->execute([':lastname' => 'muizzah']);

    $result = $stmt->fetchAll();
    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['firstname'] . "</td>";
        echo "<td>" . $row['lastname'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['reg_date'] . "</td>";
        echo "</tr>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
echo "</table>";
