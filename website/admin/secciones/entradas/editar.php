<?php 
include("../../bd.php");

if (isset($_GET['txtID'])) {
    // Seleccionar registro a editar 
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";

    $sentencia = $conexion->prepare("SELECT * FROM `entradas` WHERE id = :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);

    $fecha = $registro['fecha'];
    $titulo = $registro['titulo'];
    $descripcion = $registro['descripcion'];
    $imagen=$registro['imagen'];
    
}

if ($_POST) {
   //print_r($_POST);
    $txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
    $fecha=(isset($_POST['fecha']))?$_POST['fecha']:"";
    $titulo=(isset($_POST['titulo']))?$_POST['titulo']:"";
    $descripcion=(isset($_POST['descripcion']))?$_POST['descripcion']:"";

   $sentencia = $conexion->prepare("UPDATE `entradas` SET `fecha`=:fecha,`titulo`=:titulo, 
    `descripcion`=:descripcion WHERE `id` = :id");
   
   $sentencia->bindParam(":fecha",$fecha);
   $sentencia->bindParam(":titulo",$titulo);
   $sentencia->bindParam(":descripcion",$descripcion);
   $sentencia->bindParam(":id", $txtID);
   $sentencia->execute();

   if ($_FILES['imagen']['tmp_name']!="") {
    $imagen=(isset($_FILES['imagen']['name']))?$_FILES['imagen']['name']:"";
   $fecha_imagen=new DateTime();
   $nombre_archivo_img=($imagen!="")?$fecha_imagen->getTimestamp()."_".$imagen:"";
   $tmp_imagen=$_FILES['imagen']['tmp_name'];
   move_uploaded_file($tmp_imagen,"../../../assets/img/entradas/".$nombre_archivo_img);
    
   $sentencia=$conexion->prepare( "SELECT imagen FROM entradas WHERE `id` = :id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $registro_imagen = $sentencia->fetch(PDO::FETCH_LAZY);
    if(isset($registro_imagen['imagen'])){
        if(file_exists("../../../assets/img/entradas/".$registro_imagen['imagen'])){
             unlink("../../../assets/img/entradas/".$registro_imagen['imagen']);
        }
    }

   $sentencia = $conexion->prepare("UPDATE `entradas` SET `imagen`=:imagen  WHERE `id` = :id");
   $sentencia->bindParam(":imagen",$nombre_archivo_img);
   $sentencia->bindParam(":id", $txtID);
   $sentencia->execute();
   }

   



   $mensaje="Registro modificado con éxito";
   header("Location: index.php?mensaje=".$mensaje);
}
include("../../templates/header.php")
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
                    aria-describedby="helpId"
                    placeholder="ID"
                    readonly
                />
            </div>

            <div class="mb-3">
            <label for="fecha" class="form-label">Fecha:</label>
            <input value="<?php echo $fecha; ?>"
                type="text"
                class="form-control"
                name="fecha"
                id="fecha"
                aria-describedby="helpId"
                placeholder="Fecha"
            />
         </div>

        <div class="mb-3">
            <label for="titulo" class="form-label">Título:</label>
            <input value="<?php echo $titulo; ?>"
                type="text"
                class="form-control"
                name="titulo"
                id="titulo"
                aria-describedby="helpId"
                placeholder="Título"
            />
         </div>
         <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <input value="<?php echo $descripcion; ?>"
                type="text"
                class="form-control"
                name="descripcion"
                id="descripcion"
                aria-describedby="helpId"
                placeholder="Descripción"
            />
         </div>
         <div class="mb-3">
            <label for="imagen" class="form-label">Imagen:</label>
            <img  src="../../../assets/img/entradas/<?php echo $imagen;?>" width="90" height="90">
            <input value=""
                type="file"
                class="form-control"
                name="imagen"
                id="imagen"
                placeholder="imagen"
                aria-describedby="fileHelpId"
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