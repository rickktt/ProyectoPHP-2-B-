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

$stmt = $conexion->prepare("DELETE FROM registros WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $_SESSION['feedback'] = "Registro eliminado correctamente.";
    $_SESSION['feedback_tipo'] = "success";
} else {
    $_SESSION['feedback'] = "Error al eliminar el registro.";
    $_SESSION['feedback_tipo'] = "danger";
}

header("Location: listar_registros.php");
exit;
?>
