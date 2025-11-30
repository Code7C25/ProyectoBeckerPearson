<?php
session_start();

$error = "";

// Verificar si se envió el formulario
if (isset($_POST['clave'])) {
    $clave = $_POST['clave'];

    // Contraseña hardcodeada
    if ($clave === "admin123") {
        $_SESSION['crear_usuario'] = true;
        header("Location: crearusuario.php"); // redirige al crear usuario
        exit;
    } else {
        $error = "Contraseña incorrecta";
    }
}
?>

<!DOCTYPE html>

<html lang="es">
<head>
<meta charset="UTF-8">
<title>Clave para crear usuario</title>
<style>
:root {
    --bg-color: #f4f6f8;
    --text-color: #1f2d3d;
    --primary-color: #1e3a8a;
    --primary-hover: #0f172a;
    --input-bg: #ffffff;
    --input-border: #1e3a8a;
    --button-bg: #1e3a8a;
    --button-text: #ffffff;
}
body.dark-mode {
    --bg-color: #111827;
    --text-color: #f3f4f6;
    --primary-color: #60a5fa;
    --primary-hover: #93c5fd;
    --input-bg: #1e293b;
    --input-border: #60a5fa;
    --button-bg: #3b82f6;
    --button-text: #ffffff;
}
body {
    background-color: var(--bg-color);
    font-family: 'Poppins', sans-serif;
    text-align: center;
    padding: 50px;
    color: var(--text-color);
    transition: background-color 0.3s ease, color 0.3s ease;
}
h2 { color: var(--primary-color); margin-bottom: 30px; }
label { display: block; margin-top: 15px; font-weight: 500; }
input { margin: 10px 0; padding: 10px; width: 250px; border-radius: 4px; border: 1px solid var(--input-border); background-color: var(--input-bg); color: var(--text-color); }
input[type="submit"], .toggle-lang { background-color: var(--button-bg); color: var(--button-text); border: none; cursor: pointer; font-weight: bold; padding: 10px 15px; margin-top: 10px; border-radius: 4px; }
input[type="submit"]:hover, .toggle-lang:hover { background-color: var(--primary-hover); }
.toggle-dark { position: absolute; top: 20px; right: 60px; background: none; border: none; font-size: 22px; cursor: pointer; color: var(--primary-color); transition: transform 0.2s ease; }
.toggle-dark:hover { transform: rotate(20deg); }
.toggle-lang { position: absolute; top: 20px; right: 20px; }
.error { color: red; margin-top: 10px; }
</style>
</head>
<body>

<button class="toggle-dark" onclick="toggleDarkMode()">🌙</button>

<h2 id="titulo">Ingrese la contraseña para crear un nuevo usuario</h2>

<form method="post">
    <label id="label-pass">Contraseña maestra:</label>
    <input type="password" name="clave" required>
    <br>
    <input type="submit" value="Continuar" id="boton-submit">
</form>

<?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>

<script>
function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
    localStorage.setItem('modoOscuro', document.body.classList.contains('dark-mode'));
}

window.onload = function () {
    if (localStorage.getItem('modoOscuro') === 'true') {
        document.body.classList.add('dark-mode');
    }
}
</script>

</body>
</html>
