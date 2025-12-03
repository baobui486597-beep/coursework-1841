<?php
require 'db.php';

if (!isset($_GET['id'])) {
    die("Module ID not provided.");
}

$id = intval($_GET['id']);

$stmt = $pdo->prepare("SELECT * FROM modules WHERE id = :id");
$stmt->execute([':id' => $id]);
$module = $stmt->fetch();

if (!$module) {
    die("Module not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);

    if ($name === '') {
        $msg = "Module name cannot be empty.";
    } else {
        $update = $pdo->prepare("UPDATE modules SET name = :name WHERE id = :id");
        $update->execute([
            ':name' => $name,
            ':id'   => $id
        ]);
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Module</title>
</head>
<body>

<h2>Edit Module</h2>

<?php if (!empty($msg)) echo "<p style='color:red;'>$msg</p>"; ?>

<form method="post">
    Module Name: <input type="text" name="name" value="<?= htmlspecialchars($module['name']) ?>" required><br><br>

    <input type="submit" value="Save Changes">
</form>

</body>
</html>
