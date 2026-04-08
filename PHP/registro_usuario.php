<?php
session_start();
include("conexion.php");

$mensaje = "";
$tipo = "";

if (isset($_POST['registrar'])) {
    $usuario = trim($_POST['nombre_usuario']);
    $password = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);
    $rol = $_POST['rol']; // intencional para propósitos educativos

    // Verificar si el usuario ya existe
    $check = $conexion->prepare("SELECT id FROM usuarios WHERE nombre_usuario = ?");
    $check->bind_param("s", $usuario);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $mensaje = "Ese nombre de usuario ya está en uso.";
        $tipo = "danger";
    } else {
        $stmt = $conexion->prepare("INSERT INTO usuarios (nombre_usuario, contrasena, rol) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $usuario, $password, $rol);
        if ($stmt->execute()) {
            $mensaje = "Usuario registrado correctamente como <strong>$rol</strong>.";
            $tipo = "success";
        } else {
            $mensaje = "Error al registrar. Intenta de nuevo.";
            $tipo = "danger";
        }
    }
}
?>
<?php include("navbar.php"); ?>
<div class="container">
  <div class="card mx-auto" style="max-width: 400px;">
    <div class="card-body">
      <h3 class="text-center mb-3">Registro de Usuario</h3>
      <?php if ($mensaje): ?>
        <div class="alert alert-<?= $tipo ?> text-center"><?= $mensaje ?></div>
      <?php endif; ?>
      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Nombre de usuario</label>
          <input type="text" name="nombre_usuario" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Contraseña</label>
          <input type="password" name="contrasena" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Rol</label>
          <select name="rol" class="form-select" required>
            <option value="usuario">Usuario (solo lectura)</option>
            <option value="admin">Administrador (acceso total)</option>
          </select>
        </div>
        <button type="submit" name="registrar" class="btn btn-primary w-100">Registrar</button>
      </form>
      <div class="text-center mt-3">
        <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a>
      </div>
    </div>
  </div>
</div>
<?php include("footer.php"); ?>
