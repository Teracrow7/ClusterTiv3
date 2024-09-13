<?php
$mensaje = "";

if ($_GET) {
    $token = (isset($_GET['token'])) ? $_GET['token'] : "";

    include("./bd.php");
    $query = $conexion->prepare("SELECT * FROM `usuarios` WHERE `token` = :token");
    $query->bindParam(":token", $token);
    $query->execute();
    $usuario_encontrado = $query->fetch(PDO::FETCH_ASSOC);

    if (!$usuario_encontrado) {
        $mensaje = "Enlace de recuperación inválido.";
    }
}

if ($_POST) {
    $token = (isset($_POST['token'])) ? $_POST['token'] : "";
    $nueva_password = (isset($_POST['password'])) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : "";

    $query = $conexion->prepare("UPDATE `usuarios` SET `password` = :password, `token` = NULL WHERE `token` = :token");
    $query->bindParam(":password", $nueva_password);
    $query->bindParam(":token", $token);
    if ($query->execute()) {
        $mensaje = "Contraseña restablecida correctamente.";
    } else {
        $mensaje = "Error al restablecer la contraseña.";
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
                                <label for="password" class="form-label">Nueva contraseña</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Ingrese nueva contraseña" required />
                            </div>
                            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>" />
                            <input name="" id="" class="btn btn-primary" type="submit" value="Restablecer contraseña" />
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
