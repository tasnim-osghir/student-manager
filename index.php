<?php
session_start();
require 'db.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion des étudiants</title>
</head>
<body>
  <h1>Liste des étudiants</h1>
  <a href="create.php">+ Ajouter un étudiant</a>

  <table border="1" cellpadding="8">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Email</th>
        <th>Filière</th>
        <th>Note</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $stmt = $pdo->query("SELECT * FROM etudiants ORDER BY id DESC");
        $etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($etudiants as $e) {
            echo "<tr>";
            echo "<td>{$e['id']}</td>";
            echo "<td>" . htmlspecialchars($e['nom'])     . "</td>";
            echo "<td>" . htmlspecialchars($e['prenom'])  . "</td>";
            echo "<td>" . htmlspecialchars($e['email'])   . "</td>";
            echo "<td>" . htmlspecialchars($e['filiere']) . "</td>";
            echo "<td>{$e['note']}</td>";
            echo "<td>
                    <a href='edit.php?id={$e['id']}'>Modifier</a> |
                    <a href='delete.php?id={$e['id']}&token={$_SESSION['csrf_token']}'
                       onclick='return confirm(\"Supprimer cet étudiant ?\")'>
                       Supprimer</a>
                  </td>";
            echo "</tr>";
        }
      ?>
    </tbody>
  </table>
</body>
</html>