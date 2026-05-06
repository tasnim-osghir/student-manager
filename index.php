<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Stats depuis la BDD
$total     = $pdo->query("SELECT COUNT(*) FROM etudiants")->fetchColumn();
$moyenne   = $pdo->query("SELECT AVG(note) FROM etudiants")->fetchColumn();
$max_note  = $pdo->query("SELECT MAX(note) FROM etudiants")->fetchColumn();
$filieres  = $pdo->query("SELECT COUNT(DISTINCT filiere) FROM etudiants")->fetchColumn();

$stmt      = $pdo->query("SELECT * FROM etudiants ORDER BY id DESC");
$etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Student Manager — Dashboard</title>
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

    <!-- Topbar -->
    <div class="topbar">
      <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-sub">Bienvenue, <strong>Admin</strong></p>
      </div>
      <a href="create.php" class="btn-primary">+ Ajouter un étudiant</a>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon blue">👥</div>
        <div class="stat-info">
          <div class="stat-value"><?= $total ?></div>
          <div class="stat-label">Total étudiants</div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon green">📊</div>
        <div class="stat-info">
          <div class="stat-value"><?= number_format($moyenne, 1) ?></div>
          <div class="stat-label">Moyenne générale</div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon purple">🏆</div>
        <div class="stat-info">
          <div class="stat-value"><?= $max_note ?></div>
          <div class="stat-label">Meilleure note</div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon amber">🎓</div>
        <div class="stat-info">
          <div class="stat-value"><?= $filieres ?></div>
          <div class="stat-label">Filières</div>
        </div>
      </div>
    </div>

    <!-- Table -->
    <div class="table-card">
      <div class="table-header">
        <h2>Liste des étudiants</h2>
        <input type="text" id="searchInput"
               placeholder="Rechercher un étudiant..."
               onkeyup="filterTable()" class="search-input">
      </div>

      <table id="studentsTable">
        <thead>
          <tr>
            <th>Étudiant</th>
            <th>Email</th>
            <th>Filière</th>
            <th>Note</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($etudiants as $e): ?>
          <tr>
            <td>
              <div class="student-cell">
                <div class="avatar">
                  <?= strtoupper(substr($e['nom'], 0, 1) . substr($e['prenom'], 0, 1)) ?>
                </div>
                <div>
                  <div class="student-name"><?= htmlspecialchars($e['nom'] . ' ' . $e['prenom']) ?></div>
                  <div class="student-id">#<?= $e['id'] ?></div>
                </div>
              </div>
            </td>
            <td><?= htmlspecialchars($e['email']) ?></td>
            <td><span class="filiere-badge"><?= htmlspecialchars($e['filiere']) ?></span></td>
            <td>
              <span class="note-badge <?= $e['note'] >= 16 ? 'note-high' : ($e['note'] >= 12 ? 'note-mid' : 'note-low') ?>">
                <?= $e['note'] ?>
              </span>
            </td>
            <td>
              <div class="action-btns">
                <a href="edit.php?id=<?= $e['id'] ?>" class="btn-edit">Modifier</a>
                <a href="delete.php?id=<?= $e['id'] ?>&token=<?= $_SESSION['csrf_token'] ?>"
                   onclick="return confirm('Supprimer cet étudiant ?')"
                   class="btn-delete">Supprimer</a>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  </main>
</div>

<script>
function filterTable() {
  const input = document.getElementById('searchInput').value.toLowerCase();
  const rows  = document.querySelectorAll('#studentsTable tbody tr');
  rows.forEach(row => {
    row.style.display = row.textContent.toLowerCase().includes(input) ? '' : 'none';
  });
}
</script>

</body>
</html>