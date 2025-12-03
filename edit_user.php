<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'db.php';

if (!isset($_GET['id'])) {
    die("User ID not provided");
}

$id = intval($_GET['id']);

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $id]);
$user = $stmt->fetch();

if (!$user) {
    die("User not found");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);

    if ($username === '' || $email === '') {
        $msg = "Fields cannot be empty.";
    } else {
        $update = $pdo->prepare("UPDATE users SET username = :username, email = :email WHERE id = :id");
        $update->execute([
            ':username' => $username,
            ':email'    => $email,
            ':id'       => $id
        ]);

        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
</head>
<body>

<h2>Edit User</h2>

<?php if (!empty($msg)) echo "<p style='color:red;'>$msg</p>"; ?>

<form method="post">
    <label>Username</label>
    <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required><br><br>

    <label>Email</label>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br><br>

    <input type="submit" v
