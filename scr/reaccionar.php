<?php
session_start();
include "conexion.php";

$idPost = $_GET['id'] ?? null;
$tipo = $_GET['tipo'] ?? null; // corazon o feliz

if (!$idPost || !$tipo) {
    die("Datos incompletos.");
}

/* =====================================================
   DEFINIR NOMBRE DE USUARIO (REGISTRADO / ADMIN / INVITADO)
   ===================================================== */

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario']; // registrado o admin
} else {
    // Invitado — generamos identificador único persistente
    if (!isset($_COOKIE['inv_id'])) {
        $codigo = "Invitado_" . substr(md5(time() . rand()), 0, 6);
        setcookie("inv_id", $codigo, time() + (3600 * 24 * 30)); // dura 30 días
        $usuario = $codigo;
    } else {
        $usuario = $_COOKIE['inv_id'];
    }
}

/* =====================================================
   EVITAR REACCIONES REPETIDAS DEL MISMO USUARIO
   ===================================================== */

$check = mysqli_query($conn,
    "SELECT * FROM reacciones 
     WHERE ID_POST='$idPost'
     AND NICKNAME='$usuario'"
);

if (mysqli_num_rows($check) > 0) {
    // Ya reaccionó antes → actualizar reacción
    $sql = "
        UPDATE reacciones 
        SET TIPO='$tipo', FECHA=NOW() 
        WHERE ID_POST='$idPost' AND NICKNAME='$usuario'
    ";
    mysqli_query($conn, $sql);

    header("Location: index.php");
    exit;
}

/* =====================================================
   INSERTAR NUEVA REACCIÓN
   ===================================================== */

$sql = "
    INSERT INTO reacciones (ID_POST, NICKNAME, TIPO, FECHA)
    VALUES ('$idPost', '$usuario', '$tipo', NOW())
";

mysqli_query($conn, $sql) or die("Error guardando reacción.");

/* =====================================================
   VOLVER AL INDEX
   ===================================================== */

header("Location: index.php");
exit;
?>
