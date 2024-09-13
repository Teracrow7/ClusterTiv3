<?php 
include("../../bd.php");
if ($_POST) {
    $nombre=(isset($_POST['nombreconfig']))?$_POST['nombreconfig']:"";
    $valor=(isset($_POST['valor']))?$_POST['valor']:"";
    

    $sentencia=$conexion->prepare("INSERT INTO `configuraciones` (`id`, `nombreconfig`, `valor`) 
    VALUES (NULL, :nombreconfig, :valor);");
 
    $sentencia->bindParam(":nombreconfig",$nombre);
    $sentencia->bindParam(":valor",$valor);
   
    
    $sentencia->execute();
    $mensaje="Registro Creado con éxito";
    header("Location: index.php?mensaje=".$mensaje);
  
}
include("../../templates/header.php")
?>
<div class="card">
    <div class="card-header">Configuracion</div>
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
                />
            </div>

            <button
            type="submit"
            class="btn btn-success"
         >
            Agregar
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
    
</div>


<?php 
include("../../templates/footer.php")
?>