<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sesión cerrada</title>
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
        font-family: 'Segoe UI', Arial, sans-serif;
        text-align: center;
        padding: 60px;
        margin: 0;
        transition: background-color 0.3s, color 0.3s;
    }

    h1 {
        color: var(--text-color);
        margin-bottom: 30px;
    }

    a {
        background-color: var(--accent-color);
        color: var(--button-text);
        text-decoration: none;
        padding: 12px 20px;
        border-radius: 6px;
        font-size: 16px;
        transition: background-color 0.3s ease, transform 0.2s ease;
        display: inline-block;
        margin: 10px 5px;
    }

    a:hover {
        background-color: var(--accent-hover);
        transform: scale(1.05);
    }

    /* Botón modo oscuro */
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

    /* Botón idioma */
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

<!-- 🔥 Botón traducir -->
<button class="toggle-lang" onclick="toggleEnglish()">EN/ES</button>

<h1 class="title">La sesión ha sido cerrada.</h1>

<a class="btn1" href="login.html">Volver a iniciar sesión</a>

<button class="toggle-dark" onclick="toggleDarkMode()">🌙</button>

<script>
let english = false;

// ⭐ CAMBIO DE IDIOMA
function toggleEnglish() {
    english = !english;

    const title = document.querySelector(".title");
    const btn1 = document.querySelector(".btn1");

    if (english) {
        title.innerHTML = "The session has been closed.";
        btn1.innerHTML = "Return to Login";
    } else {
        title.innerHTML = "La sesión ha sido cerrada.";
        btn1.innerHTML = "Volver a iniciar sesión";
    }
}

// ⭐ MODO OSCURO
function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
    localStorage.setItem('modoOscuro', document.body.classList.contains('dark-mode'));
}

// ⭐ Cargar modo oscuro guardado
window.onload = function () {
    if (localStorage.getItem('modoOscuro') === 'true') {
        document.body.classList.add('dark-mode');
    }
};
</script>

</body>
</html>
