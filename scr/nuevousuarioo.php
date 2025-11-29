<?php
session_start();

// 🔒 Evita acceso no autorizado
if (!isset($_SESSION["crear_usuario"])) {
    header("Location: login.php");
    exit;
}

// Procesar formulario
if (isset($_POST["enviar"])) {
    $nick = $_POST["nick"];
    $nom = $_POST["nom"];
    $ape = $_POST["ape"];
    $mail = $_POST["mail"];
    $tel = $_POST["tel"];
    $pass = $_POST["pass"];

    $fotoNombre = "";
    if (!empty($_FILES["foto"]["name"])) {
        $fotoNombre = "foto_" . time() . "_" . $_FILES["foto"]["name"];
        move_uploaded_file($_FILES["foto"]["tmp_name"], "fotos/" . $fotoNombre);
    }

    $conn = new mysqli("localhost", "root", "", "base");
    if ($conn->connect_error) { die("Error de conexión: " . $conn->connect_error); }

    $sql = "INSERT INTO usuarios (nick, nom, ape, mail, tel, pass, foto)
            VALUES ('$nick', '$nom', '$ape', '$mail', '$tel', '$pass', '$fotoNombre')";

    if ($conn->query($sql) === TRUE) {
        unset($_SESSION["crear_usuario"]);
        header("Location: login.php?registrado=1");
        exit;
    } else {
        $error = "Error al crear usuario: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>

<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nuevo Usuario</title>
<style>
    :root {
        --bg-color: #f4f6f8;
        --text-color: #1f2d3d;
        --primary-color: #1e3a8a;
        --primary-hover: #0f172a;
        --input-border: #1e3a8a;
        --button-bg: #1e3a8a;
        --button-text: #ffffff;
    }
    body.dark-mode {
        --bg-color: #111827;
        --text-color: #f3f4f6;
        --primary-color: #60a5fa;
        --primary-hover: #93c5fd;
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
        transition: background-color 0.3s, color 0.3s;
    }
    h1 { color: var(--primary-color); }
    input { margin: 10px 0; padding: 10px; width: 250px; border-radius: 4px; border: 1px solid var(--input-border); background-color: #fff; color: var(--text-color); }
    body.dark-mode input { background-color: #1e293b; color: #f1f5f9; }
    input[type="submit"] { background-color: var(--button-bg); color: var(--button-text); border: none; cursor: pointer; font-weight: bold; padding: 10px 20px; border-radius: 4px; }
    input[type="submit"]:hover { background-color: var(--primary-hover); }
    .toggle-dark, #toggle-lang {
        position: absolute; background: none; border: none; cursor: pointer; transition: transform 0.2s ease;
    }
    .toggle-dark { top: 20px; right: 20px; font-size: 22px; color: var(--primary-color); }
    #toggle-lang { top: 60px; right: 20px; font-size: 16px; padding: 5px 10px; color: var(--primary-color); }
    .toggle-dark:hover { transform: rotate(20deg); }
    .error { color: red; margin-top: 15px; }
    label { display: block; margin-top: 10px; font-weight: 500; text-align: left; max-width: 250px; margin-left: auto; margin-right: auto; }
    form { display: inline-block; text-align: left; }
</style>
</head>
<body>

<button class="toggle-dark" onclick="toggleDarkMode()">🌙</button> <button id="toggle-lang">EN</button>

<h1 id="form-title">Nuevo Usuario</h1>

<?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>

<form method="POST" action="nuevousuario.php" enctype="multipart/form-data">
    <label for="idNick">Nombre de usuario (nickname):</label>
    <input type="text" name="nick" id="idNick" required>

```
<label for="idNom">Nombre:</label>
<input type="text" name="nom" id="idNom" required>

<label for="idApe">Apellido:</label>
<input type="text" name="ape" id="idApe" required>

<label for="idMail">Correo electrónico:</label>
<input type="email" name="mail" id="idMail" required>

<label for="idTel">Teléfono:</label>
<input type="text" name="tel" id="idTel" required>

<label for="idPass">Contraseña:</label>
<input type="password" name="pass" id="idPass" required>

<label for="idFoto">Foto de perfil:</label>
<input type="file" name="foto" id="idFoto" accept="image/*"><br>

<input type="submit" name="enviar" value="Crear Cuenta">
```

</form>

<script>
    // Modo oscuro
    function toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
        localStorage.setItem('modoOscuro', document.body.classList.contains('dark-mode'));
    }

    // Idioma
    const langBtn = document.getElementById('toggle-lang');
    const textos = {
        es: {
            titulo: "Nuevo Usuario",
            nick: "Nombre de usuario (nickname):",
            nom: "Nombre:",
            ape: "Apellido:",
            mail: "Correo electrónico:",
            tel: "Teléfono:",
            pass: "Contraseña:",
            foto: "Foto de perfil:",
            enviar: "Crear Cuenta"
        },
        en: {
            titulo: "New User",
            nick: "Username (nickname):",
            nom: "First Name:",
            ape: "Last Name:",
            mail: "Email:",
            tel: "Phone:",
            pass: "Password:",
            foto: "Profile Picture:",
            enviar: "Create Account"
        }
    };
    let idioma = localStorage.getItem('idioma') || 'es';

    function cambiarIdioma() {
        idioma = idioma === 'es' ? 'en' : 'es';
        localStorage.setItem('idioma', idioma);

        document.getElementById('form-title').textContent = textos[idioma].titulo;
        document.querySelector('label[for="idNick"]').textContent = textos[idioma].nick;
        document.querySelector('label[for="idNom"]').textContent = textos[idioma].nom;
        document.querySelector('label[for="idApe"]').textContent = textos[idioma].ape;
        document.querySelector('label[for="idMail"]').textContent = textos[idioma].mail;
        document.querySelector('label[for="idTel"]').textContent = textos[idioma].tel;
        document.querySelector('label[for="idPass"]').textContent = textos[idioma].pass;
        document.querySelector('label[for="idFoto"]').textContent = textos[idioma].foto;
        document.querySelector('input[type="submit"][name="enviar"]').value = textos[idioma].enviar;

        langBtn.textContent = idioma === 'es' ? 'EN' : 'ES';
    }

    window.onload = function() {
        if (localStorage.getItem('modoOscuro') === 'true') {
            document.body.classList.add('dark-mode');
        }
        cambiarIdioma();
    };

    langBtn.addEventListener('click', cambiarIdioma);
</script>

</body>
</html>
