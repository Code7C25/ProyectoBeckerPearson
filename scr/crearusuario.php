<?php
session_start();
if (!isset($_SESSION["crear_usuario"])) {
    header("Location: login.html");
    exit;
}

include "conexion.php";
$error = "";

// PROCESO DE CREACIÓN DE USUARIO
if (isset($_POST["crear"])) {
    $nick = mysqli_real_escape_string($cnx, $_POST["nick"]);
    $nombre = mysqli_real_escape_string($cnx, $_POST["nombre"]);
    $apellido = mysqli_real_escape_string($cnx, $_POST["apellido"]);
    $mail = mysqli_real_escape_string($cnx, $_POST["mail"]);
    $tel = mysqli_real_escape_string($cnx, $_POST["tel"]);
    $contra = mysqli_real_escape_string($cnx, $_POST["contra"]);

    // Subida de foto
    $fotoRuta = "";
    if (!empty($_FILES["foto"]["name"])) {
        $nombreFoto = time() . "_" . basename($_FILES["foto"]["name"]);
        $destino = "fotos/" . $nombreFoto;
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $destino)) {
            $fotoRuta = $destino;
        }
    }

    $sql = "INSERT INTO usuarios 
            (NICKNAME, NOMBRE, APELLIDO, MAIL, TEL, PASSWORD, FOTO)
            VALUES 
            ('$nick', '$nombre', '$apellido', '$mail', '$tel', '$contra', '$fotoRuta')";

    if (mysqli_query($cnx, $sql)) {
        unset($_SESSION["crear_usuario"]); // clave maestra usada una vez
        header("Location: login.html");
        exit;
    } else {
        $error = "Error al crear usuario.";
    }
}
?>

<!DOCTYPE html>

<html lang="es">
<head>
<meta charset="UTF-8">
<title>Crear usuario</title>
<style>
:root {
    --bg-color: #e7e7e7;
    --text-color: #1f2d3d;
    --primary-color: #0078d7;
    --primary-hover: #005a9e;
    --input-bg: #ffffff;
    --input-border: #aaa;
    --button-bg: #0078d7;
    --button-text: #ffffff;
}
body.dark-mode {
    --bg-color: #111827;
    --text-color: #f3f4f6;
    --primary-color: #60a5fa;
    --primary-hover: #3b82f6;
    --input-bg: #1e293b;
    --input-border: #60a5fa;
    --button-bg: #3b82f6;
    --button-text: #ffffff;
}
body { font-family: Arial; background: var(--bg-color); margin:0; padding:0; color: var(--text-color); transition: 0.3s; }
.contenedor { width: 400px; margin:50px auto; background:white; padding:25px; border-radius:6px; box-shadow:0 0 10px #999; position:relative; background: var(--bg-color); color: var(--text-color); }
h2 { text-align:center; margin-bottom:20px; color: var(--primary-color); }
label { font-weight:bold; display:block; margin-top:10px; }
input[type="text"], input[type="password"], input[type="email"], input[type="file"] { width:100%; padding:8px; margin-top:5px; margin-bottom:15px; border:1px solid var(--input-border); border-radius:4px; background: var(--input-bg); color: var(--text-color); }
input[type="submit"], .toggle-lang, .toggle-dark { width:100%; padding:10px; background: var(--button-bg); border:none; color: var(--button-text); font-weight:bold; border-radius:4px; cursor:pointer; }
input[type="submit"]:hover, .toggle-lang:hover, .toggle-dark:hover { background: var(--primary-hover); }
.toggle-lang { width:auto; padding:5px 10px; position:absolute; top:10px; right:50px; }
.toggle-dark { width:auto; padding:5px 10px; position:absolute; top:10px; right:10px; }
.error { color:red; text-align:center; margin-top:10px; }
</style>
</head>
<body>

<div class="contenedor">

<button class="toggle-dark" onclick="toggleDarkMode()">🌙</button> <button class="toggle-lang" onclick="cambiarIdioma()"><span id="boton-idioma">EN</span></button>

<h2 id="titulo">Crear nuevo usuario</h2>

<form method="post" enctype="multipart/form-data">
    <label id="label-nick">Nickname:</label>
    <input type="text" name="nick" required>

```
<label id="label-nombre">Nombre:</label>
<input type="text" name="nombre" required>

<label id="label-apellido">Apellido:</label>
<input type="text" name="apellido" required>

<label id="label-mail">Mail:</label>
<input type="email" name="mail" required>

<label id="label-tel">Teléfono:</label>
<input type="text" name="tel" required>

<label id="label-contra">Contraseña:</label>
<input type="password" name="contra" required>

<label id="label-foto">Foto:</label>
<input type="file" name="foto">

<input type="submit" name="crear" value="Crear usuario" id="boton-crear">
```

</form>

<?php if (!empty($error)) { echo "<p class='error' id='error-msg'>$error</p>"; } ?>

</div>

<script>
let idioma = localStorage.getItem('idioma') || 'es';
function cambiarIdioma() {
    if(idioma === 'es') {
        document.getElementById('titulo').textContent = 'Create New User';
        document.getElementById('label-nick').textContent = 'Nickname:';
        document.getElementById('label-nombre').textContent = 'First Name:';
        document.getElementById('label-apellido').textContent = 'Last Name:';
        document.getElementById('label-mail').textContent = 'Email:';
        document.getElementById('label-tel').textContent = 'Phone:';
        document.getElementById('label-contra').textContent = 'Password:';
        document.getElementById('label-foto').textContent = 'Photo:';
        document.getElementById('boton-crear').value = 'Create User';
        let errorMsg = document.getElementById('error-msg');
        if(errorMsg && errorMsg.textContent === 'Error al crear usuario.') errorMsg.textContent = 'Error creating user.';
        document.getElementById('boton-idioma').textContent = 'ES';
        idioma = 'en';
    } else {
        document.getElementById('titulo').textContent = 'Crear nuevo usuario';
        document.getElementById('label-nick').textContent = 'Nickname:';
        document.getElementById('label-nombre').textContent = 'Nombre:';
        document.getElementById('label-apellido').textContent = 'Apellido:';
        document.getElementById('label-mail').textContent = 'Mail:';
        document.getElementById('label-tel').textContent = 'Teléfono:';
        document.getElementById('label-contra').textContent = 'Contraseña:';
        document.getElementById('label-foto').textContent = 'Foto:';
        document.getElementById('boton-crear').value = 'Crear usuario';
        let errorMsg = document.getElementById('error-msg');
        if(errorMsg && errorMsg.textContent === 'Error creating user.') errorMsg.textContent = 'Error al crear usuario.';
        document.getElementById('boton-idioma').textContent = 'EN';
        idioma = 'es';
    }
    localStorage.setItem('idioma', idioma);
}

function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
    localStorage.setItem('modoOscuro', document.body.classList.contains('dark-mode'));
}

window.onload = function() {
    if(localStorage.getItem('modoOscuro') === 'true') document.body.classList.add('dark-mode');
    if(localStorage.getItem('idioma') === 'en') cambiarIdioma();
}
</script>

</body>
</html>
