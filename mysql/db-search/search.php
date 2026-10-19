<?php

// Connect to the database.
require 'conex.php';

if (!$myDB instanceof PDO) {
    http_response_code(500);
    exit('Database connection is unavailable.');
}

// Escape database values before showing them in HTML.
function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

// Find users whose name or email contains the search text.
function searchUsers(PDO $db, string $search, int $limit, int $offset): array
{
    $term = "%{$search}%";
    $query = $db->prepare(
        'SELECT id, firstname, lastname, email, reg_date
         FROM users
         WHERE firstname LIKE :firstname
            OR lastname LIKE :lastname
            OR email LIKE :email
         ORDER BY id DESC
         LIMIT :limit OFFSET :offset'
    );
    $query->bindValue('firstname', $term, PDO::PARAM_STR);
    $query->bindValue('lastname', $term, PDO::PARAM_STR);
    $query->bindValue('email', $term, PDO::PARAM_STR);
    $query->bindValue('limit', $limit, PDO::PARAM_INT);
    $query->bindValue('offset', $offset, PDO::PARAM_INT);
    $query->execute();

    return $query->fetchAll(PDO::FETCH_ASSOC);
}

// Count all matching users so we know how many pages to display.
function countUsers(PDO $db, string $search): int
{
    $term = "%{$search}%";
    $query = $db->prepare(
        'SELECT COUNT(*)
         FROM users
         WHERE firstname LIKE :firstname
            OR lastname LIKE :lastname
            OR email LIKE :email'
    );
    $query->execute([
        'firstname' => $term,
        'lastname' => $term,
        'email' => $term,
    ]);

    return (int) $query->fetchColumn();
}

try {
    // Delete the selected user when the Delete button is submitted.
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
        $id = filter_var($_POST['delete_id'], FILTER_VALIDATE_INT);

        if ($id === false || $id < 1) {
            http_response_code(400);
            exit('Invalid user ID.');
        }

        $query = $myDB->prepare('DELETE FROM users WHERE id = :id');
        $query->execute(['id' => $id]);
        header('Location: index.php');
        exit;
    }

    // Read the search text and get matching users.
    $search = trim((string) ($_GET['search'] ?? ''));
    $page = filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT);
    $page = $page !== false && $page > 0 ? $page : 1;
    $perPage = 5;
    $totalUsers = countUsers($myDB, $search);
    $totalPages = max(1, (int) ceil($totalUsers / $perPage));
    $page = min($page, $totalPages);
    $users = searchUsers($myDB, $search, $perPage, ($page - 1) * $perPage);
    //
} catch (PDOException $exception) {
    http_response_code(500);
    exit('Unable to search users.');
}

// Print one table row for every matching user.
$rows = '';
foreach ($users as $user) {
    $id = (int) $user['id'];
    $rows .= '<tr>';
    $rows .= '<td>' . $id . '</td>';
    $rows .= '<td>' . escape((string) $user['firstname']) . '</td>';
    $rows .= '<td>' . escape((string) $user['lastname']) . '</td>';
    $rows .= '<td>' . escape((string) $user['email']) . '</td>';
    $rows .= '<td>' . escape((string) $user['reg_date']) . '</td>';
    $rows .= '<td><div class="actions">';
    $rows .= '<a class="edit-link" href="edit.php?id=' . $id . '">Edit</a>';
    $rows .= '<form method="post" action="search.php" onsubmit="return confirm(\'Are you sure you want to delete this user?\');">';
    $rows .= '<input type="hidden" name="delete_id" value="' . $id . '">';
    $rows .= '<button class="delete-button" type="submit">Delete</button>';
    $rows .= '</form></div></td>';
    $rows .= '</tr>';
}

if ($rows === '') {
    $rows = '<tr><td class="empty" colspan="6">No users found.</td></tr>';
}

$pagination = '';
for ($number = 1; $number <= $totalPages; $number++) {
    $active = $number === $page ? ' class="active"' : '';
    $pagination .= '<button' . $active . ' data-page="' . $number . '">' . $number . '</button>';
}

header('Content-Type: application/json');
echo json_encode([
    'rows' => $rows,
    'pagination' => $pagination,
]);
