<?php 
include("../../bd.php");

if (isset($_GET['txtID'])) {
    // Seleccionar registro a editar 
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";

    $sentencia = $conexion->prepare("SELECT * FROM `equipo` WHERE id = :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    
    $imagen=$registro['imagen'];
    $nombre = $registro['nombrecompleto'];
    $puesto = $registro['puesto'];
    $twitter = $registro['twitter'];
    $facebook = $registro['facebook'];
    $linkedin = $registro['linkedin'];
}

if ($_POST) {
   //print_r($_POST);
    $txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
    $nombre = (isset($_POST['nombrecompleto']))?$_POST['nombrecompleto']:"";
    $puesto = (isset($_POST['puesto']))?$_POST['puesto']:"";
    $twitter = (isset($_POST['twitter']))?$_POST['twitter']:"";
    $facebook = (isset($_POST['facebook']))?$_POST['facebook']:"";
    $linkedin = (isset($_POST['linkedin']))?$_POST['linkedin']:"";
   

   $sentencia = $conexion->prepare("UPDATE `equipo` SET `nombrecompleto`=:nombrecompleto, `puesto`=:puesto, 
   twitter=:twitter, facebook=:facebook, linkedin=:linkedin WHERE `id` = :id");
   
    $sentencia->bindParam(":nombrecompleto",$nombre);
    $sentencia->bindParam(":puesto",$puesto);
    $sentencia->bindParam(":twitter",$twitter);
    $sentencia->bindParam(":facebook",$facebook);
    $sentencia->bindParam(":linkedin",$linkedin);
    $sentencia->bindParam(":id", $txtID);
   $sentencia->execute();

   if ($_FILES['imagen']['tmp_name']!="") {
    $imagen=(isset($_FILES['imagen']['name']))?$_FILES['imagen']['name']:"";
   $fecha_imagen=new DateTime();
   $nombre_archivo_img=($imagen!="")?$fecha_imagen->getTimestamp()."_".$imagen:"";
   $tmp_imagen=$_FILES['imagen']['tmp_name'];
   move_uploaded_file($tmp_imagen,"../../../assets/img/team/".$nombre_archivo_img);
    
   $sentencia=$conexion->prepare( "SELECT imagen FROM equipo WHERE `id` = :id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $registro_imagen = $sentencia->fetch(PDO::FETCH_LAZY);
    if(isset($registro_imagen['imagen'])){
        if(file_exists("../../../assets/img/team/".$registro_imagen['imagen'])){
             unlink("../../../assets/img/team/".$registro_imagen['imagen']);
        }
    }

   $sentencia = $conexion->prepare("UPDATE `equipo` SET `imagen`=:imagen  WHERE `id` = :id");
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
    <div class="card-header">Editar Miembro</div>
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
            <label for="imagen" class="form-label">
            <img  src="../../../assets/img/team/<?php echo $imagen;?>" width="90" height="90">
            </label>
            <input
                type="file"
                class="form-control"
                name="imagen"
                id="imagen"
                placeholder="imagen"
                aria-describedby="fileHelpId"
            />
         </div>

        <div class="mb-3">
            <label for="nombrecompleto" class="form-label">Nombre Completo:</label>
            <input value="<?php echo $nombre; ?>"
                type="text"
                class="form-control"
                name="nombrecompleto"
                id="nombrecompleto"
                aria-describedby="helpId"
                placeholder="Nombre Completo"
            />
         </div>
       
        <div class="mb-3">
            <label for="puesto" class="form-label">Puesto:</label>
            <input value="<?php echo $puesto; ?>"
                type="text"
                class="form-control"
                name="puesto"
                id="puesto"
                aria-describedby="helpId"
                placeholder="Puesto"
            />
         </div>
        
         <div class="mb-3">
            <label for="twitter" class="form-label">Twitter:</label>
            <input value="<?php echo $twitter; ?>"
                type="text"
                class="form-control"
                name="twitter"
                id="twitter"
                aria-describedby="helpId"
                placeholder="Twitter"
            />
         </div>

         <div class="mb-3">
            <label for="facebook" class="form-label">Facebook:</label>
            <input value="<?php echo $facebook; ?>"
                type="text"
                class="form-control"
                name="facebook"
                id="facebook"
                aria-describedby="helpId"
                placeholder="Facebook"
            />
         </div>

         <div class="mb-3">
            <label for="linkedin" class="form-label">Linkedin:</label>
            <input value="<?php echo $linkedin; ?>"
                type="text"
                class="form-control"
                name="linkedin"
                id="linkedin"
                aria-describedby="helpId"
                placeholder="Linkedin"
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