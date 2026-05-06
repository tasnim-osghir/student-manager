<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Récupérer les filtres
$search  = trim($_GET['search'] ?? '');
$filiere = trim($_GET['filiere'] ?? '');
$note_min = $_GET['note_min'] ?? '';
$note_max = $_GET['note_max'] ?? '';

// Construire la requête dynamiquement
$where  = [];
$params = [];

if ($search !== '') {
    $where[]          = "(nom LIKE :search OR prenom LIKE :search OR email LIKE :search)";
    $params[':search'] = "%$search%";
}
if ($filiere !== '') {
    $where[]           = "filiere = :filiere";
    $params[':filiere'] = $filiere;
}
if ($note_min !== '') {
    $where[]            = "note >= :note_min";
    $params[':note_min'] = floatval($note_min);
}
if ($note_max !== '') {
    $where[]            = "note <= :note_max";
    $params[':note_max'] = floatval($note_max);
}

$sql = "SELECT * FROM etudiants";
if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY note DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Liste des filières pour le filtre
$filieres = $pdo->query("SELECT DISTINCT filiere FROM etudiants WHERE filiere != ''")->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Recherche — Student Manager</title>
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
      <a href="create.php" class="nav-item">
        <span class="nav-icon">+</span> Ajouter
      </a>
      <a href="search.php" class="nav-item active">
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
        <h1 class="page-title">Recherche avancée</h1>
        <p class="page-sub">Filtrez les étudiants par nom, filière ou note</p>
      </div>
    </div>

    <!-- Filtres -->
    <div class="form-card" style="margin-bottom: 20px;">
      <form method="GET">
        <div class="filter-grid">
          <div class="form-group">
            <label>Recherche</label>
            <input type="text" name="search"
                   placeholder="Nom, prénom ou email..."
                   value="<?= htmlspecialchars($search) ?>">
          </div>
          <div class="form-group">
            <label>Filière</label>
            <select name="filiere">
              <option value="">Toutes les filières</option>
              <?php foreach ($filieres as $f): ?>
              <option value="<?= htmlspecialchars($f) ?>"
                <?= $filiere === $f ? 'selected' : '' ?>>
                <?= htmlspecialchars($f) ?>
              </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Note minimum</label>
            <input type="number" name="note_min" step="0.5"
                   min="0" max="20" placeholder="0"
                   value="<?= htmlspecialchars($note_min) ?>">
          </div>
          <div class="form-group">
            <label>Note maximum</label>
            <input type="number" name="note_max" step="0.5"
                   min="0" max="20" placeholder="20"
                   value="<?= htmlspecialchars($note_max) ?>">
          </div>
        </div>
        <div class="form-actions">
          <a href="search.php" class="btn-secondary">Réinitialiser</a>
          <button type="submit" class="btn-primary">🔍 Rechercher</button>
        </div>
      </form>
    </div>

    <!-- Résultats -->
    <div class="table-card">
      <div class="table-header">
        <h2>Résultats
          <span class="results-count"><?= count($resultats) ?> étudiant(s)</span>
        </h2>
      </div>

      <?php if (empty($resultats)): ?>
        <div class="empty-state">
          <div class="empty-icon">🔍</div>
          <p>Aucun étudiant trouvé avec ces critères.</p>
          <a href="search.php" class="btn-secondary">Réinitialiser la recherche</a>
        </div>
      <?php else: ?>
      <table>
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
          <?php foreach ($resultats as $e): ?>
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
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php endif; ?>
    </div>

  </main>
</div>

</body>
</html>