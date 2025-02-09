<?php 
include("../../bd.php");

$mensaje = "";

// Validate and sanitize the `txtID` parameter for deletion
if (isset($_GET['txtID'])) {
    $txtID = filter_var($_GET['txtID'], FILTER_SANITIZE_NUMBER_INT);

    if ($txtID && is_numeric($txtID)) {
        try {
            $sentencia = $conexion->prepare("DELETE FROM `configuraciones` WHERE `id` = :id");
            $sentencia->bindParam(":id", $txtID, PDO::PARAM_INT);
            if ($sentencia->execute()) {
                $mensaje = "Registro eliminado con éxito.";
            } else {
                $mensaje = "Error al eliminar el registro.";
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            $mensaje = "Ocurrió un error al eliminar el registro.";
        }
    } else {
        $mensaje = "ID inválido.";
    }
}

// Fetch all configurations
$sentencia = $conexion->prepare("SELECT * FROM `configuraciones`");
$sentencia->execute();
$lista_config = $sentencia->fetchAll(PDO::FETCH_ASSOC);

include("../../templates/header.php");
?>

<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar</a>
    </div>
    <div class="card-body">
        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($mensaje); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="table-responsive-sm">
            <table class="table table-primary">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre configuración</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_config as $registros): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($registros['id']); ?></td>
                            <td><?php echo htmlspecialchars($registros['nombreconfig']); ?></td>
                            <td><?php echo htmlspecialchars($registros['valor']); ?></td>
                            <td>
                                <a class="btn btn-info" href="editar.php?txtID=<?php echo urlencode($registros['id']); ?>" role="button">Editar</a>
                                |
                                <a class="btn btn-danger" href="#" role="button" onclick="confirmDeletion(<?php echo $registros['id']; ?>)">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function confirmDeletion(id) {
        if (confirm("¿Estás seguro de que deseas eliminar este registro?")) {
            window.location.href = "index.php?txtID=" + encodeURIComponent(id);
        }
    }
</script>

<?php 
include("../../templates/footer.php");
?>
