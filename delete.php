<?php
session_start();
require 'db.php';

$id = intval($_GET['id']);

if ($id <= 0) {
    header('Location: index.php');
    exit;
}

// ✅ SECURISE : vérification du token CSRF
if (!isset($_GET['token']) || $_GET['token'] !== $_SESSION['csrf_token']) {
    die("Requête invalide - Token CSRF manquant !");
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