<?php
include 'conex.php';

// Use the connection created by conex.php and stop before calling methods on
// a null value. The fallback also supports connection files using $conn.
$db = $myDB ?? ($conn ?? null);
if (!($conn instanceof PDO)) {
    exit('Database connection is unavailable.');
}

// Read the optional search value from the query string.
$search = trim($_GET['search'] ?? '');
$page = filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT);
$page = ($page !== false && $page > 0) ? $page : 1;
$perPage = 4;

echo "<style>
    :root { color-scheme: light; font-family: Inter, Arial, sans-serif; }
    * { box-sizing: border-box; }
    body { margin: 0; padding: 32px 16px; background: #f4f7fb; color: #172033; }
    .page { max-width: 1100px; margin: 0 auto; }
    .header { display: flex; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 22px; }
    h1 { margin: 0; font-size: 28px; color: #172033; }
    .subtitle { margin: 6px 0 0; color: #68758a; font-size: 14px; }
    .card { background: #fff; border: 1px solid #e4eaf2; border-radius: 14px; box-shadow: 0 8px 24px rgba(31, 55, 90, .07); overflow: hidden; }
    .toolbar { display: flex; justify-content: space-between; align-items: center; gap: 12px; padding: 18px 20px; border-bottom: 1px solid #edf1f6; }
    .search { display: flex; flex: 1; max-width: 480px; gap: 8px; }
    input[type='search'] { width: 100%; padding: 10px 13px; border: 1px solid #d5deea; border-radius: 8px; font-size: 14px; outline: none; }
    input[type='search']:focus { border-color: #4779d1; box-shadow: 0 0 0 3px rgba(71, 121, 209, .14); }
    button, .button { border: 0; border-radius: 8px; padding: 10px 14px; font-size: 14px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-block; }
    .search button, .button-primary { background: #356dcc; color: #fff; }
    .search button:hover, .button-primary:hover { background: #285bb0; }
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    th { padding: 14px 18px; background: #f8fafc; color: #657389; font-size: 12px; text-align: left; text-transform: uppercase; letter-spacing: .04em; white-space: nowrap; }
    td { padding: 15px 18px; border-top: 1px solid #edf1f6; font-size: 14px; vertical-align: middle; }
    tr:hover td { background: #fbfcfe; }
    .actions { display: flex; align-items: center; gap: 12px; }
    .edit-link { padding: 7px 11px; border: 1px solid #c9d9f5; border-radius: 8px; background: #eef4ff; color: #285bb0; font-weight: 600; text-decoration: none; transition: .2s ease; }
    .edit-link:hover { background: #dce9ff; border-color: #9ebce9; transform: translateY(-1px); }
    .delete-button { padding: 7px 10px; background: #fff0f0; color: #c43d3d; }
    .delete-button:hover { background: #ffe0e0; }
    .empty { text-align: center; color: #68758a; padding: 32px 18px; }
    .pagination { display: flex; justify-content: center; gap: 6px; padding: 18px; border-top: 1px solid #edf1f6; }
    .pagination a, .pagination strong { min-width: 34px; padding: 8px 10px; border-radius: 7px; text-align: center; text-decoration: none; }
    .pagination a { color: #356dcc; background: #f1f5fc; }
    .pagination a:hover, .pagination strong { background: #356dcc; color: #fff; }
    @media (max-width: 650px) { body { padding: 20px 10px; } .header, .toolbar { align-items: stretch; flex-direction: column; } .search { max-width: none; } h1 { font-size: 24px; } }
</style>";

echo "<main class='page'>";
echo "<header class='header'><div><h1>User Directory</h1><p class='subtitle'>Manage registered users and their account details.</p></div><a class='button button-primary' href='create.php'>+ Create User</a></header>";
echo "<section class='card'>";

// Delete only the user whose submitted ID is a valid positive integer.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = filter_var($_POST['delete_id'], FILTER_VALIDATE_INT);
    if ($deleteId !== false && $deleteId > 0) {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute([':id' => $deleteId]);
    }
}

echo "<div class='toolbar'><form class='search' method='get'>";
echo "<input type='search' name='search' placeholder='Search users' value='" . htmlspecialchars($search, ENT_QUOTES, 'UTF-8') . "'>";
echo "<button type='submit'>Search</button>";
echo "</form>";
echo "</div>";

echo "<div class='table-wrap'><table>";
echo "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th>
    <th>Registration Date</th>
    <th>Action</th></tr>";

try {
    // Count matching users so the pagination links can be generated.
    $searchValue = "%$search%";
    $countStmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE firstname LIKE :search OR lastname LIKE :search OR email LIKE :search");
    $countStmt->execute(['search' => $searchValue]);
    $totalUsers = (int) $countStmt->fetchColumn();
    $totalPages = max(1, (int) ceil($totalUsers / $perPage));
    $page = min($page, $totalPages);
    $offset = ($page - 1) * $perPage;


    // Prepared statements keep the search value separate from the SQL query.
    $stmt = $conn->prepare("SELECT * FROM users WHERE firstname LIKE :search OR lastname LIKE :search OR email LIKE :search ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':search', $searchValue, PDO::PARAM_STR);
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll();
    if (empty($result)) {
        echo "<tr><td class='empty' colspan='6'>No users found.</td></tr>";
    } else {
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . (int) $row['id'] . "</td>";
            echo "<td>" . htmlspecialchars($row['firstname'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['lastname'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['reg_date'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td><div class='actions'>";
            // Provide a link to edit this user.
            echo "<a class='edit-link' href='edit.php?id=" . (int) $row['id'] . "'>✎ Edit</a>";

            // Ask for confirmation before submitting the delete request.
            echo "<form method='post' 
        onsubmit=\"return confirm('Are you sure you want to delete this user?');\">";
            echo "<input type='hidden' name='delete_id' value='" . (int) $row['id'] . "'>";
            echo "<button class='delete-button' type='submit'>Delete</button>";
            echo "</form>";

            echo "</div></td>";
            echo "</tr>";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
echo "</table></div>";

if ($totalPages > 1) {
    echo "<footer class='pagination' aria-label='Pagination'>";
    for ($pageNumber = 1; $pageNumber <= $totalPages; $pageNumber++) {
        $query = http_build_query(['search' => $search, 'page' => $pageNumber]);
        if ($pageNumber === $page) {
            echo " <strong aria-current='page'>" . $pageNumber . "</strong> ";
        } else {
            echo " <a href='?" . htmlspecialchars($query, ENT_QUOTES, 'UTF-8') . "'>" . $pageNumber . "</a> ";
        }
    }
    echo "</footer>";
}
echo "</section></main>";

// Release the active database connection when the page is complete.
$myDB = null;
