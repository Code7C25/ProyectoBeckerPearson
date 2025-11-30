<?php
session_start();
include 'conexion.php';

$id = $_POST['id'];
$titulo = $_POST['titulo'];
$cuerpo = $_POST['cuerpo'];

if (empty($id) || empty($titulo) || empty($cuerpo)) {
    die("Faltan datos para actualizar");
}

$sql = "UPDATE posts 
        SET TITULO='$titulo', CUERPO='$cuerpo'
        WHERE ID='$id'";

mysqli_query($conn, $sql) or die(mysqli_error($conn));

echo "Post actualizado correctamente <br>";
echo "<a href='index.php'>Volver</a>";
