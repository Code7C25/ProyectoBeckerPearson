<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "sql312.infinityfree.com";
$user = "if0_40552637";
$pass = "lBvlkDTKZT65O";
$db   = "if0_40552637_bdblog";

echo "Intentando conectar...<br>";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("❌ Error de conexión: " . mysqli_connect_error());
}

echo "✅ Conexión OK!";
?>
