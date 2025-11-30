<?php
session_start();
include 'conexion.php';

$nickname = $_POST['nick'];
$contravieja = $_POST['contravieja'];
$nuevacontra = $_POST['contra'];
$perfil = $_FILES['foto'];

// Encriptar contraseña vieja para comparación (ya que usás MD5)
$passVieja = md5($contravieja);

// Obtener contraseña actual
$sql = "SELECT PASSWORD FROM usuarios WHERE NICKNAME = '$nickname'";
$resultado = mysqli_query($conn, $sql);
$fila = mysqli_fetch_assoc($resultado);
echo $sql."<br>";
echo $passVieja."<br>";
echo $fila['PASSWORD'];
// Verificar contraseña actual
if ($fila['PASSWORD'] == $passVieja) {
    // Encriptar nueva contraseña también con MD5 (aunque se recomienda usar password_hash)
    $passNueva = md5($nuevacontra);

    // Empezar query de actualización
    $sqlUpdate = "UPDATE usuarios SET usuarios.PASSWORD = '$passNueva'";

    // Verificar si hay nueva imagen
    if (!empty($perfil['name'])) {
        $nombreImagen = $nickname. $perfil['name'];
        $rutaDestino = "perfiles/" . $nombreImagen;
        move_uploaded_file($perfil['tmp_name'], $rutaDestino);
        $sqlUpdate .= ", FOTO= '$nombreImagen'";
    }

    $sqlUpdate .= " WHERE NICKNAME = '$nickname'";
    echo $sqlUpdate;
    mysqli_query($conn, $sqlUpdate);
    mysqli_close($conn);
    header("Location: abrirsesion.php?nick=$nickname&contra=$nuevacontra");
    exit;
} else {
    mysqli_close($conn);
    echo "ERROR";
    exit;
}
?>
