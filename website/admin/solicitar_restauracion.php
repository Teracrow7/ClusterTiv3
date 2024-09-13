<?php
$mensaje = "";

// Detectar automáticamente el protocolo
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

// Obtener el host
$host = $_SERVER['HTTP_HOST'];

// Obtener el URI base
$uri = rtrim(dirname($_SERVER['REQUEST_URI']), '/\\');

// Construir la URL base
$url_base = $protocol . $host . "/admin/";

// Si estamos en localhost, se ajusta la URL base si es necesario
if ($host == 'localhost') {
    $url_base = $protocol . $host . "/admin/";
}

if ($_POST) {
    include("./bd.php");
    $usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : "";

    // Verificar si el usuario existe
    $query = $conexion->prepare("SELECT * FROM `usuarios` WHERE `usuario` = :usuario");
    $query->bindParam(":usuario", $usuario);
    $query->execute();
    $usuario_encontrado = $query->fetch(PDO::FETCH_ASSOC);

    if ($usuario_encontrado) {
        // Crear un token de recuperación
        $token = bin2hex(random_bytes(16));
        $query = $conexion->prepare("UPDATE `usuarios` SET `token` = :token WHERE `usuario` = :usuario");
        $query->bindParam(":token", $token);
        $query->bindParam(":usuario", $usuario);
        $query->execute();

        $link = $url_base."recuperar_password.php?token=$token";
        $mensaje = "Para restablecer su contraseña, por favor visite el siguiente enlace: <a href='$link'>$link</a>";
    } else {
        $mensaje = "El usuario no existe.";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Restablecer contraseña</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<main>
    <div class="container">
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
                <br/>
                <br/>
                <?php if ($mensaje): ?>
                    <div class="alert alert-info"><?php echo $mensaje; ?></div>
                <?php endif; ?>
                <div class="card">
                    <div class="card-header">Restablecer contraseña</div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="usuario" class="form-label">Usuario</label>
                                <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Ingrese su usuario" required />
                            </div>
                            <input name="" id="" class="btn btn-primary" type="submit" value="Enviar enlace" />
                        </form>
                        <div class="mt-3">
                            <a href="login.php" class="btn btn-secondary">Regresar al Login</a>
                        </div>
                    </div>
                    <div class="card-footer text-muted"></div>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
