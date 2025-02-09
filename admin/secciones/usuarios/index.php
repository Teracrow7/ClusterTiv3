<?php
include("../../bd.php");

// Verificar si se ha pasado un ID válido para eliminar
if (isset($_GET['txtID']) && filter_var($_GET['txtID'], FILTER_VALIDATE_INT)) {
    $txtID = $_GET['txtID'];

    // Eliminar registro de usuario
    $sentencia = $conexion->prepare("DELETE FROM usuarios WHERE `id` = :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
}

// Obtener usuarios
$sentencia = $conexion->prepare("SELECT * FROM `usuarios`");
$sentencia->execute();
$lista_usuarios = $sentencia->fetchAll(PDO::FETCH_ASSOC);

include("../../templates/header.php");
?>

<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar</a>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table table-primary">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre Usuario</th>
                        <th scope="col">Password</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_usuarios as $registros) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($registros['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($registros['usuario'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($registros['password'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($registros['correo'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <a name="" id="" class="btn btn-info" href="editar.php?txtID=<?php echo htmlspecialchars($registros['id'], ENT_QUOTES, 'UTF-8'); ?>" role="button">Editar</a>
                                |
                                <a name="" id="" class="btn btn-danger" href="index.php?txtID=<?php echo htmlspecialchars($registros['id'], ENT_QUOTES, 'UTF-8'); ?>" role="button" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include("../../templates/footer.php");
?>
