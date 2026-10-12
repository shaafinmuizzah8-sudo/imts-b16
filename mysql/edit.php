<?php include 'conex.php';

$id = $_GET['id'] ?? null;

if ($id === null) {
    die("Invalid user ID");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $email = $_POST['email'] ?? '';

    $stmt = $conn->prepare("UPDATE users SET firstname = :firstname, lastname = :lastname, email = :email WHERE id = :id");
    $stmt->execute([
        'firstname' => $firstname,
        'lastname' => $lastname,
        'email' => $email,
        'id' => $id
    ]);

    echo "User updated successfully. <br><a href='search.php'>Back to Search</a></b>";
}


$stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);


if ($user === false) {
    die("User not found");
}


?>

<form method="post">
    <input type="hidden" name="id" value="<?= htmlspecialchars((string) $id, ENT_QUOTES, 'UTF-8') ?>">

    <label for="name">First Name</label>
    <input type="text" id="firstname" name="firstname" value="<?= $user['firstname'] ?? '' ?>" required><br><br>

    <label for="name">Last Name</label>
    <input type="text" id="lastname" name="lastname" value="<?= $user['lastname'] ?? '' ?>" required><br><br>

    <label for="name">Email</label>
    <input type="email" id="email" name="email" value="<?= $user['email'] ?? '' ?>" required><br><br>

    <button type="submit">Save</button>
</form>