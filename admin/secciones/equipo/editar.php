<?php 
include("../../bd.php");

if (isset($_GET['txtID'])) {
    // Validate txtID
    $txtID = filter_var($_GET['txtID'], FILTER_VALIDATE_INT);
    if (!$txtID) {
        die("Invalid ID.");
    }

    // Select record to edit
    $sentencia = $conexion->prepare("SELECT * FROM `equipo` WHERE id = :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);

    if (!$registro) {
        die("Record not found.");
    }

    $imagen = htmlspecialchars($registro['imagen'], ENT_QUOTES, 'UTF-8');
    $nombre = htmlspecialchars($registro['nombrecompleto'], ENT_QUOTES, 'UTF-8');
    $puesto = htmlspecialchars($registro['puesto'], ENT_QUOTES, 'UTF-8');
    $twitter = htmlspecialchars($registro['twitter'], ENT_QUOTES, 'UTF-8');
    $facebook = htmlspecialchars($registro['facebook'], ENT_QUOTES, 'UTF-8');
    $linkedin = htmlspecialchars($registro['linkedin'], ENT_QUOTES, 'UTF-8');
}

if ($_POST) {
    $txtID = filter_var($_POST['txtID'], FILTER_VALIDATE_INT);
    $nombre = isset($_POST['nombrecompleto']) ? htmlspecialchars($_POST['nombrecompleto'], ENT_QUOTES, 'UTF-8') : "";
    $puesto = isset($_POST['puesto']) ? htmlspecialchars($_POST['puesto'], ENT_QUOTES, 'UTF-8') : "";
    $twitter = isset($_POST['twitter']) ? filter_var($_POST['twitter'], FILTER_SANITIZE_URL) : "";
    $facebook = isset($_POST['facebook']) ? filter_var($_POST['facebook'], FILTER_SANITIZE_URL) : "";
    $linkedin = isset($_POST['linkedin']) ? filter_var($_POST['linkedin'], FILTER_SANITIZE_URL) : "";

    if (!$txtID) {
        die("Invalid ID.");
    }

    // Update record
    $sentencia = $conexion->prepare("UPDATE `equipo` SET `nombrecompleto` = :nombrecompleto, `puesto` = :puesto, 
        `twitter` = :twitter, `facebook` = :facebook, `linkedin` = :linkedin WHERE `id` = :id");
    $sentencia->bindParam(":nombrecompleto", $nombre);
    $sentencia->bindParam(":puesto", $puesto);
    $sentencia->bindParam(":twitter", $twitter);
    $sentencia->bindParam(":facebook", $facebook);
    $sentencia->bindParam(":linkedin", $linkedin);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    if (!empty($_FILES['imagen']['tmp_name'])) {
        $imagen = $_FILES['imagen']['name'];
        $fecha_imagen = new DateTime();
        $nombre_archivo_img = $fecha_imagen->getTimestamp() . "_" . basename($imagen);
        $tmp_imagen = $_FILES['imagen']['tmp_name'];

        // Validate file type
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = mime_content_type($tmp_imagen);
        if (in_array($file_type, $allowed_types)) {
            // Move uploaded file
            if (move_uploaded_file($tmp_imagen, "../../../assets/img/team/" . $nombre_archivo_img)) {
                // Delete old image
                $sentencia = $conexion->prepare("SELECT imagen FROM `equipo` WHERE `id` = :id");
                $sentencia->bindParam(":id", $txtID);
                $sentencia->execute();
                $registro_imagen = $sentencia->fetch(PDO::FETCH_LAZY);

                if (isset($registro_imagen['imagen']) && file_exists("../../../assets/img/team/" . $registro_imagen['imagen'])) {
                    unlink("../../../assets/img/team/" . $registro_imagen['imagen']);
                }

                // Update new image
                $sentencia = $conexion->prepare("UPDATE `equipo` SET `imagen` = :imagen WHERE `id` = :id");
                $sentencia->bindParam(":imagen", $nombre_archivo_img);
                $sentencia->bindParam(":id", $txtID);
                $sentencia->execute();
            } else {
                die("Error uploading image.");
            }
        } else {
            die("Invalid file type. Only JPEG, PNG, and GIF are allowed.");
        }
    }

    $mensaje = "Registro modificado con éxito.";
    header("Location: index.php?mensaje=" . urlencode($mensaje));
    exit();
}

include("../../templates/header.php");
?>

<div class="card">
    <div class="card-header">Editar Miembro</div>
    <div class="card-body">
        <form action="" enctype="multipart/form-data" method="post">
            <div class="mb-3">
                <label for="txtID" class="form-label">ID:</label>
                <input value="<?php echo $txtID; ?>" type="text" class="form-control" name="txtID" id="txtID" readonly />
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen Actual:</label><br>
                <img src="../../../assets/img/team/<?php echo $imagen; ?>" width="90" height="90" alt="Imagen">
                <input type="file" class="form-control" name="imagen" id="imagen" />
            </div>

            <div class="mb-3">
                <label for="nombrecompleto" class="form-label">Nombre Completo:</label>
                <input value="<?php echo $nombre; ?>" type="text" class="form-control" name="nombrecompleto" id="nombrecompleto" required />
            </div>

            <div class="mb-3">
                <label for="puesto" class="form-label">Puesto:</label>
                <input value="<?php echo $puesto; ?>" type="text" class="form-control" name="puesto" id="puesto" required />
            </div>

            <div class="mb-3">
                <label for="twitter" class="form-label">Twitter:</label>
                <input value="<?php echo $twitter; ?>" type="url" class="form-control" name="twitter" id="twitter" />
            </div>

            <div class="mb-3">
                <label for="facebook" class="form-label">Facebook:</label>
                <input value="<?php echo $facebook; ?>" type="url" class="form-control" name="facebook" id="facebook" />
            </div>

            <div class="mb-3">
                <label for="linkedin" class="form-label">LinkedIn:</label>
                <input value="<?php echo $linkedin; ?>" type="url" class="form-control" name="linkedin" id="linkedin" />
            </div>

            <button type="submit" class="btn btn-success">Actualizar</button>
            <a href="index.php" class="btn btn-primary">Cancelar</a>
        </form>
    </div>
    <div class="card-footer text-muted"></div>
</div>

<?php 
include("../../templates/footer.php");
?>
