<?php 
include("../../bd.php");

if ($_POST) {
    // Obtener los datos del formulario
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : "";
    $subtitulo = isset($_POST['subtitulo']) ? $_POST['subtitulo'] : "";
    $imagen = isset($_FILES['imagen']['name']) ? $_FILES['imagen']['name'] : "";
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : "";
    $cliente = isset($_POST['cliente']) ? $_POST['cliente'] : "";
    $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : "";
    $url = isset($_POST['url']) ? $_POST['url'] : "";

    // Validación de la imagen
    if ($imagen != "") {
        $fecha_imagen = new DateTime();
        $nombre_archivo_img = $fecha_imagen->getTimestamp() . "_" . $imagen;
        $tmp_imagen = $_FILES['imagen']['tmp_name'];
        
        // Verificar si la imagen es válida
        $valid_formats = array("jpg", "jpeg", "png", "gif");
        $file_extension = strtolower(pathinfo($imagen, PATHINFO_EXTENSION));

        if (in_array($file_extension, $valid_formats)) {
            move_uploaded_file($tmp_imagen, "../../../assets/img/portfolio/" . $nombre_archivo_img);
        } else {
            // Redirigir con mensaje de error si la imagen no es válida
            $mensaje = "Solo se permiten imágenes con formato JPG, JPEG, PNG o GIF.";
            header("Location: index.php?mensaje=" . urlencode($mensaje));
            exit();
        }
    } else {
        $nombre_archivo_img = "";
    }

    // Insertar el registro en la base de datos
    $sentencia = $conexion->prepare("INSERT INTO `portafolio` (`id`, `titulo`, `subtitulo`, `imagen`, `descripcion`, `cliente`, `categoria`, `url`) 
    VALUES (NULL, :titulo, :subtitulo, :imagen, :descripcion, :cliente, :categoria, :url);");

    $sentencia->bindParam(":titulo", $titulo);
    $sentencia->bindParam(":subtitulo", $subtitulo);
    $sentencia->bindParam(":imagen", $nombre_archivo_img);
    $sentencia->bindParam(":descripcion", $descripcion);
    $sentencia->bindParam(":cliente", $cliente);
    $sentencia->bindParam(":categoria", $categoria);
    $sentencia->bindParam(":url", $url);
    $sentencia->execute();

    // Mensaje de éxito y redirección
    $mensaje = "Registro creado con éxito";
    header("Location: index.php?mensaje=" . urlencode($mensaje));
    exit();
}

include("../../templates/header.php");
?>

<div class="card">
    <div class="card-header">Crear Producto</div>
    <div class="card-body">
        <form action="" enctype="multipart/form-data" method="post">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título:</label>
                <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Título" required />
            </div>
            <div class="mb-3">
                <label for="subtitulo" class="form-label">Subtitulo:</label>
                <input type="text" class="form-control" name="subtitulo" id="subtitulo" placeholder="Subtitulo" required />
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen</label>
                <input type="file" class="form-control" name="imagen" id="imagen" placeholder="imagen" aria-describedby="fileHelpId" />
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Descripción" required />
            </div>
            <div class="mb-3">
                <label for="cliente" class="form-label">Cliente:</label>
                <input type="text" class="form-control" name="cliente" id="cliente" placeholder="Cliente" required />
            </div>
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoria:</label>
                <input type="text" class="form-control" name="categoria" id="categoria" placeholder="Categoría" required />
            </div>
            <div class="mb-3">
                <label for="url" class="form-label">Url:</label>
                <input type="text" class="form-control" name="url" id="url" placeholder="Url" required />
            </div>
            <button type="submit" class="btn btn-success">Agregar</button>
            <a class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
</div>

<?php 
include("../../templates/footer.php");
?>
