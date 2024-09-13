<?php 
include("../../bd.php");

if (isset($_GET['txtID'])) {
    // Seleccionar registro a editar 
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";

    $sentencia = $conexion->prepare("SELECT * FROM `usuarios` WHERE id = :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);

    
    $usuario = $registro['usuario'];
    $correo = $registro['correo'];
}

if ($_POST) {
    $txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
    $usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : "";
    $password = (isset($_POST['password'])) ? $_POST['password'] : "";
    $correo = (isset($_POST['correo'])) ? $_POST['correo'] : "";

    // Encriptar la contraseña si se proporcionó una nueva
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        // Si no se proporciona una nueva contraseña, mantener la contraseña existente
        $sentencia_pass = $conexion->prepare("SELECT `password` FROM `usuarios` WHERE `id` = :id");
        $sentencia_pass->bindParam(":id", $txtID);
        $sentencia_pass->execute();
        $usuario_existente = $sentencia_pass->fetch(PDO::FETCH_ASSOC);
        $hashed_password = $usuario_existente['password'];
    }

    $sentencia = $conexion->prepare("UPDATE `usuarios` SET `usuario`=:usuario, `password`=:password, correo=:correo WHERE `id` = :id");
   
    $sentencia->bindParam(":usuario", $usuario);
    $sentencia->bindParam(":password", $hashed_password); // Utiliza la contraseña encriptada
    $sentencia->bindParam(":correo", $correo);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    $mensaje = "Registro modificado con éxito";
    header("Location: index.php?mensaje=".$mensaje);
}
include("../../templates/header.php");
?>
<div class="card">
    <div class="card-header">Editar Usuario</div>
    <div class="card-body">
        <form action="" enctype="multipart/form-data" method="post">
        <div class="mb-3">
                <label for="txtID" class="form-label">ID:</label>
                <input
                    value="<?php echo $txtID; ?>"
                    type="text"
                    class="form-control"
                    name="txtID"
                    id="txtID"
                    aria-describedby="helpId"
                    placeholder="ID"
                    readonly
                />
            </div>
        <div class="mb-3">
            <label for="usuario" class="form-label">Usuario:</label>
            <input value="<?php echo $usuario; ?>"
                type="text"
                class="form-control"
                name="usuario"
                id="usuario"
                aria-describedby="helpId"
                placeholder="Usuario"
            />
         </div>
         <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input value="<?php echo $password; ?>" 
                type="password"
                class="form-control"
                name="password"
                id="password"
                aria-describedby="helpId"
                placeholder="Password"
            />
         </div>
         
         
         <div class="mb-3">
            <label for="correo" class="form-label">Email:</label>
            <input value="<?php echo $correo; ?>"
                type="email"
                class="form-control"
                name="correo"
                id="correo"
                aria-describedby="helpId"
                placeholder="Email"
            />
         </div>
        

         <button
            type="submit"
            class="btn btn-success"
         >
            Actualizar
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
    <div class="card-footer text-muted">

    </div>
</div>

<?php 
include("../../templates/footer.php");
?>
