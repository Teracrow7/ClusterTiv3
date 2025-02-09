<?php 
include("../../bd.php");

// Eliminar registro si se recibe un ID válido
if (isset($_GET['txtID'])) {
    // Sanitizar el ID para asegurarse de que es un valor entero
    $txtID = filter_input(INPUT_GET, 'txtID', FILTER_VALIDATE_INT);

    if ($txtID) {
        // Preparar la sentencia de eliminación
        $sentencia = $conexion->prepare("DELETE FROM slider WHERE `id` = :id");
        $sentencia->bindParam(":id", $txtID, PDO::PARAM_INT);
        $sentencia->execute();

        // Redirigir con un mensaje de éxito
        $mensaje = "Registro eliminado con éxito";
        header("Location: index.php?mensaje=" . urlencode($mensaje));
        exit();
    } else {
        // En caso de que el ID no sea válido
        $mensaje = "ID no válido";
        header("Location: index.php?mensaje=" . urlencode($mensaje));
        exit();
    }
}

// Obtener los registros del slider
$sentencia = $conexion->prepare("SELECT * FROM `slider`");
$sentencia->execute();
$lista_slider = $sentencia->fetchAll(PDO::FETCH_ASSOC);

include("../../templates/header.php");
?>

<div class="card">
    <div class="card-header">
        <a class="btn btn-primary" href="crear.php" role="button">Agregar Noticia</a>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table table-primary">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Título</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_slider as $registros) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($registros['id']); ?></td>
                            <td><img src="../../../assets/img/slider/<?php echo htmlspecialchars($registros['imagen']); ?>" width="90" height="90"></td>
                            <td><?php echo htmlspecialchars($registros['titulo']); ?></td>
                            <td><?php echo htmlspecialchars($registros['descripcion']); ?></td>
                            <td>
                                <a class="btn btn-info" href="editar.php?txtID=<?php echo htmlspecialchars($registros['id']); ?>" role="button">Editar</a>
                                |
                                <a class="btn btn-danger" href="index.php?txtID=<?php echo htmlspecialchars($registros['id']); ?>" role="button" onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?');">Eliminar</a>
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
