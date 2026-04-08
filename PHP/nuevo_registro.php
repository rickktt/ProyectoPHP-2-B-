<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
if ($_SESSION['rol'] != 'admin') {
    header("Location: listar_registros.php");
    exit;
}

if (isset($_POST['guardar'])) {
    $nombre   = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $correo   = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);

    $stmt = $conexion->prepare("INSERT INTO registros (nombre, apellido, correo, telefono) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $apellido, $correo, $telefono);

    if ($stmt->execute()) {
        $_SESSION['feedback'] = "Registro guardado correctamente.";
        $_SESSION['feedback_tipo'] = "success";
    } else {
        $_SESSION['feedback'] = "Error al guardar el registro.";
        $_SESSION['feedback_tipo'] = "danger";
    }
    header("Location: listar_registros.php");
    exit;
}
?>
<?php include("navbar.php"); ?>
<div class="container">
  <div class="card mx-auto" style="max-width: 500px;">
    <div class="card-body">
      <h3 class="mb-3">Nuevo Registro</h3>
      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Nombre</label>
          <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Apellido</label>
          <input type="text" name="apellido" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Correo</label>
          <input type="email" name="correo" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Teléfono</label>
          <input type="text" name="telefono" class="form-control" required>
        </div>
        <div class="d-flex gap-2">
          <button type="submit" name="guardar" class="btn btn-success">Guardar</button>
          <a href="listar_registros.php" class="btn btn-secondary">Cancelar</a>
        </div>
      </form>
    </div>
  </div>
</div>
<?php include("footer.php"); ?>
