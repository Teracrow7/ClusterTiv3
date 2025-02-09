<?php
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $token = isset($_GET['token']) ? htmlspecialchars($_GET['token'], ENT_QUOTES, 'UTF-8') : null;

    if ($token) {
        include("./bd.php");

        try {
            $query = $conexion->prepare("SELECT * FROM `usuarios` WHERE `token` = :token");
            $query->bindParam(":token", $token, PDO::PARAM_STR);
            $query->execute();
            $usuario_encontrado = $query->fetch(PDO::FETCH_ASSOC);

            if (!$usuario_encontrado) {
                $mensaje = "Enlace de recuperación inválido o caducado.";
            }
        } catch (PDOException $e) {
            $mensaje = "Error al conectar con el servidor.";
        }
    } else {
        $mensaje = "Token inválido.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include("./bd.php");

    $token = isset($_POST['token']) ? htmlspecialchars($_POST['token'], ENT_QUOTES, 'UTF-8') : null;
    $nueva_password = isset($_POST['password']) ? $_POST['password'] : null;

    if ($token && $nueva_password) {
        try {
            $nueva_password_hash = password_hash($nueva_password, PASSWORD_BCRYPT);

            // Update password and invalidate the token
            $query = $conexion->prepare("UPDATE `usuarios` SET `password` = :password, `token` = NULL WHERE `token` = :token");
            $query->bindParam(":password", $nueva_password_hash, PDO::PARAM_STR);
            $query->bindParam(":token", $token, PDO::PARAM_STR);

            if ($query->execute() && $query->rowCount() > 0) {
                $mensaje = "Contraseña restablecida correctamente.";
            } else {
                $mensaje = "Error: Enlace de recuperación inválido o ya utilizado.";
            }
        } catch (PDOException $e) {
            $mensaje = "Error al conectar con el servidor.";
        }
    } else {
        $mensaje = "Por favor, complete todos los campos.";
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
                    <div class="alert alert-info"><?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?></div>
                <?php endif; ?>
                <?php if (!isset($usuario_encontrado) || $usuario_encontrado): ?>
                    <div class="card">
                        <div class="card-header">Restablecer contraseña</div>
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Nueva contraseña</label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Ingrese nueva contraseña" required />
                                </div>
                                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                                <input name="" id="" class="btn btn-primary" type="submit" value="Restablecer contraseña" />
                            </form>
                            <div class="mt-3">
                                <a href="login.php" class="btn btn-secondary">Regresar al Login</a>
                            </div>
                        </div>
                        <div class="card-footer text-muted"></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
</body>
</html>
