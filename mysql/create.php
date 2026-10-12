<?php include 'conex.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $email = $_POST['email'] ?? '';

    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email) VALUES (:firstname, :lastname, :email)");
    $stmt->execute([
        'firstname' => $firstname,
        'lastname' => $lastname,
        'email' => $email
    ]);

    echo "User created successfully. <br><a href='search.php'>Back to Search</a>";
}
?>

<form method="post">
    <label for="firstname">First Name</label>
    <input type="text" id="firstname" name="firstname" required><br><br>

    <label for="lastname">Last Name</label>
    <input type="text" id="lastname" name="lastname" required><br><br>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" required><br><br>

    <button type="submit">Create</button>
</form>