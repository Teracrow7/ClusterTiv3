<?php
include("../../bd.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Generar y verificar el token CSRF
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (isset($_GET['txtID']) && filter_var($_GET['txtID'], FILTER_VALIDATE_INT)) {
    $txtID = $_GET['txtID'];

    // Seleccionar registro a editar
    $sentencia = $conexion->prepare("SELECT * FROM `usuarios` WHERE id = :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);

    $usuario = $registro['usuario'];
    $correo = $registro['correo'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar el token CSRF
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Error: CSRF token inválido.");
    }

    $txtID = $_POST['txtID'];
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $correo = $_POST['correo'];

    // Encriptar la contraseña si se proporcionó una nueva
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        // Mantener la contraseña existente
        $sentencia_pass = $conexion->prepare("SELECT `password` FROM `usuarios` WHERE `id` = :id");
        $sentencia_pass->bindParam(":id", $txtID);
        $sentencia_pass->execute();
        $usuario_existente = $sentencia_pass->fetch(PDO::FETCH_ASSOC);
        $hashed_password = $usuario_existente['password'];
    }

    try {
        $sentencia = $conexion->prepare("UPDATE `usuarios` SET `usuario`=:usuario, `password`=:password, correo=:correo WHERE `id` = :id");
        $sentencia->bindParam(":usuario", $usuario);
        $sentencia->bindParam(":password", $hashed_password);
        $sentencia->bindParam(":correo", $correo);
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();

        $mensaje = "Registro modificado con éxito";
        header("Location: index.php?mensaje=" . urlencode($mensaje));
    } catch (Exception $e) {
        echo "Error al modificar el registro: " . $e->getMessage();
    }
}

include("../../templates/header.php");
?>
<div class="card">
    <div class="card-header">Editar Usuario</div>
    <div class="card-body">
        <form action="" enctype="multipart/form-data" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div class="mb-3">
                <label for="txtID" class="form-label">ID:</label>
                <input value="<?php echo htmlspecialchars($txtID, ENT_QUOTES, 'UTF-8'); ?>"
                    type="text" class="form-control" name="txtID" id="txtID" placeholder="ID" readonly />
            </div>
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <input value="<?php echo htmlspecialchars($usuario, ENT_QUOTES, 'UTF-8'); ?>"
                    type="text" class="form-control" name="usuario" id="usuario" placeholder="Usuario" />
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password" />
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Email:</label>
                <input value="<?php echo htmlspecialchars($correo, ENT_QUOTES, 'UTF-8'); ?>"
                    type="email" class="form-control" name="correo" id="correo" placeholder="Email" />
            </div>

            <button type="submit" class="btn btn-success">Actualizar</button>
            <a class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
</div>

<?php include("../../templates/footer.php"); ?>
