<?php 
include("../../bd.php");

// Validar y sanear el ID
if (isset($_GET['txtID']) && filter_var($_GET['txtID'], FILTER_VALIDATE_INT)) {
    $txtID = $_GET['txtID'];

    $sentencia = $conexion->prepare("SELECT * FROM `portafolio` WHERE id = :id");
    $sentencia->bindParam(":id", $txtID, PDO::PARAM_INT);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);

    if ($registro) {
        $titulo = htmlspecialchars($registro['titulo']);
        $subtitulo = htmlspecialchars($registro['subtitulo']);
        $imagen = $registro['imagen'];
        $descripcion = htmlspecialchars($registro['descripcion']);
        $cliente = htmlspecialchars($registro['cliente']);
        $categoria = htmlspecialchars($registro['categoria']);
        $url = htmlspecialchars($registro['url']);
    } else {
        die('Registro no encontrado.');
    }
} else {
    die('ID no válido.');
}

// Procesar el formulario de actualización
if ($_POST) {
    $txtID = (isset($_POST['txtID']) && filter_var($_POST['txtID'], FILTER_VALIDATE_INT)) ? $_POST['txtID'] : "";
    $titulo = (isset($_POST['titulo'])) ? htmlspecialchars($_POST['titulo']) : "";
    $subtitulo = (isset($_POST['subtitulo'])) ? htmlspecialchars($_POST['subtitulo']) : "";
    $descripcion = (isset($_POST['descripcion'])) ? htmlspecialchars($_POST['descripcion']) : "";
    $cliente = (isset($_POST['cliente'])) ? htmlspecialchars($_POST['cliente']) : "";
    $categoria = (isset($_POST['categoria'])) ? htmlspecialchars($_POST['categoria']) : "";
    $url = (isset($_POST['url'])) ? filter_var($_POST['url'], FILTER_SANITIZE_URL) : "";

    $sentencia = $conexion->prepare("UPDATE `portafolio` SET `titulo`=:titulo, `subtitulo`=:subtitulo,
    `descripcion`=:descripcion, cliente=:cliente, categoria=:categoria, url=:url WHERE `id` = :id");
    
    $sentencia->bindParam(":titulo", $titulo, PDO::PARAM_STR);
    $sentencia->bindParam(":subtitulo", $subtitulo, PDO::PARAM_STR);
    $sentencia->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
    $sentencia->bindParam(":cliente", $cliente, PDO::PARAM_STR);
    $sentencia->bindParam(":categoria", $categoria, PDO::PARAM_STR);
    $sentencia->bindParam(":url", $url, PDO::PARAM_STR);
    $sentencia->bindParam(":id", $txtID, PDO::PARAM_INT);
    $sentencia->execute();

    // Verificar la subida de imagen
    if ($_FILES['imagen']['tmp_name'] != "") {
        $imagen = $_FILES['imagen']['name'];
        $fecha_imagen = new DateTime();
        $nombre_archivo_img = $fecha_imagen->getTimestamp() . "_" . basename($imagen);
        $tmp_imagen = $_FILES['imagen']['tmp_name'];

        // Validar el tipo de archivo
        $valid_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = mime_content_type($tmp_imagen);

        if (!in_array($file_type, $valid_types)) {
            die("El tipo de archivo no es válido. Debe ser una imagen.");
        }

        // Validar el tamaño del archivo (por ejemplo, máximo 5 MB)
        $max_size = 5 * 1024 * 1024; // 5 MB
        if ($_FILES['imagen']['size'] > $max_size) {
            die("El archivo excede el tamaño máximo permitido (5 MB).");
        }

        // Subir la imagen
        move_uploaded_file($tmp_imagen, "../../../assets/img/portfolio/" . $nombre_archivo_img);

        // Eliminar la imagen anterior si existe
        $sentencia = $conexion->prepare("SELECT imagen FROM portafolio WHERE `id` = :id");
        $sentencia->bindParam(":id", $txtID, PDO::PARAM_INT);
        $sentencia->execute();
        $registro_imagen = $sentencia->fetch(PDO::FETCH_LAZY);

        if (isset($registro_imagen['imagen']) && file_exists("../../../assets/img/portfolio/" . $registro_imagen['imagen'])) {
            unlink("../../../assets/img/portfolio/" . $registro_imagen['imagen']);
        }

        // Actualizar la imagen en la base de datos
        $sentencia = $conexion->prepare("UPDATE `portafolio` SET `imagen`=:imagen WHERE `id` = :id");
        $sentencia->bindParam(":imagen", $nombre_archivo_img, PDO::PARAM_STR);
        $sentencia->bindParam(":id", $txtID, PDO::PARAM_INT);
        $sentencia->execute();
    }

    $mensaje = "Registro modificado con éxito";
    header("Location: index.php?mensaje=" . urlencode($mensaje));
}
include("../../templates/header.php")
?>
<div class="card">
    <div class="card-header">Editar Producto</div>
    <div class="card-body">
        <form action="" enctype="multipart/form-data" method="post">
            <div class="mb-3">
                <label for="txtID" class="form-label">ID:</label>
                <input value="<?php echo htmlspecialchars($txtID); ?>" type="text" class="form-control" name="txtID" id="txtID" readonly />
            </div>
            <div class="mb-3">
                <label for="titulo" class="form-label">Título:</label>
                <input value="<?php echo htmlspecialchars($titulo); ?>" type="text" class="form-control" name="titulo" id="titulo" />
            </div>
            <div class="mb-3">
                <label for="subtitulo" class="form-label">Subtitulo:</label>
                <input value="<?php echo htmlspecialchars($subtitulo); ?>" type="text" class="form-control" name="subtitulo" id="subtitulo" />
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen:</label>
                <img src="../../../assets/img/portfolio/<?php echo htmlspecialchars($imagen); ?>" width="90" height="90">
                <input type="file" class="form-control" name="imagen" id="imagen" />
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <input value="<?php echo htmlspecialchars($descripcion); ?>" type="text" class="form-control" name="descripcion" id="descripcion" />
            </div>
            <div class="mb-3">
                <label for="cliente" class="form-label">Cliente:</label>
                <input value="<?php echo htmlspecialchars($cliente); ?>" type="text" class="form-control" name="cliente" id="cliente" />
            </div>
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoria:</label>
                <input value="<?php echo htmlspecialchars($categoria); ?>" type="text" class="form-control" name="categoria" id="categoria" />
            </div>
            <div class="mb-3">
                <label for="url" class="form-label">Url:</label>
                <input value="<?php echo htmlspecialchars($url); ?>" type="text" class="form-control" name="url" id="url" />
            </div>
            <button type="submit" class="btn btn-success">Actualizar</button>
            <a class="btn btn-primary" href="index.php">Cancelar</a>
        </form>
    </div>
</div>

<?php 
include("../../templates/footer.php")
?>
