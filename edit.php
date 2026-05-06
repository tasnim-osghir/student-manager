<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$id = intval($_GET['id']);
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM etudiants WHERE id = :id");
$stmt->execute([':id' => $id]);
$etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$etudiant) {
    die("Étudiant introuvable.");
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
        $success = "Étudiant modifié avec succès !";
        $etudiant = array_merge($etudiant, compact('nom','prenom','email','filiere','note'));
    } catch (PDOException $e) {
        $error = "Erreur : cet email existe déjà.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier un étudiant</title>
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
      <a href="index.php" class="nav-item active">
        <span class="nav-icon">⊞</span> Dashboard
      </a>
      <a href="create.php" class="nav-item">
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
        <h1 class="page-title">Modifier l'étudiant</h1>
        <p class="page-sub">#<?= $id ?> — <?= htmlspecialchars($etudiant['nom'] . ' ' . $etudiant['prenom']) ?></p>
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
            <input type="text" name="nom"
                   value="<?= htmlspecialchars($etudiant['nom']) ?>" required>
          </div>
          <div class="form-group">
            <label>Prénom <span class="required">*</span></label>
            <input type="text" name="prenom"
                   value="<?= htmlspecialchars($etudiant['prenom']) ?>" required>
          </div>
          <div class="form-group">
            <label>Email <span class="required">*</span></label>
            <input type="email" name="email"
                   value="<?= htmlspecialchars($etudiant['email']) ?>" required>
          </div>
          <div class="form-group">
            <label>Filière</label>
            <select name="filiere">
              <option value="">-- Choisir --</option>
              <?php
              $filieres = ['Informatique','Mathematiques','Physique','Chimie','Biologie'];
              foreach ($filieres as $f):
              ?>
              <option value="<?= $f ?>"
                <?= $etudiant['filiere'] === $f ? 'selected' : '' ?>>
                <?= $f ?>
              </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Note <span class="required">*</span></label>
            <input type="number" name="note" step="0.1" min="0" max="20"
                   value="<?= $etudiant['note'] ?>" required>
          </div>
        </div>

        <div class="form-actions">
          <a href="index.php" class="btn-secondary">Annuler</a>
          <button type="submit" class="btn-primary">Mettre à jour</button>
        </div>
      </form>
    </div>
  </main>
</div>

</body>
</html>