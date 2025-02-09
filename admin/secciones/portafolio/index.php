<?php 
include("../../bd.php");

if (isset($_GET['txtID']) && filter_var($_GET['txtID'], FILTER_VALIDATE_INT)) {
    // Obtener el ID de forma segura
    $txtID = $_GET['txtID'];

    // Preparar la consulta para obtener la imagen asociada al ID
    $sentencia = $conexion->prepare("SELECT imagen FROM portafolio WHERE `id` = :id");
    $sentencia->bindParam(":id", $txtID, PDO::PARAM_INT);
    $sentencia->execute();
    $registro_imagen = $sentencia->fetch(PDO::FETCH_LAZY);

    if (isset($registro_imagen['imagen'])) {
        // Validar que el archivo existe y está dentro del directorio de imágenes
        $imagen_path = "../../../assets/img/portfolio/" . $registro_imagen['imagen'];
        if (file_exists($imagen_path) && is_file($imagen_path)) {
            unlink($imagen_path); // Eliminar el archivo de imagen
        }
    }

    // Eliminar el registro del portafolio
    $sentencia = $conexion->prepare("DELETE FROM portafolio WHERE `id` = :id");
    $sentencia->bindParam(":id", $txtID, PDO::PARAM_INT);
    $sentencia->execute();

    // Redirigir al usuario para evitar múltiples eliminaciones por reenvío del formulario
    header("Location: index.php?mensaje=Registro eliminado con éxito");
    exit();
}

// Obtener todos los registros de portafolio
$sentencia = $conexion->prepare("SELECT * FROM `portafolio`");
$sentencia->execute();
$lista_portafolio = $sentencia->fetchAll(PDO::FETCH_ASSOC);

include("../../templates/header.php")
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
                        <th scope="col">Titulo</th>
                        <th scope="col">Subtitulo</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Url</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($lista_portafolio as $registros) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($registros['id']); ?></td>
                        <td><?php echo htmlspecialchars($registros['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($registros['subtitulo']); ?></td>
                        <td><img src="../../../assets/img/portfolio/<?php echo htmlspecialchars($registros['imagen']); ?>" width="90" height="90"></td>
                        <td><?php echo htmlspecialchars($registros['descripcion']); ?></td>
                        <td><?php echo htmlspecialchars($registros['cliente']); ?></td>
                        <td><?php echo htmlspecialchars($registros['categoria']); ?></td>
                        <td><?php echo htmlspecialchars($registros['url']); ?></td>
                        <td>
                            <a class="btn btn-info" href="editar.php?txtID=<?php echo htmlspecialchars($registros['id']); ?>" role="button">Editar</a> |
                            <a class="btn btn-danger" href="index.php?txtID=<?php echo htmlspecialchars($registros['id']); ?>" role="button">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer text-muted"></div>
</div>

<?php include("../../templates/footer.php") ?>
