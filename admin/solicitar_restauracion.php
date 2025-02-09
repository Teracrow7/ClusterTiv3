<?php
$mensaje = "";

// Construct the base URL dynamically
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['REQUEST_URI']), '/\\');
$url_base = $protocol . $host . $uri . "/";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include("./bd.php");
    $usuario = isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario'], ENT_QUOTES, 'UTF-8') : "";

    // Verify user exists
    $query = $conexion->prepare("SELECT * FROM `usuarios` WHERE `usuario` = :usuario");
    $query->bindParam(":usuario", $usuario, PDO::PARAM_STR);
    $query->execute();
    $usuario_encontrado = $query->fetch(PDO::FETCH_ASSOC);

    if ($usuario_encontrado) {
        // Create recovery token with expiration
        $token = bin2hex(random_bytes(16));
        $expiration = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token expires in 1 hour
        $query = $conexion->prepare("UPDATE `usuarios` SET `token` = :token, `token_expiration` = :expiration WHERE `usuario` = :usuario");
        $query->bindParam(":token", $token, PDO::PARAM_STR);
        $query->bindParam(":expiration", $expiration, PDO::PARAM_STR);
        $query->bindParam(":usuario", $usuario, PDO::PARAM_STR);
        $query->execute();

        // Generate recovery link
        $link = $url_base . "recuperar_password.php?token=" . urlencode($token);

        // Display the message (use in testing only, replace with email in production)
        $mensaje = "Para restablecer su contraseña, por favor visite el siguiente enlace: <a href='" . htmlspecialchars($link, ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($link, ENT_QUOTES, 'UTF-8') . "</a>";

        // In production, send email instead of displaying the link
        // Example: sendEmail($usuario_encontrado['email'], "Password Recovery", $mensaje);
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
