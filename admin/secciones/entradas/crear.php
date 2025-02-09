<?php 
include("../../bd.php");

if ($_POST) {
    $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : "";
    $titulo = isset($_POST['titulo']) ? htmlspecialchars($_POST['titulo'], ENT_QUOTES, 'UTF-8') : "";
    $descripcion = isset($_POST['descripcion']) ? htmlspecialchars($_POST['descripcion'], ENT_QUOTES, 'UTF-8') : "";
    $imagen = isset($_FILES['imagen']['name']) ? $_FILES['imagen']['name'] : "";

    // Validate inputs
    if (empty($fecha) || empty($titulo) || empty($descripcion)) {
        $mensaje = "Todos los campos son obligatorios.";
        header("Location: index.php?mensaje=" . urlencode($mensaje));
        exit;
    }

    // File upload handling
    $nombre_archivo_img = "";
    if ($imagen) {
        $fecha_imagen = new DateTime();
        $nombre_archivo_img = $fecha_imagen->getTimestamp() . "_" . preg_replace("/[^a-zA-Z0-9.\-_]/", "", $imagen); // Sanitize file name
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

        // Move uploaded file
        $upload_path = "../../../assets/img/entradas/";
        if (!move_uploaded_file($tmp_imagen, $upload_path . $nombre_archivo_img)) {
            $mensaje = "Error al subir el archivo.";
            header("Location: index.php?mensaje=" . urlencode($mensaje));
            exit;
        }
    }

    // Insert data into the database
    try {
        $sentencia = $conexion->prepare("INSERT INTO `entradas` (`id`, `fecha`, `titulo`, `descripcion`, `imagen`) 
            VALUES (NULL, :fecha, :titulo, :descripcion, :imagen);");

        $sentencia->bindParam(":fecha", $fecha);
        $sentencia->bindParam(":titulo", $titulo);
        $sentencia->bindParam(":descripcion", $descripcion);
        $sentencia->bindParam(":imagen", $nombre_archivo_img);

        if ($sentencia->execute()) {
            $mensaje = "Registro creado con éxito.";
            header("Location: index.php?mensaje=" . urlencode($mensaje));
            exit;
        } else {
            $mensaje = "Error al guardar el registro.";
            header("Location: index.php?mensaje=" . urlencode($mensaje));
            exit;
        }
    } catch (Exception $e) {
        error_log("Error al insertar entrada: " . $e->getMessage());
        $mensaje = "Ocurrió un error al procesar la solicitud.";
        header("Location: index.php?mensaje=" . urlencode($mensaje));
        exit;
    }
}

include("../../templates/header.php");
?>

<div class="card">
    <div class="card-header">Crear Entrada</div>
    <div class="card-body">
        <form action="" enctype="multipart/form-data" method="post">
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha:</label>
                <input
                    type="date"
                    class="form-control"
                    name="fecha"
                    id="fecha"
                    required
                />
            </div>

            <div class="mb-3">
                <label for="titulo" class="form-label">Título:</label>
                <input
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
                ></textarea>
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen</label>
                <input
                    type="file"
                    class="form-control"
                    name="imagen"
                    id="imagen"
                    accept="image/*"
                />
            </div>

            <button type="submit" class="btn btn-success">Agregar</button>
            <a href="index.php" class="btn btn-primary" role="button">Cancelar</a>
        </form>
    </div>
</div>

<?php 
include("../../templates/footer.php");
?>
