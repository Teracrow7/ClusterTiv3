<?php 
include("../../bd.php");

if (isset($_GET['txtID'])) {
    // Seleccionar registro a editar 
    $txtID = isset($_GET['txtID']) ? intval($_GET['txtID']) : 0;

    $sentencia = $conexion->prepare("SELECT * FROM `entradas` WHERE id = :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);

    $fecha = htmlspecialchars($registro['fecha'], ENT_QUOTES, 'UTF-8');
    $titulo = htmlspecialchars($registro['titulo'], ENT_QUOTES, 'UTF-8');
    $descripcion = htmlspecialchars($registro['descripcion'], ENT_QUOTES, 'UTF-8');
    $imagen = htmlspecialchars($registro['imagen'], ENT_QUOTES, 'UTF-8');
}

if ($_POST) {
    $txtID = isset($_POST['txtID']) ? intval($_POST['txtID']) : 0;
    $fecha = isset($_POST['fecha']) ? htmlspecialchars($_POST['fecha'], ENT_QUOTES, 'UTF-8') : "";
    $titulo = isset($_POST['titulo']) ? htmlspecialchars($_POST['titulo'], ENT_QUOTES, 'UTF-8') : "";
    $descripcion = isset($_POST['descripcion']) ? htmlspecialchars($_POST['descripcion'], ENT_QUOTES, 'UTF-8') : "";

    // Update the database
    $sentencia = $conexion->prepare("UPDATE `entradas` SET `fecha` = :fecha, `titulo` = :titulo, `descripcion` = :descripcion WHERE `id` = :id");
    $sentencia->bindParam(":fecha", $fecha);
    $sentencia->bindParam(":titulo", $titulo);
    $sentencia->bindParam(":descripcion", $descripcion);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    // Handle image upload
    if ($_FILES['imagen']['tmp_name'] != "") {
        $imagen = isset($_FILES['imagen']['name']) ? $_FILES['imagen']['name'] : "";
        $fecha_imagen = new DateTime();
        $nombre_archivo_img = $fecha_imagen->getTimestamp() . "_" . preg_replace("/[^a-zA-Z0-9.\-_]/", "", $imagen);
        $tmp_imagen = $_FILES['imagen']['tmp_name'];

        // Validate file type
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array(mime_content_type($tmp_imagen), $allowed_types)) {
            $mensaje = "Formato de imagen no válido. Solo se permiten JPEG, PNG y GIF.";
            header("Location: index.php?mensaje=" . urlencode($mensaje));
            exit;
        }

        // Validate file size (max 2MB)
        if ($_FILES['imagen']['size'] > 2097152) {
            $mensaje = "El archivo de imagen no debe exceder los 2MB.";
            header("Location: index.php?mensaje=" . urlencode($mensaje));
            exit;
        }

        // Move the uploaded file
        $upload_path = "../../../assets/img/entradas/";
        if (!move_uploaded_file($tmp_imagen, $upload_path . $nombre_archivo_img)) {
            $mensaje = "Error al subir el archivo.";
            header("Location: index.php?mensaje=" . urlencode($mensaje));
            exit;
        }

        // Delete the old image
        $sentencia = $conexion->prepare("SELECT imagen FROM entradas WHERE `id` = :id");
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
        $registro_imagen = $sentencia->fetch(PDO::FETCH_LAZY);
        if (isset($registro_imagen['imagen']) && file_exists($upload_path . $registro_imagen['imagen'])) {
            unlink($upload_path . $registro_imagen['imagen']);
        }

        // Update the new image in the database
        $sentencia = $conexion->prepare("UPDATE `entradas` SET `imagen` = :imagen WHERE `id` = :id");
        $sentencia->bindParam(":imagen", $nombre_archivo_img);
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
    }

    $mensaje = "Registro modificado con éxito";
    header("Location: index.php?mensaje=" . urlencode($mensaje));
    exit;
}

include("../../templates/header.php");
?>

<div class="card">
    <div class="card-header">Editar Entrada</div>
    <div class="card-body">
        <form action="" enctype="multipart/form-data" method="post">
            <div class="mb-3">
                <label for="txtID" class="form-label">ID:</label>
                <input
                    value="<?php echo $txtID; ?>"
                    type="text"
                    class="form-control"
                    name="txtID"
                    id="txtID"
                    readonly
                />
            </div>

            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha:</label>
                <input value="<?php echo $fecha; ?>"
                    type="date"
                    class="form-control"
                    name="fecha"
                    id="fecha"
                    required
                />
            </div>

            <div class="mb-3">
                <label for="titulo" class="form-label">Título:</label>
                <input value="<?php echo $titulo; ?>"
                    type="text"
                    class="form-control"
                    name="titulo"
                    id="titulo"
                    required
                />
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea
                    class="form-control"
                    name="descripcion"
                    id="descripcion"
                    rows="3"
                    required
                ><?php echo $descripcion; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen:</label>
                <img src="../../../assets/img/entradas/<?php echo $imagen; ?>" width="90" height="90">
                <input
                    type="file"
                    class="form-control"
                    name="imagen"
                    id="imagen"
                    accept="image/*"
                />
            </div>

            <button type="submit" class="btn btn-success">Actualizar</button>
            <a href="index.php" class="btn btn-primary" role="button">Cancelar</a>
        </form>
    </div>
</div>

<?php 
include("../../templates/footer.php");
?>
