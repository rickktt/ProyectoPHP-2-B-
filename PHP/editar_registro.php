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

$id = (int)$_GET['id'];

// Cargar datos del registro
$stmt = $conexion->prepare("SELECT * FROM registros WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$registro = $stmt->get_result()->fetch_assoc();

if (!$registro) {
    $_SESSION['feedback'] = "Registro no encontrado.";
    $_SESSION['feedback_tipo'] = "danger";
    header("Location: listar_registros.php");
    exit;
}

if (isset($_POST['actualizar'])) {
    $nombre   = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $correo   = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);

    $stmt2 = $conexion->prepare("UPDATE registros SET nombre=?, apellido=?, correo=?, telefono=? WHERE id=?");
    $stmt2->bind_param("ssssi", $nombre, $apellido, $correo, $telefono, $id);

    if ($stmt2->execute()) {
        $_SESSION['feedback'] = "Registro actualizado correctamente.";
        $_SESSION['feedback_tipo'] = "success";
    } else {
        $_SESSION['feedback'] = "Error al actualizar el registro.";
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
      <h3 class="mb-3">Editar Registro</h3>
      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Nombre</label>
          <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($registro['nombre'], ENT_QUOTES, 'UTF-8') ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Apellido</label>
          <input type="text" name="apellido" class="form-control" value="<?= htmlspecialchars($registro['apellido'], ENT_QUOTES, 'UTF-8') ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Correo</label>
          <input type="email" name="correo" class="form-control" value="<?= htmlspecialchars($registro['correo'], ENT_QUOTES, 'UTF-8') ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Teléfono</label>
          <input type="text" name="telefono" class="form-control" value="<?= htmlspecialchars($registro['telefono'], ENT_QUOTES, 'UTF-8') ?>" required>
        </div>
        <div class="d-flex gap-2">
          <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
          <a href="listar_registros.php" class="btn btn-secondary">Cancelar</a>
        </div>
      </form>
    </div>
  </div>
</div>
<?php include("footer.php"); ?>
