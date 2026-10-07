<?php
include 'conex.php';

// search bar
$search = trim($_GET['search'] ?? '');
echo "<form method='get'>";
echo "<input type='search' name='search' value='" .
    htmlspecialchars($search, ENT_QUOTES, 'UTF-8') . "' placeholder='Search users'>";
echo "<button type='submit'>Search</button>";
echo "</form>";

echo "<table border='1'>
<tr>
    <th>ID</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Email</th>
    <th>Registration Date</th>
</tr>";

try {
    if ($search !== '') {
        $stmt = $conn->prepare(
            "SELECT * FROM users
             WHERE firstname LIKE :first
                OR lastname  LIKE :last
                OR email     LIKE :email"
        );
        $like = '%' . $search . '%';
        $stmt->execute([
            ':first' => $like,
            ':last'  => $like,
            ':email' => $like,
        ]);
    } else {
        // no search term: show everyone
        $stmt = $conn->query("SELECT * FROM users");
    }

    $result = $stmt->fetchAll();

    if (count($result) === 0) {
        echo "<tr><td colspan='5'>No users found</td></tr>";
    }

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
    echo "<tr><td colspan='5'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
}
echo "</table>";
