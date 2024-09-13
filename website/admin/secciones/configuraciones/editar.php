<?php 
include("../../bd.php");

if (isset($_GET['txtID'])) {
    // Seleccionar registro a editar 
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";

    $sentencia = $conexion->prepare("SELECT * FROM `configuraciones` WHERE id = :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);

    
    $nombre = $registro['nombreconfig'];
    $valor = $registro['valor'];

}

if ($_POST) {
   //print_r($_POST);
    $txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
    $nombre=(isset($_POST['nombreconfig']))?$_POST['nombreconfig']:"";
    $valor=(isset($_POST['valor']))?$_POST['valor']:"";


   $sentencia = $conexion->prepare("UPDATE `configuraciones` SET `nombreconfig`=:nombreconfig, `valor`=:valor WHERE `id` = :id");
   
   $sentencia->bindParam(":nombreconfig",$nombre);
    $sentencia->bindParam(":valor",$valor);
   $sentencia->bindParam(":id", $txtID);
   $sentencia->execute();


   $mensaje="Registro modificado con éxito";
   header("Location: index.php?mensaje=".$mensaje);
}
include("../../templates/header.php")
?>
<div class="card">
    <div class="card-header">Editar Usuario</div>
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
                    aria-describedby="helpId"
                    placeholder="ID"
                    readonly
                />
            </div>
        <div class="mb-3">
            <label for="nombreconfig" class="form-label">Nombre configuracion:</label>
            <input value="<?php echo $nombre; ?>"
                type="text"
                class="form-control"
                name="nombreconfig"
                id="nombreconfig"
                aria-describedby="helpId"
                placeholder="Nombre de la configuracion"
            />
         </div>
         <div class="mb-3">
            <label for="valor" class="form-label">Valor:</label>
            <input value="<?php echo $valor; ?>"
                type="text"
                class="form-control"
                name="valor"
                id="valor"
                aria-describedby="helpId"
                placeholder="Valor"
            />
         </div>
         
         
         
        

         <button
            type="submit"
            class="btn btn-success"
         >
            Actualizar
         </button>
         <a
            name=""
            id=""
            class="btn btn-primary"
            href="index.php"
            role="button"
            >Cancelar</a
         >
         

        </form>
    </div>
    <div class="card-footer text-muted">

    </div>
</div>

<?php 
include("../../templates/footer.php")
?>