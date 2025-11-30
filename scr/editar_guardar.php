<?php
session_start();
include 'conexion.php';

$id = $_POST['id'];
$titulo = $_POST['titulo'];
$contenido = $_POST['contenido'];

// Si es admin → puede editar cualquier post
if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) {
    $sql = "UPDATE posts SET TITULO='$titulo', CONTENIDO='$contenido' WHERE ID=$id";
} else {
    // Usuario normal → solo lo suyo
    $usuario = $_SESSION['user'];
    $sql = "UPDATE posts SET TITULO='$titulo', CONTENIDO='$contenido' WHERE ID=$id AND NICKNAME='$usuario'";
}

mysqli_query($conn, $sql);

echo "El posteo fue editado correctamente.";

mysqli_close($conn);
?>
