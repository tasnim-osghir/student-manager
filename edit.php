<?php
require 'db.php';

$id = intval($_GET['id']);

$stmt = $pdo->prepare("SELECT * FROM etudiants WHERE id = :id");
$stmt->execute([':id' => $id]);
$etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$etudiant) {
    die("Étudiant introuvable.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom     = trim($_POST['nom']);
    $prenom  = trim($_POST['prenom']);
    $email   = trim($_POST['email']);
    $filiere = trim($_POST['filiere']);
    $note    = floatval($_POST['note']);

    $sql = "UPDATE etudiants
            SET nom=:nom, prenom=:prenom, email=:email,
                filiere=:filiere, note=:note
            WHERE id=:id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nom'     => $nom,
        ':prenom'  => $prenom,
        ':email'   => $email,
        ':filiere' => $filiere,
        ':note'    => $note,
        ':id'      => $id
    ]);

    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier un étudiant</title>
</head>
<body>
  <h1>Modifier l'étudiant #<?= $id ?></h1>
  <form method="POST">
    <label>Nom :
      <input type="text" name="nom"
             value="<?= htmlspecialchars($etudiant['nom']) ?>" required>
    </label><br><br>
    <label>Prénom :
      <input type="text" name="prenom"
             value="<?= htmlspecialchars($etudiant['prenom']) ?>" required>
    </label><br><br>
    <label>Email :
      <input type="email" name="email"
             value="<?= htmlspecialchars($etudiant['email']) ?>" required>
    </label><br><br>
    <label>Filière :
      <input type="text" name="filiere"
             value="<?= htmlspecialchars($etudiant['filiere']) ?>">
    </label><br><br>
    <label>Note :
      <input type="number" name="note" step="0.1" min="0" max="20"
             value="<?= $etudiant['note'] ?>">
    </label><br><br>
    <button type="submit">Mettre à jour</button>
    <a href="index.php">Annuler</a>
  </form>
</body>
</html>