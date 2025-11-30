<?php
session_start();

// ===== CAMBIO DE IDIOMA CORREGIDO =====
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
    $url = strtok($_SERVER["REQUEST_URI"], '?'); // limpia GET
    header("Location: $url");
    exit;
}

$lang = $_SESSION['lang'] ?? 'es';
function t($es, $en) {
    global $lang;
    return $lang === 'en' ? $en : $es;
}

// =======================
// 🔹 CONEXIÓN REAL
// =======================
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "sql312.infinityfree.com";
$user = "if0_40552637";
$pass = "lBvlkDTKZT65O";
$db   = "if0_40552637_bdblog";

$cnx = mysqli_connect($host, $user, $pass, $db);

if (!$cnx) {
    die("<h1 style='color:red;'>❌ Error conectando a la base: " . mysqli_connect_error() . "</h1>");
}

// =======================
// 🔹 ROLES
// =======================
if (isset($_SESSION['usuario']) && $_SESSION['usuario'] === "admin") {
    $rol = "admin";
    $usuario = "admin";
} elseif (isset($_GET['guest']) && $_GET['guest'] == 1) {
    $usuario = "Invitado";
    $rol = "invitado";
    session_unset();
    session_destroy();
} elseif (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $rol = "registrado";
} else {
    $usuario = "Invitado";
    $rol = "invitado";
}

// =======================
// 🔹 FILTROS Y POSTS
// =======================
$fechaActual = date('Y-m-d');
$condiciones = ["FECHA_PUBL <= '$fechaActual'"];

if (!empty($_GET['fecha'])) {
    $f = mysqli_real_escape_string($cnx, $_GET['fecha']);
    $condiciones[] = "FECHA_PUBL = '$f'";
}

if (!empty($_GET['autor'])) {
    $a = mysqli_real_escape_string($cnx, $_GET['autor']);
    $condiciones[] = "NICKNAME LIKE '%$a%'";
}

$sql = "SELECT * FROM posts WHERE " . implode(" AND ", $condiciones) . " ORDER BY FECHA_PUBL DESC";

