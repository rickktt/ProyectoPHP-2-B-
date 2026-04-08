<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$rol = $_SESSION['rol'];
$resultado = $conexion->query("SELECT * FROM registros ORDER BY id DESC");

// Mensaje de feedback desde otras páginas
$feedback = $_SESSION['feedback'] ?? "";
$feedback_tipo = $_SESSION['feedback_tipo'] ?? "success";
unset($_SESSION['feedback'], $_SESSION['feedback_tipo']);
?>
<?php include("navbar.php"); ?>
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Lista de Registros</h2>
    <?php if ($rol == 'admin'): ?>
      <a href="nuevo_registro.php" class="btn btn-primary">+ Nuevo Registro</a>
    <?php endif; ?>
  </div>

  <?php if ($feedback): ?>
    <div class="alert alert-<?= $feedback_tipo ?>"><?= htmlspecialchars($feedback, ENT_QUOTES, 'UTF-8') ?></div>
  <?php endif; ?>

  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Correo</th>
        <th>Teléfono</th>
        <?php if ($rol == 'admin'): ?><th>Acciones</th><?php endif; ?>
      </tr>
    </thead>
    <tbody>
      <?php if ($resultado && $resultado->num_rows > 0): ?>
        <?php while ($fila = $resultado->fetch_assoc()): ?>
        <tr>
          <td><?= (int)$fila['id'] ?></td>
          <td><?= htmlspecialchars($fila['nombre'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars($fila['apellido'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars($fila['correo'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars($fila['telefono'], ENT_QUOTES, 'UTF-8') ?></td>
          <?php if ($rol == 'admin'): ?>
          <td>
            <a href="editar_registro.php?id=<?= (int)$fila['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
            <a href="eliminar_registro.php?id=<?= (int)$fila['id'] ?>" class="btn btn-danger btn-sm"
               onclick="return confirm('¿Seguro que deseas eliminar este registro?');">Eliminar</a>
          </td>
          <?php endif; ?>
        </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="<?= $rol == 'admin' ? 6 : 5 ?>" class="text-center text-muted">No hay registros aún.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
<?php include("footer.php"); ?>
