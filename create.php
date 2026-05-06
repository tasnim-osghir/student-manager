<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$success = '';
$error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom     = trim($_POST['nom']);
    $prenom  = trim($_POST['prenom']);
    $email   = trim($_POST['email']);
    $filiere = trim($_POST['filiere']);
    $note    = floatval($_POST['note']);

    try {
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
        $success = "Étudiant ajouté avec succès !";
    } catch (PDOException $e) {
        $error = "Erreur : cet email existe déjà.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Ajouter un étudiant</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body class="dashboard-body">

<div class="dashboard-container">

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="brand-icon">S</div>
      <span>Student Manager</span>
    </div>
    <nav class="sidebar-nav">
      <a href="index.php" class="nav-item">
        <span class="nav-icon">⊞</span> Dashboard
      </a>
      <a href="create.php" class="nav-item active">
        <span class="nav-icon">+</span> Ajouter
      </a>
      <a href="search.php" class="nav-item">
        <span class="nav-icon">⌕</span> Recherche
      </a>
    </nav>
    <a href="logout.php" class="nav-item nav-logout">
      <span class="nav-icon">→</span> Déconnexion
    </a>
  </aside>

  <!-- Main -->
  <main class="main-content">
    <div class="topbar">
      <div>
        <h1 class="page-title">Ajouter un étudiant</h1>
        <p class="page-sub">Remplissez le formulaire ci-dessous</p>
      </div>
      <a href="index.php" class="btn-secondary">← Retour</a>
    </div>

    <div class="form-card">
      <?php if ($success): ?>
        <div class="alert-success"><?= htmlspecialchars($success) ?></div>
      <?php endif; ?>
      <?php if ($error): ?>
        <div class="alert-error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="form-grid">
          <div class="form-group">
            <label>Nom <span class="required">*</span></label>
            <input type="text" name="nom" placeholder="Ex: Alami" required>
          </div>
          <div class="form-group">
            <label>Prénom <span class="required">*</span></label>
            <input type="text" name="prenom" placeholder="Ex: Youssef" required>
          </div>
          <div class="form-group">
            <label>Email <span class="required">*</span></label>
            <input type="email" name="email" placeholder="Ex: youssef@email.com" required>
          </div>
          <div class="form-group">
            <label>Filière</label>
            <select name="filiere">
              <option value="">-- Choisir une filière --</option>
              <option value="Informatique">Informatique</option>
              <option value="Mathematiques">Mathématiques</option>
              <option value="Physique">Physique</option>
              <option value="Chimie">Chimie</option>
              <option value="Biologie">Biologie</option>
            </select>
          </div>
          <div class="form-group">
            <label>Note <span class="required">*</span></label>
            <input type="number" name="note" step="0.1" min="0" max="20"
                   placeholder="Ex: 15.5" required>
          </div>
        </div>

        <div class="form-actions">
          <a href="index.php" class="btn-secondary">Annuler</a>
          <button type="submit" class="btn-primary">Enregistrer l'étudiant</button>
        </div>
      </form>
    </div>
  </main>
</div>

</body>
</html>