<?php 
include("../../bd.php");

$mensaje = "";
$txtID = "";
$nombre = "";
$valor = "";

// Validate and sanitize `txtID`
if (isset($_GET['txtID'])) {
    $txtID = filter_var($_GET['txtID'], FILTER_SANITIZE_NUMBER_INT);

    if (!$txtID || !is_numeric($txtID)) {
        $mensaje = "ID inválido.";
        header("Location: index.php?mensaje=" . urlencode($mensaje));
        exit();
    }

    // Fetch the record to edit
    $sentencia = $conexion->prepare("SELECT * FROM `configuraciones` WHERE id = :id");
    $sentencia->bindParam(":id", $txtID, PDO::PARAM_INT);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_ASSOC);

    if ($registro) {
        $nombre = htmlspecialchars($registro['nombreconfig']);
        $valor = htmlspecialchars($registro['valor']);
    } else {
        $mensaje = "Registro no encontrado.";
        header("Location: index.php?mensaje=" . urlencode($mensaje));
        exit();
    }
}

if ($_POST) {
    // Validate and sanitize inputs
    $txtID = filter_var($_POST['txtID'], FILTER_SANITIZE_NUMBER_INT);
    $nombre = filter_var(trim($_POST['nombreconfig']), FILTER_SANITIZE_STRING);
    $valor = filter_var(trim($_POST['valor']), FILTER_SANITIZE_STRING);

    if (!$txtID || !$nombre || !$valor) {
        $mensaje = "Todos los campos son obligatorios.";
        header("Location: index.php?mensaje=" . urlencode($mensaje));
        exit();
    }

    try {
        // Update the record
        $sentencia = $conexion->prepare(
            "UPDATE `configuraciones` 
             SET `nombreconfig` = :nombreconfig, `valor` = :valor 
             WHERE `id` = :id"
        );
        $sentencia->bindParam(":nombreconfig", $nombre, PDO::PARAM_STR);
        $sentencia->bindParam(":valor", $valor, PDO::PARAM_STR);
        $sentencia->bindParam(":id", $txtID, PDO::PARAM_INT);

        if ($sentencia->execute()) {
            $mensaje = "Registro modificado con éxito.";
        } else {
            $mensaje = "Error al modificar el registro.";
        }
        header("Location: index.php?mensaje=" . urlencode($mensaje));
        exit();
    } catch (Exception $e) {
        error_log($e->getMessage());
        $mensaje = "Ocurrió un error. Inténtelo de nuevo más tarde.";
        header("Location: index.php?mensaje=" . urlencode($mensaje));
        exit();
    }
}

include("../../templates/header.php");
?>

<div class="card">
    <div class="card-header">Editar Configuración</div>
    <div class="card-body">
        <form action="" enctype="multipart/form-data" method="post">
            <div class="mb-3">
                <label for="txtID" class="form-label">ID:</label>
                <input
                    value="<?php echo htmlspecialchars($txtID); ?>"
                    type="text"
                    class="form-control"
                    name="txtID"
                    id="txtID"
                    placeholder="ID"
                    readonly
                />
            </div>
            <div class="mb-3">
                <label for="nombreconfig" class="form-label">Nombre configuración:</label>
                <input
                    value="<?php echo htmlspecialchars($nombre); ?>"
                    type="text"
                    class="form-control"
                    name="nombreconfig"
                    id="nombreconfig"
                    placeholder="Nombre de la configuración"
                    required
                />
            </div>
            <div class="mb-3">
                <label for="valor" class="form-label">Valor:</label>
                <input
                    value="<?php echo htmlspecialchars($valor); ?>"
                    type="text"
                    class="form-control"
                    name="valor"
                    id="valor"
                    placeholder="Valor"
                    required
                />
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
