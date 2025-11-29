<?php
session_start();

// Si no usó la clave maestra → no puede entrar
if (!isset($_SESSION["crear_usuario"])) {
    header("Location: login.html");
    exit;
}

include "conexion.php";

if (isset($_POST["crear"])) {

    $nick = mysqli_real_escape_string($cnx, $_POST["nick"]);
    $contra = mysqli_real_escape_string($cnx, $_POST["contra"]);

    $sql = "INSERT INTO usuarios (NICKNAME, CONTRA) VALUES ('$nick', '$contra')";
    
    if (mysqli_query($cnx, $sql)) {

        // Se usa una sola vez la clave maestra
        unset($_SESSION["crear_usuario"]);

        header("Location: login.html");
        exit;

    } else {
        $error = "Error al crear usuario.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Crear usuario</title>
</head>
<body>

    <h2>Crear nuevo usuario</h2>

    <form method="post">
        <label>Nickname:</label><br>
        <input type="text" name="nick" required><br>

        <label>Contraseña:</label><br>
        <input type="password" name="contra" required><br><br>

        <input type="submit" name="crear" value="Crear usuario">
    </form>

    <?php
    if (!empty($error)) {
        echo "<p style='color:red;'>$error</p>";
    }
    ?>

</body>
</html>
