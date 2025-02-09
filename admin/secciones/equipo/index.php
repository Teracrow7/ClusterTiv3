<?php 
include("../../bd.php");

if (isset($_GET['txtID'])) {
    // Validate and sanitize txtID
    $txtID = filter_var($_GET['txtID'], FILTER_VALIDATE_INT);
    if (!$txtID) {
        die("Invalid ID.");
    }

    // Fetch and delete the associated image file
    $sentencia = $conexion->prepare("SELECT imagen FROM equipo WHERE `id` = :id");
    $sentencia->bindParam(":id", $txtID, PDO::PARAM_INT);
    $sentencia->execute();
    $registro_imagen = $sentencia->fetch(PDO::FETCH_LAZY);

    if ($registro_imagen && isset($registro_imagen['imagen'])) {
        $imagePath = "../../../assets/img/team/" . $registro_imagen['imagen'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // Delete the record from the database
    $sentencia = $conexion->prepare("DELETE FROM equipo WHERE `id` = :id");
    $sentencia->bindParam(":id", $txtID, PDO::PARAM_INT);
    $sentencia->execute();

    // Redirect after deletion
    header("Location: index.php?mensaje=" . urlencode("Registro eliminado con éxito"));
    exit();
}

// Fetch all records from the `equipo` table
$sentencia = $conexion->prepare("SELECT * FROM `equipo`");
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
                        <th scope="col">Imagen</th>
                        <th scope="col">Nombre Completo</th>
                        <th scope="col">Puesto</th>
                        <th scope="col">Twitter</th>
                        <th scope="col">Facebook</th>
                        <th scope="col">LinkedIn</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_entradas as $registros): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($registros['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <img src="../../../assets/img/team/<?php echo htmlspecialchars($registros['imagen'], ENT_QUOTES, 'UTF-8'); ?>" width="50" height="50" alt="Imagen">
                            </td>
                            <td><?php echo htmlspecialchars($registros['nombrecompleto'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($registros['puesto'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($registros['twitter'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($registros['facebook'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($registros['linkedin'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <a class="btn btn-info" href="editar.php?txtID=<?php echo htmlspecialchars($registros['id'], ENT_QUOTES, 'UTF-8'); ?>" role="button">Editar</a>
                                |
                                <a class="btn btn-danger" href="index.php?txtID=<?php echo htmlspecialchars($registros['id'], ENT_QUOTES, 'UTF-8'); ?>" role="button" onclick="return confirm('¿Está seguro de que desea eliminar este registro?')">Eliminar</a>
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
