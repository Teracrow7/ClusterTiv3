<?php
session_start();

// Detectar automáticamente el protocolo
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

// Obtener el host
$host = $_SERVER['HTTP_HOST'];

// Obtener el URI base
$uri = rtrim(dirname($_SERVER['REQUEST_URI']), '/\\');

// Construir la URL base
$url_base = $protocol . $host . "/website/admin/";

// Si estamos en localhost, se ajusta la URL base si es necesario
if ($host == 'localhost') {
    $url_base = $protocol . $host . "/website/admin/";
}

if (!isset($_SESSION['usuario'])) {
    header("Location:" . $url_base . "login.php");
    exit(); // Asegurarse de detener la ejecución después de la redirección
}
?>


<!doctype html>
<html lang="en">
    <head>
        <title>ADMINISTRADOR CONTENIDO CLUSTER TI</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
    </head>

    <body>
        <header>
            <nav class="navbar navbar-expand navbar-light bg-light">
                <div class="nav navbar-nav">
                    <a class="nav-item nav-link active" href="#" aria-current="page"
                        >Administrador <span class="visually-hidden">(current)</span></a
                    >
                    <a class="nav-item nav-link" href="<?php echo $url_base; ?>secciones/slider/index.php">Slider</a>
                    <a class="nav-item nav-link" href="<?php echo $url_base; ?>secciones/servicios/index.php">Servicios</a>
                    <a class="nav-item nav-link" href="<?php echo $url_base; ?>secciones/portafolio/index.php">Portafolio</a>
                    <a class="nav-item nav-link" href="<?php echo $url_base; ?>secciones/entradas/index.php">Entradas</a>
                    <a class="nav-item nav-link" href="<?php echo $url_base; ?>secciones/equipo/index.php">Equipo</a>
                    <a class="nav-item nav-link" href="<?php echo $url_base; ?>secciones/configuraciones/">Configuraciones</a>
                    <a class="nav-item nav-link" href="<?php echo $url_base; ?>secciones/usuarios/index.php">Usuarios</a>
                    <a class="nav-item nav-link" href="<?php echo $url_base; ?>cerrar.php">Cerrar sesión</a>
                </div>
            </nav>
            
        </header>
        <main class="container">
        <br/>
        <script>
            <?php if (isset($_GET['mensaje'])) {?>
            Swal.fire({icon:"success", title:"<?php echo $_GET['mensaje'];?>"});
            <?php } ?>
        </script>