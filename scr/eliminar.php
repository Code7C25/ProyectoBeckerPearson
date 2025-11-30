<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['usuario'])) {
    die("No tenés sesión iniciada.");
}

$idPost = $_REQUEST['id'];
$usuario = $_SESSION['usuario'];

// VERIFICAR SI ES ADMIN
$esAdmin = ($usuario === "admin");

// PRIMERO BORRAMOS REACCIONES DEL POST
$sqlReacciones = "DELETE FROM reacciones WHERE ID_POST = $idPost";
mysqli_query($conn, $sqlReacciones);

// LUEGO BORRAMOS EL POST
if ($esAdmin) {
    // Admin borra cualquier post
    $sql = "DELETE FROM posts WHERE ID = $idPost";
} else {
    // Usuario normal solo borra lo suyo
    $sql = "DELETE FROM posts WHERE ID = $idPost AND NICKNAME = '$usuario'";
}

mysqli_query($conn, $sql);

if (mysqli_affected_rows($conn) > 0) {
    echo "El post se eliminó correctamente.";
} else {
    echo "No tenés permiso para eliminar este post.";
}

mysqli_close($conn);
?>
