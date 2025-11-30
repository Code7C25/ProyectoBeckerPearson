<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nuevo Post</title>
    <style>
    :root {
        --bg-color: #f4f6f8;
        --text-color: #1f2d3d;
        --primary-color: #1e3a8a;
        --primary-hover: #0f172a;
        --form-bg: #ffffff;
        --input-border: #1e3a8a;
        --button-bg: #1e3a8a;
        --button-text: #ffffff;
    }
    body.dark-mode {
        --bg-color: #111827;
        --text-color: #f3f4f6;
        --primary-color: #60a5fa;
        --primary-hover: #93c5fd;
        --form-bg: #1e2937;
        --input-border: #60a5fa;
        --button-bg: #3b82f6;
        --button-text: #ffffff;
    }
    body {
        background-color: var(--bg-color);
        font-family: 'Poppins', sans-serif;
        text-align: center;
        padding: 40px;
        color: var(--text-color);
        transition: background-color 0.3s ease, color 0.3s ease;
        position: relative;
    }
    h1 { color: var(--primary-color); margin-bottom: 10px; }
    h5 { font-weight: normal; }
    form {
        display: inline-block;
        text-align: left;
        padding: 30px;
        border-radius: 8px;
        background-color: var(--form-bg);
        border: 1px solid #ccc;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    input[type="text"], input[type="date"], input[type="time"], textarea, input[type="file"] {
        width: 100%;
        padding: 8px;
        margin: 6px 0 12px 0;
        border-radius: 4px;
        border: 1px solid var(--input-border);
        box-sizing: border-box;
        background-color: #fff;
        color: var(--text-color);
    }
    body.dark-mode input, body.dark-mode textarea {
        background-color: #1e293b;
        color: #f1f5f9;
    }
    textarea { resize: vertical; }
    input[type="submit"] {
        background-color: var(--button-bg);
        color: var(--button-text);
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
    }
    input[type="submit"]:hover { background-color: var(--primary-hover); }
    img { border-radius: 50%; width: 80px; height: 80px; object-fit: cover; margin-bottom: 10px; }
    a { color: var(--primary-color); text-decoration: none; }
    a:hover { text-decoration: underline; }
    .toggle-dark, #toggle-lang {
        position: absolute;
        background: none;
        border: none;
        cursor: pointer;
        transition: transform 0.2s ease;
    }
    .toggle-dark { top: 20px; right: 20px; font-size: 22px; color: var(--primary-color); }
    #toggle-lang { top: 60px; right: 20px; font-size: 16px; padding: 5px 10px; color: var(--primary-color); }
    .toggle-dark:hover { transform: rotate(20deg); }
    </style>
</head>
<body>
<?php
session_start();
if (isset($_SESSION['usuario'])) {
?>
    <h1 id="h1-titulo">Nuevo Post</h1>
    <h5 id="user-label"><?php echo $_SESSION['usuario']; ?> | <a href="cerrarsesion.php" id="cerrar-sesion">Cerrar sesión</a></h5>
    <img src="<?php echo 'perfiles/' . $_SESSION['foto']; ?>" alt="Perfil">
    <br><br>

<form method="post" action="guardarnuevopost.php" enctype="multipart/form-data">
    <input type="hidden" name="nickname" value="<?php echo $_SESSION['usuario']; ?>">

    <label for="idTit" id="label-titulo">Título:</label>
    <input type="text" name="titulo" id="idTit" required>

    <label for="idCuerpo" id="label-cuerpo">Cuerpo:</label>
    <textarea name="cuerpo" cols="40" rows="10" id="idCuerpo" placeholder="Escriba su publicación aquí"></textarea>

    <label for="idFoto" id="label-foto">Imagen:</label>
    <input type="file" name="foto" id="idFoto" accept="image/*">

    <label for="idFc" id="label-fc">Fecha de creación:</label>
    <input type="date" name="fc" id="idFc">

    <label for="idHc" id="label-hc">Hora de creación:</label>
    <input type="time" name="hc" id="idHc">

    <label for="idFp" id="label-fp">Fecha de publicación:</label>
    <input type="date" name="fp" id="idFp">

    <label for="idHp" id="label-hp">Hora de publicación:</label>
    <input type="time" name="hp" id="idHp">

    <input type="submit" name="enviar" id="submitBtn" value="GUARDAR">
</form>

<?php
} else {
    echo "<h2 id='login-warning'>Tenés que loguearte para poder ingresar a esta página.</h2>";
}
?>

<button class="toggle-dark" onclick="toggleDarkMode()">🌙</button>
<button id="toggle-lang">EN</button>

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
            titulo: "Nuevo Post",
            cuerpoPlaceholder: "Escriba su publicación aquí",
            guardar: "GUARDAR",
            tituloLabel: "Título:",
            cuerpoLabel: "Cuerpo:",
            fotoLabel: "Imagen:",
            fcLabel: "Fecha de creación:",
            hcLabel: "Hora de creación:",
            fpLabel: "Fecha de publicación:",
            hpLabel: "Hora de publicación:",
            cerrarSesion: "Cerrar sesión",
            loginWarning: "Tenés que loguearte para poder ingresar a esta página."
        },
        en: {
            titulo: "New Post",
            cuerpoPlaceholder: "Write your post here",
            guardar: "SAVE",
            tituloLabel: "Title:",
            cuerpoLabel: "Body:",
            fotoLabel: "Image:",
            fcLabel: "Creation Date:",
            hcLabel: "Creation Time:",
            fpLabel: "Publish Date:",
            hpLabel: "Publish Time:",
            cerrarSesion: "Logout",
            loginWarning: "You must log in to access this page."
        }
    };
    let idioma = localStorage.getItem('idioma') || 'es';

    function cambiarIdioma() {
        idioma = idioma === 'es' ? 'en' : 'es';
        localStorage.setItem('idioma', idioma);

        const h1 = document.getElementById('h1-titulo');
        if(h1) h1.textContent = textos[idioma].titulo;

        const textarea = document.getElementById('idCuerpo');
        if(textarea) textarea.placeholder = textos[idioma].cuerpoPlaceholder;

        const submitBtn = document.getElementById('submitBtn');
        if(submitBtn) submitBtn.value = textos[idioma].guardar;

        // Labels
        const labels = [
            'label-titulo','label-cuerpo','label-foto','label-fc',
            'label-hc','label-fp','label-hp'
        ];
        labels.forEach(id => {
            const el = document.getElementById(id);
            if(el) el.textContent = textos[idioma][id.replace('label-', '') + 'Label'];
        });

        // Cerrar sesión
        const cerrar = document.getElementById('cerrar-sesion');
        if(cerrar) cerrar.textContent = textos[idioma].cerrarSesion;

        // Mensaje de login
        const warning = document.getElementById('login-warning');
        if(warning) warning.textContent = textos[idioma].loginWarning;

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
