<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom     = trim($_POST['nom']);
    $prenom  = trim($_POST['prenom']);
    $email   = trim($_POST['email']);
    $filiere = trim($_POST['filiere']);
    $note    = floatval($_POST['note']);

    $sql  = "INSERT INTO etudiants (nom, prenom, email, filiere, note)
             VALUES (:nom, :prenom, :email, :filiere, :note)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nom'     => $nom,
        ':prenom'  => $prenom,
        ':email'   => $email,
        ':filiere' => $filiere,
        ':note'    => $note
    ]);

    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Ajouter un étudiant</title>
</head>
<body>
  <h1>Ajouter un étudiant</h1>
  <form method="POST">
    <label>Nom :
      <input type="text" name="nom" required>
    </label><br><br>
    <label>Prénom :
      <input type="text" name="prenom" required>
    </label><br><br>
    <label>Email :
      <input type="email" name="email" required>
    </label><br><br>
    <label>Filière :
      <input type="text" name="filiere">
    </label><br><br>
    <label>Note :
      <input type="number" name="note" step="0.1" min="0" max="20">
    </label><br><br>
    <button type="submit">Enregistrer</button>
    <a href="index.php">Annuler</a>
  </form>
</body>
</html>
