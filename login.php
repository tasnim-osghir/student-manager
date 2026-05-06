<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Admin credentials (simple pour le projet)
    if ($email === 'admin@student.com' && $password === 'admin123') {
        $_SESSION['user'] = 'admin';
        header('Location: index.php');
        exit;
    } else {
        $error = "Email ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Manager — Login</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body class="login-body">

<div class="login-container">

  <!-- Côté gauche illustration -->
  <div class="login-left">
    <div class="login-brand">
      <div class="brand-icon">S</div>
      <span>Student Manager</span>
    </div>
    <div class="login-illustration">
      <div class="illustration-circle"></div>
      <div class="illustration-card">
        <div class="ill-avatar"></div>
        <div class="ill-lines">
          <div class="ill-line w80"></div>
          <div class="ill-line w60"></div>
          <div class="ill-line w40"></div>
        </div>
        <div class="ill-check">✓</div>
      </div>
      <div class="illustration-stats">
        <div class="ill-stat">
          <div class="ill-stat-value">3</div>
          <div class="ill-stat-label">Étudiants</div>
        </div>
        <div class="ill-stat">
          <div class="ill-stat-value">15.2</div>
          <div class="ill-stat-label">Moyenne</div>
        </div>
        <div class="ill-stat">
          <div class="ill-stat-value">3</div>
          <div class="ill-stat-label">Filières</div>
        </div>
      </div>
    </div>
    <p class="login-tagline">Gérez vos étudiants facilement et en toute sécurité.</p>
  </div>

  <!-- Côté droit formulaire -->
  <div class="login-right">
    <div class="login-form-wrapper">
      <h1>Welcome!</h1>
      <p class="login-sub">Connectez-vous à votre compte pour continuer</p>

      <?php if (!empty($error)): ?>
        <div class="alert-error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="form-group">
          <label>Email Address <span class="required">*</span></label>
          <div class="input-icon-wrap">
            <span class="input-icon">✉</span>
            <input type="email" name="email"
                   placeholder="Write an email address" required>
          </div>
        </div>

        <div class="form-group">
          <label>Password <span class="required">*</span></label>
          <div class="input-icon-wrap">
            <span class="input-icon">🔒</span>
            <input type="password" name="password"
                   placeholder="Enter Password" required>
          </div>
        </div>

        <div class="form-row">
          <label class="checkbox-label">
            <input type="checkbox" name="remember">
            Remember me
          </label>
        </div>

        <button type="submit" class="btn-login">Sign In</button>

        <div class="login-hint">
          <small>Admin : admin@student.com / admin123</small>
        </div>
      </form>
    </div>
  </div>

</div>

</body>
</html>