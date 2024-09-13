<?php 
include("../../bd.php");

if (isset($_GET['txtID'])) {
    // Seleccionar registro a editar 
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";

    $sentencia = $conexion->prepare("SELECT * FROM `servicios` WHERE id = :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    $icono = $registro['icono'];
    $titulo = $registro['titulo'];
    $descripcion = $registro['descripcion'];
}

if ($_POST) {
    $txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
    $titulo = (isset($_POST['titulo'])) ? $_POST['titulo'] : "";
    $descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : "";

    // Manejar la carga de una nueva imagen
    if (isset($_FILES['icono']['name']) && $_FILES['icono']['name'] != "") {
        $nombreArchivo = time() . "_" . $_FILES['icono']['name']; // Renombrar el archivo con un timestamp
        $tempFile = $_FILES['icono']['tmp_name'];

        // Mover el archivo al directorio de destino
        move_uploaded_file($tempFile, "../../../assets/img/servicios/" . $nombreArchivo);

        $icono = $nombreArchivo; // Guardar la nueva ruta de la imagen

        // Actualizar el registro con la nueva imagen
        $sentencia = $conexion->prepare("UPDATE `servicios` SET `icono` = :icono, `titulo` = :titulo, `descripcion` = :descripcion WHERE `id` = :id");
        $sentencia->bindParam(":icono", $icono);
    } else {
        // Actualizar el registro sin cambiar la imagen
        $sentencia = $conexion->prepare("UPDATE `servicios` SET `titulo` = :titulo, `descripcion` = :descripcion WHERE `id` = :id");
    }

    $sentencia->bindParam(":titulo", $titulo);
    $sentencia->bindParam(":descripcion", $descripcion);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $mensaje = "Registro modificado con éxito";
    header("Location: index.php?mensaje=" . $mensaje);
}

include("../../templates/header.php");
?>


<div class="card">
    <div class="card-header">Editar servicios</div>
    <div class="card-body">
    <form action="editar.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="txtID" value="<?php echo $txtID; ?>">
    <div class="mb-3">
        <label for="icono" class="form-label">Imagen:</label>
        <input type="file" class="form-control" name="icono" id="icono">
    </div>


    
    <div class="mb-3">
        <label for="titulo" class="form-label">Título:</label>
        <input value="<?php echo $titulo; ?>" type="text" class="form-control" name="titulo" id="titulo">
    </div>
    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción:</label>
        <input value="<?php echo $descripcion; ?>" type="text" class="form-control" name="descripcion" id="descripcion">
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
