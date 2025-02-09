<?php 
include("../../bd.php");

if ($_POST) {
    // Obtener y sanitizar entradas
    $usuario = isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario'], ENT_QUOTES, 'UTF-8') : "";
    $password = isset($_POST['password']) ? $_POST['password'] : "";
    $correo = isset($_POST['correo']) ? filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL) : "";

    // Validar formato del correo electrónico
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "El correo electrónico no es válido.";
        header("Location: index.php?mensaje=" . urlencode($mensaje));
        exit;
    }

    // Encriptar la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Preparar y ejecutar la consulta
        $sentencia = $conexion->prepare("INSERT INTO `usuarios` (`id`, `usuario`, `password`, correo) 
        VALUES (NULL, :usuario, :password, :correo);");
    
        $sentencia->bindParam(":usuario", $usuario);
        $sentencia->bindParam(":password", $hashed_password); // Se inserta el hash de la contraseña
        $sentencia->bindParam(":correo", $correo);
        
        $sentencia->execute();
        $mensaje = "Registro Creado con éxito";
        header("Location: index.php?mensaje=" . urlencode($mensaje));
    } catch (Exception $e) {
        // Manejo de errores
        $mensaje = "Error al registrar usuario: " . $e->getMessage();
        header("Location: index.php?mensaje=" . urlencode($mensaje));
    }
}

include("../../templates/header.php");
?>

<div class="card">
    <div class="card-header">Usuario</div>
    <div class="card-body">
        <form action="" method="post">
            <div class="mb-3">
                <label for="usuario" class="form-label">Nombre de usuario:</label>
                <input
                    type="text"
                    class="form-control"
                    name="usuario"
                    id="usuario"
                    aria-describedby="helpId"
                    placeholder="Nombre de usuario"
                    value="<?php echo isset($usuario) ? $usuario : ''; ?>"
                />
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                    type="password"
                    class="form-control"
                    name="password"
                    id="password"
                    aria-describedby="helpId"
                    placeholder="Password"
                />
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">Email</label>
                <input
                    type="email"
                    class="form-control"
                    name="correo"
                    id="correo"
                    aria-describedby="helpId"
                    placeholder="Email"
                    value="<?php echo isset($correo) ? $correo : ''; ?>"
                />
            </div>
            <button
                type="submit"
                class="btn btn-success"
            >
                Agregar
            </button>
            <a
                name=""
                id=""
                class="btn btn-primary"
                href="index.php"
                role="button"
                >Cancelar</a
            >
        </form>
    </div>
</div>

<?php 
include("../../templates/footer.php");
?>
