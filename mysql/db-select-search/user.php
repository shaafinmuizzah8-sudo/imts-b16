<?php
include '../db-search/conex.php';

$db = $myDB ?? ($conn ?? null);
if (!$db instanceof PDO) {
    http_response_code(500);
    exit('Database connection is unavailable.');
}

$id = filter_var($_GET['q'] ?? null, FILTER_VALIDATE_INT);
if ($id === false || $id <= 0) {
    http_response_code(400);
    exit('Invalid user ID.');
}

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

try {
    $stmt = $db->prepare(
        'SELECT id, firstname, lastname, email, reg_date
           FROM users
           WHERE id = :id'
    );
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    http_response_code(500);
    exit('Unable to load user.');
}

if ($user === false) {
    echo '<p>User not found.</p>';
    exit;
}

echo '<table>';
echo '<tr><th>ID</th><th>Firstname</th><th>Lastname</th><th>Email</th><th>Registration Date</th></tr>';
echo '<tr>';
echo '<td>' . (int) $user['id'] . '</td>';
echo '<td>' . e($user['firstname']) . '</td>';
echo '<td>' . e($user['lastname']) . '</td>';
echo '<td>' . e($user['email']) . '</td>';
echo '<td>' . e($user['reg_date']) . '</td>';
echo '</tr>';
echo '</table>';