$resultado = mysqli_query($cnx, $sql) or die("Error mostrando publicaciones.");
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
    <meta charset="UTF-8">
    <title><?= t('Publicaciones','Posts') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-color: #f4f6f8;
            --text-color: #1f2d3d;
            --header-bg: #1e3a8a;
            --header-text: #ffffff;
            --link-color: #1e3a8a;
            --post-bg: #ffffff;
            --post-title: #1e3a8a;
            --post-meta: #6b7280;
        }

        body.dark-mode {
            --bg-color: #111827;
            --text-color: #f3f4f6;
            --header-bg: #1f2937;
            --header-text: #f3f4f6;
            --link-color: #60a5fa;
            --post-bg: #1e293b;
            --post-title: #93c5fd;
            --post-meta: #9ca3af;
        }

        body {
            margin:0;
            background:var(--bg-color);
            color:var(--text-color);
            font-family:'Poppins',sans-serif;
        }

        header {
            background:var(--header-bg);
            color:var(--header-text);
            padding:12px 40px;
            display:flex;
            align-items:center;
            justify-content:center;
            gap:15px;
            position:relative;
        }

        header img.logo { width:45px; }

        .usuario {
            position:absolute;
            right:40px;
            top:15px;
        }
        .usuario a {
            color:var(--header-text);
            text-decoration:none;
            margin-left:12px;
        }

        .container {
            max-width:800px;
            margin:40px auto;
            padding:0 18px;
        }

        .post {
            background:var(--post-bg);
            border-left:6px solid var(--header-bg);
            padding:20px;
            margin-bottom:30px;
            border-radius:10px;
            box-shadow:0 4px 16px rgba(0,0,0,0.07);
        }
        .post h3 { color:var(--post-title); }
        .post p.meta { color:var(--post-meta); font-size:13px; }

        .post img.main-img {
            width:100%;
            max-height:300px;
            object-fit:cover;
            margin:10px 0;
            border-radius:8px;
        }

        .icons a {
            font-size:22px;
            margin-right:10px;
            text-decoration:none;
        }

        .comentarios {
            margin-top:20px;
            padding:15px;
            background:var(--post-bg);
            border-radius:10px;
            border:1px solid #ddd;
        }

        .comentario {
            padding:8px 0;
            border-bottom:1px solid #bbb;
        }
        .comentario:last-child { border-bottom:none; }

        .fecha { font-size:12px; color:var(--post-meta); }

        .btn-admin {
            margin-top:10px;
        }
        .btn-edit, .btn-delete {
            padding:8px 12px;
            border-radius:6px;
            text-decoration:none;
            color:white;
            font-size:14px;
        }
        .btn-edit { background:#1e88e5; }
        .btn-delete { background:#d32f2f; }

        .toggle-dark {
            position:fixed;
            right:20px;
            bottom:20px;
            font-size:22px;
            padding:10px;
            border-radius:50%;
            cursor:pointer;
        }

        .toggle-lang {
            position:fixed;
            left:20px;
            bottom:20px;
            font-size:16px;
            padding:8px 12px;
            border-radius:8px;
            cursor:pointer;
        }
    </style>

</head>

<body>

<!-- BOTÓN DARK MODE -->
<button class="toggle-dark" onclick="toggleDarkMode()">🌙</button>

<!-- BOTÓN CAMBIO DE IDIOMA -->
<form method="GET" class="toggle-lang">
    <button type="submit" name="lang" value="<?= $lang === 'es' ? 'en' : 'es' ?>">
        <?= $lang === 'es' ? 'EN' : 'ES' ?>
    </button>
</form>

<header>
    <img class="logo" src="imagenes/logo.svg" alt="">
    <h1><?= t('Publicaciones','Posts') ?></h1>

    <div class="usuario">
        <?php
        if ($rol === "registrado" || $rol === "admin") {
            echo "<span>$usuario</span>";
            echo "<a href='cerrarsesion.php'>".t('Cerrar sesión','Log out')."</a>";
        } else {
            echo "<span>".t('Invitado','Guest')."</span>";
            echo "<a href='login.html'>".t('Iniciar sesión','Log in')."</a>";
        }
        ?>
    </div>
</header>

<div class="container">

    <!-- FILTROS -->
    <form method="GET">
        <label><?= t('Filtrar por fecha:','Filter by date:') ?></label>
        <input type="date" name="fecha" value="<?= $_GET['fecha'] ?? '' ?>">

        <label><?= t('Filtrar por autor:','Filter by author:') ?></label>
        <input type="text" name="autor" value="<?= $_GET['autor'] ?? '' ?>" placeholder="Nickname">

        <button type="submit"><?= t('Filtrar','Filter') ?></button>
        <a href="index.php"><?= t('Limpiar','Clear') ?></a>
    </form>

    <br>

    <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
        <?php $idPost = $fila['ID']; ?>

        <div class="post">
            <h3><?= $fila['TITULO'] ?></h3>
            <p class="meta"><?= $fila['NICKNAME'] ?> • <?= $fila['FECHA_PUBL'] ?></p>

            <?php if (!empty($fila['IMAGEN'])): ?>
                <img class="main-img" src="imagenes/<?= $fila['IMAGEN'] ?>" alt="">
            <?php endif; ?>

            <p><?= nl2br($fila['CUERPO']) ?></p>

            <div class="icons">
                <a href="reaccionar.php?id=<?= $idPost ?>&tipo=corazon">❤️</a>
                <a href="reaccionar.php?id=<?= $idPost ?>&tipo=feliz">🙂</a>
            </div>

            <?php if ($rol === "admin"): ?>
                <div class="btn-admin">
                    <a class="btn-edit" href="editar_form.php?id=<?= $idPost ?>"><?= t('Editar','Edit') ?></a>
                    <a class="btn-delete" onclick="return confirm('<?= t('¿Eliminar?','Delete?') ?>')" href="eliminar.php?id=<?= $idPost ?>"><?= t('Eliminar','Delete') ?></a>
                </div>
            <?php endif; ?>

            <?php
            $reac = mysqli_query($cnx, "SELECT * FROM reacciones WHERE ID_POST=$idPost ORDER BY FECHA DESC");
            ?>

            <div class="comentarios">
                <h4><?= t('Reacciones','Reactions') ?></h4>

                <?php if (mysqli_num_rows($reac) === 0): ?>
                    <p><?= t('No hay reacciones todavía','No reactions yet') ?></p>
                <?php endif; ?>

                <?php while ($r = mysqli_fetch_assoc($reac)): ?>
                    <div class="comentario">
                        <strong><?= $r['NICKNAME'] ?></strong>
                        <?= t('reaccionó con','reacted with') ?>
                        <?= $r['TIPO'] == "corazon" ? "❤️" : "🙂" ?>
                        <span class="fecha">(<?= $r['FECHA'] ?>)</span>
                    </div>
                <?php endwhile; ?>
            </div>

        </div>

    <?php endwhile; mysqli_close($cnx); ?>

</div>

<script>
function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
    localStorage.setItem("modo", document.body.classList.contains("dark-mode"));
}

window.onload = function() {
    if (localStorage.getItem("modo") === "true") {
        document.body.classList.add("dark-mode");
    }
};
</script>

</body>
</html>
