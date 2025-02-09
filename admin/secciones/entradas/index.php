<?php 
include("../../bd.php");

if (isset($_GET['txtID'])) {
    // Eliminar registro
    $txtID = isset($_GET['txtID']) ? intval($_GET['txtID']) : 0;

    // Fetch and delete the associated image
    $sentencia = $conexion->prepare("SELECT imagen FROM entradas WHERE `id` = :id");
    $sentencia->bindParam(":id", $txtID, PDO::PARAM_INT);
    $sentencia->execute();
    $registro_imagen = $sentencia->fetch(PDO::FETCH_LAZY);

    if ($registro_imagen && isset($registro_imagen['imagen'])) {
        $imagePath = "../../../assets/img/entradas/" . basename($registro_imagen['imagen']);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // Delete the record from the database
    $sentencia = $conexion->prepare("DELETE FROM entradas WHERE `id` = :id");
    $sentencia->bindParam(":id", $txtID, PDO::PARAM_INT);
    $sentencia->execute();
}

// Fetch all entries
$sentencia = $conexion->prepare("SELECT * FROM `entradas`");
$sentencia->execute();
$lista_entradas = $sentencia->fetchAll(PDO::FETCH_ASSOC);

include("../../templates/header.php");
?>

<div class="card">
    <div class="card-header">
        <a class="btn btn-primary" href="crear.php" role="button">Agregar</a>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table table-primary">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Título</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_entradas as $registros): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($registros['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($registros['fecha'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($registros['titulo'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($registros['descripcion'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <?php if (!empty($registros['imagen']) && file_exists("../../../assets/img/entradas/" . htmlspecialchars($registros['imagen'], ENT_QUOTES, 'UTF-8'))): ?>
                                    <img src="../../../assets/img/entradas/<?php echo htmlspecialchars($registros['imagen'], ENT_QUOTES, 'UTF-8'); ?>" width="90" height="90" alt="Imagen">
                                <?php else: ?>
                                    <span>No disponible</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a class="btn btn-info" href="editar.php?txtID=<?php echo htmlspecialchars($registros['id'], ENT_QUOTES, 'UTF-8'); ?>" role="button">Editar</a>
                                |
                                <a class="btn btn-danger" href="index.php?txtID=<?php echo htmlspecialchars($registros['id'], ENT_QUOTES, 'UTF-8'); ?>" role="button" onclick="return confirm('¿Estás seguro de eliminar este registro?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer text-muted"></div>
</div>

<?php 
include("../../templates/footer.php");
?>
