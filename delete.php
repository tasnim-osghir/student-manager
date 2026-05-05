<?php
require 'db.php';

$id = intval($_GET['id']);

if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$check = $pdo->prepare("SELECT id FROM etudiants WHERE id = :id");
$check->execute([':id' => $id]);

if ($check->fetch()) {
    $stmt = $pdo->prepare("DELETE FROM etudiants WHERE id = :id");
    $stmt->execute([':id' => $id]);
}

header('Location: index.php');
exit;
?>