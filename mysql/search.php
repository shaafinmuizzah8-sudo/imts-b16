<?php include 'conex.php';

$search = trim($_GET['search'] ?? '');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = filter_var($_POST['delete_id'], FILTER_VALIDATE_INT);
    if ($deleteId !== false && $deleteId > 0) {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute([':id' => $deleteId]);
    }
}

echo "<form method='get'>";
echo "<input type='search' name='search' placeholder='Search users' value='" . htmlspecialchars($search, ENT_QUOTES, 'UTF-8') . "'>";
echo "<button type='submit'>Search</button>";
echo "</form>";

echo "<a href='create.php'>Create User</a> <br><br>";

echo "<table border='1' cellpadding='10' cellspacing='0'>";
echo "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th>
    <th>Registration Date</th>
    <th>Action</th></tr>";

try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE firstname LIKE :search OR lastname LIKE :search OR email LIKE :search ORDER BY reg_date DESC");
    $stmt->execute(['search' => "%$search%"]);
    $result = $stmt->fetchAll();
    if (empty($result)) {
        echo "<tr><td colspan='6'>No users found</td></tr>";
    } else {
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['firstname'] . "</td>";
            echo "<td>" . $row['lastname'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['reg_date'] . "</td>";
            echo "<td>";
            // Add a link to edit the user
            echo "<a href='edit.php?id=" . (int) $row['id'] . "'>Edit</a><br><br>";

            // Add a form to delete the user with confirmation
            echo "<form method='post' 
        onsubmit=\"return confirm('Are you sure you want to delete this user?');\">";
            echo "<input type='hidden' name='delete_id' value='" . (int) $row['id'] . "'>";
            echo "<button type='submit'>Delete</button>";
            echo "</form>";

            echo "</td>";
            echo "</tr>";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
echo "</table>";
$conn = null;
