<?php 
include("../../bd.php");

if (isset($_GET['txtID'])) {
    // Eliminar registro
    $txtID = $_GET['txtID'];

    // Eliminar el servicio de la base de datos
    $sentencia = $conexion->prepare("DELETE FROM servicios WHERE `id` = :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    // Mensaje de éxito y redirección
    $mensaje = "Servicio eliminado con éxito";
    header("Location: index.php?mensaje=" . urlencode($mensaje));
    exit();
}

// Obtener servicios
$sentencia = $conexion->prepare("SELECT * FROM `servicios`");
$sentencia->execute();
$lista_servicios = $sentencia->fetchAll(PDO::FETCH_ASSOC);

include("../../templates/header.php");
?>

<div class="card">
    <div class="card-header">
        <a class="btn btn-primary" href="crear.php" role="button">Agregar registro</a>
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
                    <?php foreach ($lista_servicios as $registros) { ?>
                        <tr>
                            <td><?php echo $registros['id']; ?></td>
                            <td><img src="../../../assets/img/servicios/<?php echo $registros['icono']; ?>" width="90" height="90"></td>
                            <td><?php echo htmlspecialchars($registros['titulo']); ?></td>
                            <td><?php echo htmlspecialchars($registros['descripcion']); ?></td>
                            <td>
                                <a class="btn btn-info" href="editar.php?txtID=<?php echo $registros['id']; ?>" role="button">Editar</a> |
                                <a class="btn btn-danger" href="javascript:confirmDelete(<?php echo $registros['id']; ?>)" role="button">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    // Función de confirmación de eliminación
    function confirmDelete(id) {
        if (confirm("¿Estás seguro de que deseas eliminar este servicio?")) {
            window.location.href = "index.php?txtID=" + id;
        }
    }
</script>

<?php 
include("../../templates/footer.php");
?>
