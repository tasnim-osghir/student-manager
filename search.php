<?php
require 'db.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Recherche - Sécurisée</title>
</head>
<body>
  <h1>Rechercher un étudiant</h1>
  <form method="GET">
    <input type="text" name="nom" placeholder="Nom de l'étudiant">
    <button type="submit">Rechercher</button>
  </form>

  <?php
  if (isset($_GET['nom']) && $_GET['nom'] !== '') {

      // ✅ SECURISE : requête préparée
      $nom  = trim($_GET['nom']);
      $sql  = "SELECT * FROM etudiants WHERE nom = :nom";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([':nom' => $nom]);
      $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($resultats) {
          echo "<table border='1' cellpadding='8'>";
          echo "<tr><th>ID</th><th>Nom</th><th>Prénom</th>
                    <th>Email</th><th>Filière</th><th>Note</th></tr>";
          foreach ($resultats as $r) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($r['id'])      . "</td>";
              echo "<td>" . htmlspecialchars($r['nom'])     . "</td>";
              echo "<td>" . htmlspecialchars($r['prenom'])  . "</td>";
              echo "<td>" . htmlspecialchars($r['email'])   . "</td>";
              echo "<td>" . htmlspecialchars($r['filiere']) . "</td>";
              echo "<td>" . htmlspecialchars($r['note'])    . "</td>";
              echo "</tr>";
          }
          echo "</table>";
      } else {
          echo "<p>Aucun résultat trouvé.</p>";
      }
  }
  ?>

  <br><a href="index.php">Retour</a>
</body>
</html>