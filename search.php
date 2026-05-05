<?php
require 'db.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Recherche - Vulnérable SQLi</title>
</head>
<body>
  <h1>Rechercher un étudiant</h1>
  <form method="GET">
    <input type="text" name="nom" placeholder="Nom de l'étudiant">
    <button type="submit">Rechercher</button>
  </form>

  <?php
  if (isset($_GET['nom']) && $_GET['nom'] !== '') {
      $nom = $_GET['nom'];

      // ⚠️ VULNÉRABLE : la valeur est mise directement dans la requête
      $sql  = "SELECT * FROM etudiants WHERE nom = '$nom'";
      $stmt = $pdo->query($sql);
      $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($resultats) {
          echo "<table border='1' cellpadding='8'>";
          echo "<tr><th>ID</th><th>Nom</th><th>Prénom</th>
                    <th>Email</th><th>Filière</th><th>Note</th></tr>";
          foreach ($resultats as $r) {
              echo "<tr>";
              echo "<td>{$r['id']}</td>";
              echo "<td>{$r['nom']}</td>";
              echo "<td>{$r['prenom']}</td>";
              echo "<td>{$r['email']}</td>";
              echo "<td>{$r['filiere']}</td>";
              echo "<td>{$r['note']}</td>";
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