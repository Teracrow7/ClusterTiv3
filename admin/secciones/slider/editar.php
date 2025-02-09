<?php 
include("../../bd.php");

if (isset($_GET['txtID'])) {
    // Seleccionar registro a editar 
    $txtID = filter_input(INPUT_GET, 'txtID', FILTER_VALIDATE_INT);
    
    if ($txtID) {
        $sentencia = $conexion->prepare("SELECT * FROM `slider` WHERE id = :id");
        $sentencia->bindParam(":id", $txtID, PDO::PARAM_INT);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_LAZY);

        if ($registro) {
            $imagen = $registro['imagen'];
            $titulo = $registro['titulo'];
            $descripcion = $registro['descripcion'];
        } else {
            // En caso de no encontrar el registro
            header("Location: index.php?mensaje=Registro no encontrado");
            exit();
        }
    } else {
        // En caso de un ID no válido
        header("Location: index.php?mensaje=ID no válido");
        exit();
    }
}

if ($_POST) {
    // Validación de campos
    $txtID = filter_input(INPUT_POST, 'txtID', FILTER_VALIDATE_INT);
    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
    $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);

    if ($txtID && $titulo && $descripcion) {
        // Manejar la carga de una nueva imagen
        if (isset($_FILES['imagen']['name']) && $_FILES['imagen']['name'] != "") {
            // Verificar el tipo de archivo
            $archivoImagen = $_FILES['imagen'];
            $ext = strtolower(pathinfo($archivoImagen['name'], PATHINFO_EXTENSION));
            $tiposPermitidos = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($ext, $tiposPermitidos) && $archivoImagen['size'] < 5000000) { // 5MB
                $nombreArchivo = time() . "_" . basename($archivoImagen['name']);
                $tempFile = $archivoImagen['tmp_name'];
                $directorioDestino = "../../../assets/img/slider/" . $nombreArchivo;

                // Mover el archivo al directorio de destino
                if (move_uploaded_file($tempFile, $directorioDestino)) {
                    $imagen = $nombreArchivo; // Guardar la nueva ruta de la imagen

                    // Actualizar el registro con la nueva imagen
                    $sentencia = $conexion->prepare("UPDATE `slider` SET `imagen` = :imagen, `titulo` = :titulo, `descripcion` = :descripcion WHERE `id` = :id");
                    $sentencia->bindParam(":imagen", $imagen);
                } else {
                    $mensaje = "Error al subir la imagen.";
                    header("Location: editar.php?txtID=" . $txtID . "&mensaje=" . $mensaje);
                    exit();
                }
            } else {
                $mensaje = "Tipo de imagen no permitido o tamaño demasiado grande.";
                header("Location: editar.php?txtID=" . $txtID . "&mensaje=" . $mensaje);
                exit();
            }
        } else {
            // Actualizar el registro sin cambiar la imagen
            $sentencia = $conexion->prepare("UPDATE `slider` SET `titulo` = :titulo, `descripcion` = :descripcion WHERE `id` = :id");
        }

        // Ejecutar la consulta de actualización
        $sentencia->bindParam(":titulo", $titulo, PDO::PARAM_STR);
        $sentencia->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
        $sentencia->bindParam(":id", $txtID, PDO::PARAM_INT);
        $sentencia->execute();

        $mensaje = "Registro modificado con éxito";
        header("Location: index.php?mensaje=" . $mensaje);
    } else {
        $mensaje = "Datos no válidos. Asegúrese de completar todos los campos.";
        header("Location: editar.php?txtID=" . $txtID . "&mensaje=" . $mensaje);
        exit();
    }
}

include("../../templates/header.php");
?>

<div class="card">
    <div class="card-header">Editar servicios</div>
    <div class="card-body">
        <form action="editar.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="txtID" value="<?php echo htmlspecialchars($txtID); ?>">

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen:</label>
                <input type="file" class="form-control" name="imagen" id="imagen" accept="image/*">
            </div>

            <div class="mb-3">
                <label for="titulo" class="form-label">Título:</label>
                <input value="<?php echo htmlspecialchars($titulo); ?>" type="text" class="form-control" name="titulo" id="titulo">
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <input value="<?php echo htmlspecialchars($descripcion); ?>" type="text" class="form-control" name="descripcion" id="descripcion">
            </div>

            <button type="submit" class="btn btn-success">Actualizar</button>
            <a class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
    <div class="card-footer text-muted"></div>
</div>

<?php 
include("../../templates/footer.php");
?>
