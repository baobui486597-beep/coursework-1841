<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'db.php';

if (!isset($_GET['id'])) {
    die("ERROR: User ID not provided.");
}

$id = intval($_GET['id']);

$check = $pdo->prepare("SELECT id FROM users WHERE id = :id LIMIT 1");
$check->execute(['id' => $id]);

if ($check->rowCount() === 0) {
    die("ERROR: User not found.");
}

$deletePosts = $pdo->prepare("DELETE FROM posts WHERE user_id = :id");
$deletePosts->execute(['id' => $id]);

$deleteUser = $pdo->prepare("DELETE FROM users WHERE id = :id");
$deleteUser->execute(['id' => $id]);

header("Location: index.php");
exit;
?>
