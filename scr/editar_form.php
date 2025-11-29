<?php
include 'conexion.php';
session_start();

$id = $_GET['id'];

$sql = "SELECT * FROM posts WHERE ID='$id'";
$res = mysqli_query($cnx, $sql);
$fila = mysqli_fetch_array($res);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Editar Post</title>
</head>
<body>

<h1>Editar Post</h1>

<form action="actualizar.php" method="post">

    <input type="hidden" name="id" value="<?php echo $fila['ID']; ?>">

    <label>Título:</label><br>
    <input type="text" name="titulo" value="<?php echo $fila['TITULO']; ?>"><br><br>

    <label>Cuerpo:</label><br>
    <textarea name="cuerpo" rows="6" cols="40"><?php echo $fila['CUERPO']; ?></textarea><br><br>

    <input type="submit" value="Actualizar">
</form>

</body>
</html>
