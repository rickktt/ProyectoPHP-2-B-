<?php
include("conexion.php");

if ($_SESSION['rol'] != 'admin') {
    header("Location: listar_estudiantes.php");
    exit;
}

$id = $_GET['id'];
$conexion->query("DELETE FROM estudiantes WHERE id=$id");

header("Location: listar_estudiantes.php");
exit;
?>
