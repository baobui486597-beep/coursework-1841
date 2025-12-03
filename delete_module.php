<?php
require 'db.php';

if (!isset($_GET['id'])) {
    die("Module ID not provided.");
}

$id = intval($_GET['id']);

$stmt = $pdo->prepare("DELETE FROM modules WHERE id = :id");
$stmt->execute([':id' => $id]);

$deletePosts = $pdo->prepare("DELETE FROM posts WHERE module_id = :id");
$deletePosts->execute([':id' => $id]);

header("Location: index.php");
exit;
?>
