<?php
session_start();
if(isset($_SESSION['usuario']) && $_SESSION['usuario']==$_REQUEST['nickname'])
{
//RECIBOR DATOS DEL FORMULARIO
$nik=$_REQUEST['nickname'];
$tit=$_REQUEST['titulo'];
$cu=$_REQUEST['cuerpo'];
$fecCrea=$_REQUEST['fc'];
$hrCrea=$_REQUEST['hc'];
$fecPu=$_REQUEST['fp'];
$hrPu=$_REQUEST['hp'];

$img = date('YmdHis').$_FILES['foto']['name'];
$ubic=$_FILES['foto']['tmp_name'];
copy($ubic,'imagenes/'.$img);

include 'conexion.php';
$sql="INSERT INTO posts(TITULO, CUERPO, IMAGEN, FECHA_CREACION, HORA_CREACION, FECHA_PUBL, HORA_PUBL, NICKNAME) VALUES ('$tit','$cu','$img','$fecCrea','$hrCrea','$fecPu','$hrPu','$nik') ";
mysqli_query($conn,$sql) or die ("No se pudo agregar el posteo.");
echo "El posteo fue guardado correctamente.";
header("Location: index.php");
mysqli_close($conn);

}
else
{
	echo "Permiso denegado.";
	header("Location: index.php");
}
?>