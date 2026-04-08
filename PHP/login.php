<?php
session_start();
include("conexion.php");

if (isset($_SESSION['usuario'])) {
    header("Location: listar_registros.php");
    exit;
}

$error = "";
if (isset($_POST['login'])) {
    $usuario = $_POST['nombre_usuario'];
    $password = $_POST['contrasena'];

    // Consulta segura con prepared statements
    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE nombre_usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();

    if ($row && password_verify($password, $row['contrasena'])) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['rol'] = $row['rol'];
        header("Location: listar_registros.php");
        exit;
    } else {
        $error = "Credenciales incorrectas.";
    }
}
?>
<?php include("navbar.php"); ?>
<div class="container">
  <div class="card mx-auto" style="max-width: 400px;">
    <div class="card-body">
      <h3 class="text-center mb-3">Inicio de Sesión</h3>
      <?php if ($error): ?>
        <div class="alert alert-danger text-center"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
      <?php endif; ?>
      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Usuario</label>
          <input type="text" name="nombre_usuario" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
          <label class="form-label">Contraseña</label>
          <input type="password" name="contrasena" class="form-control" required>
        </div>
        <button type="submit" name="login" class="btn btn-success w-100">Ingresar</button>
      </form>
      <div class="text-center mt-3">
        <a href="registro_usuario.php">¿No tienes cuenta? Regístrate</a>
      </div>
    </div>
  </div>
</div>
<?php include("footer.php"); ?>
