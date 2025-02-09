<?php 
include("../../bd.php");

if ($_POST) {
    $imagen = isset($_FILES['imagen']['name']) ? $_FILES['imagen']['name'] : "";
    $nombre = isset($_POST['nombrecompleto']) ? htmlspecialchars($_POST['nombrecompleto'], ENT_QUOTES, 'UTF-8') : "";
    $puesto = isset($_POST['puesto']) ? htmlspecialchars($_POST['puesto'], ENT_QUOTES, 'UTF-8') : "";
    $twitter = isset($_POST['twitter']) ? filter_var($_POST['twitter'], FILTER_SANITIZE_URL) : "";
    $facebook = isset($_POST['facebook']) ? filter_var($_POST['facebook'], FILTER_SANITIZE_URL) : "";
    $linkedin = isset($_POST['linkedin']) ? filter_var($_POST['linkedin'], FILTER_SANITIZE_URL) : "";

    $nombre_archivo_img = "";
    if (!empty($imagen)) {
        $fecha_imagen = new DateTime();
        $nombre_archivo_img = $fecha_imagen->getTimestamp() . "_" . basename($imagen);
        $tmp_imagen = $_FILES['imagen']['tmp_name'];

        // Validate file type (allowing only images)
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = mime_content_type($tmp_imagen);

        if (in_array($file_type, $allowed_types)) {
            // Move the uploaded file
            if (!move_uploaded_file($tmp_imagen, "../../../assets/img/team/" . $nombre_archivo_img)) {
                die("Error: Could not upload the image.");
            }
        } else {
            die("Error: Invalid file type. Only JPEG, PNG, and GIF are allowed.");
        }
    }

    // Insert data into the database
    $sentencia = $conexion->prepare("INSERT INTO `equipo` (`id`, `imagen`, `nombrecompleto`, `puesto`, `twitter`, `facebook`, `linkedin`) 
    VALUES (NULL, :imagen, :nombrecompleto, :puesto, :twitter, :facebook, :linkedin);");

    $sentencia->bindParam(":imagen", $nombre_archivo_img);
    $sentencia->bindParam(":nombrecompleto", $nombre);
    $sentencia->bindParam(":puesto", $puesto);
    $sentencia->bindParam(":twitter", $twitter);
    $sentencia->bindParam(":facebook", $facebook);
    $sentencia->bindParam(":linkedin", $linkedin);

    if ($sentencia->execute()) {
        $mensaje = "Registro creado con éxito.";
        header("Location: index.php?mensaje=" . urlencode($mensaje));
        exit();
    } else {
        die("Error: No se pudo guardar el registro.");
    }
}

include("../../templates/header.php");
?>

<div class="card">
    <div class="card-header">Crear Miembro</div>
    <div class="card-body">
        <form action="" enctype="multipart/form-data" method="post">

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen</label>
                <input
                    type="file"
                    class="form-control"
                    name="imagen"
                    id="imagen"
                    aria-describedby="fileHelpId"
                />
            </div>

            <div class="mb-3">
                <label for="nombrecompleto" class="form-label">Nombre Completo:</label>
                <input
                    type="text"
                    class="form-control"
                    name="nombrecompleto"
                    id="nombrecompleto"
                    aria-describedby="helpId"
                    placeholder="Nombre Completo"
                    required
                />
            </div>

            <div class="mb-3">
                <label for="puesto" class="form-label">Puesto:</label>
                <input
                    type="text"
                    class="form-control"
                    name="puesto"
                    id="puesto"
                    aria-describedby="helpId"
                    placeholder="Puesto"
                    required
                />
            </div>

            <div class="mb-3">
                <label for="twitter" class="form-label">Twitter:</label>
                <input
                    type="url"
                    class="form-control"
                    name="twitter"
                    id="twitter"
                    aria-describedby="helpId"
                    placeholder="https://twitter.com/..."
                />
            </div>

            <div class="mb-3">
                <label for="facebook" class="form-label">Facebook:</label>
                <input
                    type="url"
                    class="form-control"
                    name="facebook"
                    id="facebook"
                    aria-describedby="helpId"
                    placeholder="https://facebook.com/..."
                />
            </div>

            <div class="mb-3">
                <label for="linkedin" class="form-label">LinkedIn:</label>
                <input
                    type="url"
                    class="form-control"
                    name="linkedin"
                    id="linkedin"
                    aria-describedby="helpId"
                    placeholder="https://linkedin.com/in/..."
                />
            </div>

            <button type="submit" class="btn btn-success">Agregar</button>
            <a href="index.php" class="btn btn-primary" role="button">Cancelar</a>
        </form>
    </div>
    <div class="card-footer text-muted"></div>
</div>

<?php 
include("../../templates/footer.php");
?>
