<?php 
include("../../bd.php");

if ($_POST) {
    $nombre = isset($_POST['nombreconfig']) ? trim($_POST['nombreconfig']) : "";
    $valor = isset($_POST['valor']) ? trim($_POST['valor']) : "";

    // Validate and sanitize input
    if (empty($nombre) || empty($valor)) {
        $mensaje = "Todos los campos son obligatorios.";
        header("Location: index.php?mensaje=" . urlencode($mensaje));
        exit();
    }

    try {
        // Insert the record
        $sentencia = $conexion->prepare(
            "INSERT INTO `configuraciones` (`id`, `nombreconfig`, `valor`) 
             VALUES (NULL, :nombreconfig, :valor);"
        );
        $sentencia->bindParam(":nombreconfig", $nombre, PDO::PARAM_STR);
        $sentencia->bindParam(":valor", $valor, PDO::PARAM_STR);

        if ($sentencia->execute()) {
            $mensaje = "Registro creado con éxito.";
            header("Location: index.php?mensaje=" . urlencode($mensaje));
            exit();
        } else {
            $mensaje = "Error al crear el registro.";
            header("Location: index.php?mensaje=" . urlencode($mensaje));
            exit();
        }
    } catch (Exception $e) {
        // Log the error and show a user-friendly message
        error_log($e->getMessage());
        $mensaje = "Ocurrió un error. Inténtelo de nuevo más tarde.";
        header("Location: index.php?mensaje=" . urlencode($mensaje));
        exit();
    }
}

include("../../templates/header.php");
?>
<div class="card">
    <div class="card-header">Configuración</div>
    <div class="card-body">
        <form action="" method="post">
            <div class="mb-3">
                <label for="nombreconfig" class="form-label">Nombre configuración:</label>
                <input
                    type="text"
                    class="form-control"
                    name="nombreconfig"
                    id="nombreconfig"
                    aria-describedby="helpId"
                    placeholder="Nombre de configuración"
                    required
                />
            </div>
            
            <div class="mb-3">
                <label for="valor" class="form-label">Valor:</label>
                <input
                    type="text"
                    class="form-control"
                    name="valor"
                    id="valor"
                    aria-describedby="helpId"
                    placeholder="Valor"
                    required
                />
            </div>

            <button type="submit" class="btn btn-success">Agregar</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
</div>

<?php 
include("../../templates/footer.php");
?>
