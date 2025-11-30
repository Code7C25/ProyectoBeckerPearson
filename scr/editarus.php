<?php
session_start();
include 'conexion.php';

$sql = "SELECT * FROM usuarios WHERE NICKNAME = '" . $_SESSION['usuario'] . "'";
$resultado = mysqli_query($conn, $sql);
mysqli_close($conn);
?>

<!DOCTYPE html>

<html>
<head>
    <title>Modificar Cuenta</title>
    <meta charset="utf-8">
    <style>
    :root {
        --bg-color: #f4f6f8;
        --text-color: #2c3e50;
        --accent-color: #1e3a8a;
        --accent-hover: #172554;
        --input-border: #1e3a8a;
        --button-text: #ffffff;
    }

```
body.dark-mode {
    --bg-color: #121212;
    --text-color: #e0e0e0;
    --accent-color: #3b82f6;
    --accent-hover: #2563eb;
    --input-border: #3b82f6;
    --button-text: #ffffff;
}

body {
    background-color: var(--bg-color);
    color: var(--text-color);
    font-family: 'Segoe UI', Arial, sans-serif;
    text-align: center;
    padding: 50px;
    margin: 0;
    transition: background-color 0.3s, color 0.3s;
}

h1 {
    color: var(--text-color);
    margin-bottom: 20px;
}

label {
    display: block;
    margin-top: 15px;
    font-weight: 500;
}

input {
    margin: 10px 0;
    padding: 10px;
    width: 250px;
    border-radius: 4px;
    border: 1px solid var(--input-border);
    background-color: #fff;
    color: var(--text-color);
    transition: border-color 0.3s, background-color 0.3s;
}

body.dark-mode input {
    background-color: #1e1e1e;
    color: var(--text-color);
}

input[type="submit"], .toggle-lang {
    background-color: var(--accent-color);
    color: var(--button-text);
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
    padding: 10px 15px;
    border-radius: 4px;
}

input[type="submit"]:hover, .toggle-lang:hover {
    background-color: var(--accent-hover);
    transform: scale(1.05);
}

a {
    color: var(--accent-color);
    text-decoration: none;
    transition: color 0.3s ease;
}

a:hover {
    text-decoration: underline;
    color: var(--accent-hover);
}

.saludo {
    font-size: 14px;
    color: var(--text-color);
    margin-bottom: 20px;
}

.toggle-dark {
    position: absolute;
    top: 20px;
    right: 60px;
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: var(--text-color);
    transition: transform 0.2s;
}

.toggle-dark:hover {
    transform: rotate(20deg);
}

.toggle-lang {
    position: absolute;
    top: 20px;
    right: 20px;
}
</style>
```

</head>
<body>
    <h1 id="titulo">Modificar Cuenta</h1>
    <div class="saludo" id="saludo">
        Usuario actual: <strong><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong><br>
        <a href="cerrarsesion.php" id="cerrar-sesion">[Cerrar sesión]</a>
    </div>

```
<form action="actualizaru.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="nick" value="<?= $_SESSION['usuario'] ?>">

    <label for="contravieja" id="label-actual">Contraseña actual:</label>
    <input type="password" name="contravieja" id="contravieja" required>

    <label for="contra" id="label-nueva">Nueva contraseña:</label>
    <input type="password" name="contra" id="contra" required>

    <label for="perfil" id="label-foto">Nueva foto de perfil:</label>
    <input type="file" name="foto" id="perfil" accept="image/*"><br>

    <input type="submit" value="Actualizar" id="boton-actualizar">
</form>

<button class="toggle-dark" onclick="toggleDarkMode()">🌙</button>
<button class="toggle-lang" onclick="cambiarIdioma()">EN</button>

<?php
if (isset($_GET['ok']) && $_GET['ok'] == 1) {
    echo "<script>var mensajeExito = 'Contraseña actualizada exitosamente.';</script>";
} elseif (isset($_GET['error']) && $_GET['error'] == 1) {
    echo "<script>var mensajeError = 'La contraseña actual es incorrecta.';</script>";
} else {
    echo "<script>var mensajeExito=''; var mensajeError='';</script>";
}
?>
```

<script>
    function toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
        localStorage.setItem('modoOscuro', document.body.classList.contains('dark-mode'));
    }

    function cambiarIdioma() {
        localStorage.setItem('idioma', 'en'); // Guardamos idioma
        document.getElementById('titulo').textContent = 'Modify Account';
        document.getElementById('saludo').innerHTML = 'Current user: <strong><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong><br><a href="cerrarsesion.php" id="cerrar-sesion">[Log out]</a>';
        document.getElementById('label-actual').textContent = 'Current password:';
        document.getElementById('label-nueva').textContent = 'New password:';
        document.getElementById('label-foto').textContent = 'New profile picture:';
        document.getElementById('boton-actualizar').value = 'Update';

        if(typeof mensajeExito !== 'undefined' && mensajeExito) {
            alert('Password updated successfully.');
        }
        if(typeof mensajeError !== 'undefined' && mensajeError) {
            alert('Current password is incorrect.');
        }
    }

    window.onload = function () {
        // Restaurar modo oscuro
        if (localStorage.getItem('modoOscuro') === 'true') {
            document.body.classList.add('dark-mode');
        }
        // Restaurar idioma
        if (localStorage.getItem('idioma') === 'en') {
            cambiarIdioma();
        }
        // Mostrar alert de PHP si existe
        if(typeof mensajeExito !== 'undefined' && mensajeExito) {
            alert(mensajeExito);
        }
        if(typeof mensajeError !== 'undefined' && mensajeError) {
            alert(mensajeError);
        }
    };
</script>

</body>
</html>
