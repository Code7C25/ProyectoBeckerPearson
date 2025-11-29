<?php
session_start();

    include 'conexion.php';
    $sql="SELECT * FROM  posts WHERE ID =" .$_REQUEST['id']." ";
    $resuñtado= mysqli_query($cnx,$sql);
    mysqli_close($cnx);

?>
<form action="actualizar.php" method="posts">
    <input type="hidden" name="id" value="<?=$posts['id']?>">
    <label> Titulo: </label>
    <input type="text" name="titulo"><br>
    <label> Cuerpo: </label>
    <textarea name= "cuerpo"></textarea><br>
    <input type="submit" value="Actualizar">
</form>
