<?php
session_start();

$mensaje = ""; // Initialize the $mensaje variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include("./bd.php");

    // Retrieve user input
    $usuario = filter_input(INPUT_POST, 'usuario', FILTER_DEFAULT);
    $password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);

    if ($usuario && $password) {
        try {
            // Securely fetch the user
            $query = $conexion->prepare("SELECT * FROM `usuarios` WHERE `usuario` = :usuario");
            $query->bindParam(":usuario", $usuario);
            $query->execute();
            $usuario_encontrado = $query->fetch(PDO::FETCH_ASSOC);

            // Verify user and password
            if ($usuario_encontrado && password_verify($password, $usuario_encontrado['password'])) {
                // Regenerate session to prevent fixation attacks
                session_regenerate_id(true);
                $_SESSION["usuario"] = htmlspecialchars($usuario_encontrado['usuario']);
                $_SESSION["logueado"] = true;
                header("Location: index.php");
                exit();
            } else {
                // Generic error message for both invalid username and password
                $mensaje = "Usuario o contraseña incorrecta.";
            }
        } catch (PDOException $e) {
            // Generic server error message
            $mensaje = "Error en el servidor. Inténtelo más tarde.";
        }
    } else {
        $mensaje = "Por favor, complete todos los campos.";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>LOGIN</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<header>
    <!-- Navbar placeholder -->
</header>
<main>
    <div class="container">
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
                <br />
                <br />
                <?php if ($mensaje): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <strong><?= htmlspecialchars($mensaje) ?></strong>
                    </div>
                <?php endif; ?>
                <div class="card">
                    <div class="card-header">LOGIN</div>
                    <div class="card-body">
                        <form action="" method="post">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                            <div class="mb-3">
                                <label for="usuario" class="form-label">Usuario</label>
                                <input type="text" class="form-control" name="usuario" id="usuario" required />
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="password" required />
                            </div>
                            <button type="submit" class="btn btn-primary">Entrar</button>
                        </form>
                        <div class="mt-3">
                            <a href="solicitar_restauracion.php">¿Olvidaste tu contraseña?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<footer>
    <!-- Footer placeholder -->
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
