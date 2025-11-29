<?php
session_start();
include 'conexion.php';

$u = $_REQUEST['nick'];
$pass = $_REQUEST['contra']; // ✔ SIN MD5

// -------------------------------
// ✔ LOGIN ESPECIAL PARA ADMIN
// -------------------------------
if ($u === "admin" && $pass === "123") {
    $_SESSION['usuario'] = "admin";
    $_SESSION['foto'] = "admin.png"; // opcional
    $_SESSION['is_admin'] = true;

    header("Location: index.php");
    exit;
}

// -------------------------------
// ✔ LOGIN NORMAL (USUARIOS DE BD)
// -------------------------------
$sql = "SELECT NICKNAME, password, FOTO FROM usuarios 
        WHERE NICKNAME='$u' AND password='$pass'";

$resultado = mysqli_query($cnx, $sql) or die("No se pudo validar el usuario");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bienvenida</title>

<style>
    :root {
        --bg-color: #f4f6f8;
        --text-color: #2c3e50;
        --accent-color: #1e3a8a;
        --accent-hover: #172554;
        --button-text: #ffffff;
    }

    body.dark-mode {
        --bg-color: #121212;
        --text-color: #e0e0e0;
        --accent-color: #3b82f6;
        --accent-hover: #2563eb;
        --button-text: #ffffff;
    }

    body {
        background-color: var(--bg-color);
        color: var(--text-color);
        font-family: 'Segoe UI', 'Arial', sans-serif;
        text-align: center;
        padding: 60px 20px;
        transition: background-color 0.3s, color 0.3s;
    }

    a {
        color: var(--button-text);
        background-color: var(--accent-color);
        padding: 10px 15px;
        border-radius: 6px;
        margin: 10px 5px;
        display: inline-block;
        text-decoration: none;
        transition: background-color 0.3s, transform 0.2s;
    }

    a:hover {
        background-color: var(--accent-hover);
        transform: scale(1.05);
    }

    /* BOTÓN MODO OSCURO */
    .toggle-dark {
        position: absolute;
        top: 20px;
        right: 20px;
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

    /* BOTÓN IDIOMA */
    .toggle-lang {
        position: absolute;
        top: 20px;
        left: 20px;
        background-color: #1e3a8a;
        color: white;
        border: none;
        padding: 10px 15px;
        cursor: pointer;
        border-radius: 6px;
        font-weight: bold;
    }
</style>

</head>
<body>

<!-- 🔥 BOTÓN PARA CAMBIAR A INGLÉS -->
<button class="toggle-lang" onclick="toggleEnglish()">EN/ES</button>

<?php
if (mysqli_num_rows($resultado) == 0) {
    echo "<h1 class='title'>Usuario o contraseña incorrectos</h1>";
    echo "<a class='btn1' href='login.html'>Volver al login</a>";
    echo "<a class='btn2' href='index.php'>Ir al Inicio</a>";
} else {
    $fila = mysqli_fetch_array($resultado);

    $_SESSION['usuario'] = $u;
    $_SESSION['foto'] = $fila['FOTO'];
    $_SESSION['is_admin'] = false;

    echo "<h1 class='title'>Bienvenido/a $u</h1>";
    echo "<img src='perfiles/$_SESSION[foto]'><br>";
    echo "<a class='btn1' href='nuevopost.php'>Nuevo Post</a>";
    echo "<a class='btn2' href='editarus.php'>Editar Usuario</a>";
    echo "<a class='btn3' href='cerrarsesion.php'>Cerrar Sesión</a>";
    echo "<a class='btn4' href='index.php'>Ir al Inicio</a>";
}
?>

<button class="toggle-dark" onclick="document.body.classList.toggle('dark-mode')">🌙</button>

<script>
let english = false;

function toggleEnglish() {
    english = !english;

    const title = document.querySelector(".title");
    const btn1 = document.querySelector(".btn1");
    const btn2 = document.querySelector(".btn2");
    const btn3 = document.querySelector(".btn3");
    const btn4 = document.querySelector(".btn4");

    if (title) {
        if (english) {
            if (title.innerHTML.includes("incorrectos")) {
                title.innerHTML = "Incorrect username or password";
                if (btn1) btn1.innerHTML = "Back to Login";
                if (btn2) btn2.innerHTML = "Go to Home";
            } else {
                title.innerHTML = "Welcome <?php echo $u; ?>";
                if (btn1) btn1.innerHTML = "New Post";
                if (btn2) btn2.innerHTML = "Edit User";
                if (btn3) btn3.innerHTML = "Log Out";
                if (btn4) btn4.innerHTML = "Go to Home";
            }
        } else {
            if (title.innerHTML.includes("Incorrect")) {
                title.innerHTML = "Usuario o contraseña incorrectos";
                if (btn1) btn1.innerHTML = "Volver al login";
                if (btn2) btn2.innerHTML = "Ir al Inicio";
            } else {
                title.innerHTML = "Bienvenido/a <?php echo $u; ?>";
                if (btn1) btn1.innerHTML = "Nuevo Post";
                if (btn2) btn2.innerHTML = "Editar Usuario";
                if (btn3) btn3.innerHTML = "Cerrar Sesión";
                if (btn4) btn4.innerHTML = "Ir al Inicio";
            }
        }
    }
}
</script>

</body>
</html>
