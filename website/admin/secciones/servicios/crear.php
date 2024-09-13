<?php 
include("../../bd.php");

if ($_POST) {
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : "";
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : "";

    // Manejar la carga del archivo de imagen
    if (isset($_FILES['icono']['name']) && $_FILES['icono']['name'] != "") {
        $fecha_imagen = new DateTime();
        $nombre_archivo_img = $fecha_imagen->getTimestamp() . "_" . $_FILES['icono']['name']; // Renombrar el archivo con un timestamp
        $temp_file = $_FILES['icono']['tmp_name'];
        $directorio_destino = "../../../assets/img/servicios/" . $nombre_archivo_img;

        // Mover el archivo al directorio de destino
        if (move_uploaded_file($temp_file, $directorio_destino)) {
            $icono = $nombre_archivo_img; // Guardar el nombre del archivo en la base de datos
        } else {
            $mensaje = "Error al subir la imagen.";
            header("Location: index.php?mensaje=" . $mensaje);
            exit();
        }
    } else {
        $icono = ""; // No se subió una imagen
    }

    // Preparar y ejecutar la consulta SQL para insertar el nuevo registro
    $sentencia = $conexion->prepare("INSERT INTO `servicios` (`id`, `icono`, `titulo`, `descripcion`) 
    VALUES (NULL, :icono, :titulo, :descripcion)");

    $sentencia->bindParam(":icono", $icono);
    $sentencia->bindParam(":titulo", $titulo);
    $sentencia->bindParam(":descripcion", $descripcion);
    $sentencia->execute();

    $mensaje = "Registro creado con éxito";
    header("Location: index.php?mensaje=" . $mensaje);
}

include("../../templates/header.php");
?>

<div class="card">
    <div class="card-header">Crear Servicio</div>
    <div class="card-body">
        <form action="" enctype="multipart/form-data" method="post">
            <div class="mb-3">
                <label for="icono" class="form-label">Imagen:</label>
                <input
                    type="file"
                    class="form-control"
                    name="icono"
                    id="icono"
                    aria-describedby="helpId"
                    placeholder="Imagen"
                    accept="image/*"
                />
            </div>
            <div class="mb-3">
                <label for="titulo" class="form-label">Título:</label>
                <input
                    type="text"
                    class="form-control"
                    name="titulo"
                    id="titulo"
                    aria-describedby="helpId"
                    placeholder="Título"
                />
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <input
                    type="text"
                    class="form-control"
                    name="descripcion"
                    id="descripcion"
                    aria-describedby="helpId"
                    placeholder="Descripción"
                />
            </div>
            <button type="submit" class="btn btn-success">Agregar</button>
            <a class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
    <div class="card-footer text-muted">
    </div>
</div>



<?php 
include("../../templates/footer.php")
?>