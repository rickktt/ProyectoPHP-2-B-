<?php
// navbar.php — incluir en cada página DESPUÉS de session_start()
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Farmacia SV</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="listar_registros.php">&#128138; Farmacia SV</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <?php if (isset($_SESSION['usuario'])): ?>
          <li class="nav-item"><span class="nav-link text-secondary">Hola, <?= htmlspecialchars($_SESSION['usuario'], ENT_QUOTES, 'UTF-8') ?></span></li>
          <li class="nav-item"><a class="nav-link" href="listar_registros.php">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar sesión</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="login.php">Iniciar sesión</a></li>
          <li class="nav-item"><a class="nav-link" href="registro_usuario.php">Registrarse</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
