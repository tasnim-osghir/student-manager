<?php
$host   = 'localhost';
$dbname = 'student_manager';
$user   = 'root';
$pass   = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    // ✅ SECURISE : message générique pour l'utilisateur
    // L'erreur réelle est loggée dans un fichier privé
    error_log("DB Error: " . $e->getMessage(), 3, "logs/errors.log");
    die("Une erreur est survenue. Veuillez réessayer plus tard.");
}
?>