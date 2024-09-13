<?php 
include("../../bd.php");

if (isset($_GET['txtID'])) {
    //eliminar registro
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

    $sentencia=$conexion->prepare( "SELECT imagen FROM entradas WHERE `id` = :id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $registro_imagen = $sentencia->fetch(PDO::FETCH_LAZY);
    if(isset($registro_imagen['imagen'])){
        if(file_exists("../../../assets/img/entradas/".$registro_imagen['imagen'])){
             unlink("../../../assets/img/entradas/".$registro_imagen['imagen']);
        }
    }

    $sentencia=$conexion->prepare( "DELETE FROM entradas WHERE `id` = :id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
}


//get entradas
$sentencia=$conexion->prepare("SELECT * FROM `entradas`");
$sentencia->execute();
$lista_entradas=$sentencia->fetchAll(PDO::FETCH_ASSOC);
include("../../templates/header.php")

?>

<div class="card">
    <div class="card-header">
        <a
            name=""
            id=""
            class="btn btn-primary"
            href="crear.php"
            role="button"
            >Agregar</a
        >
        
    </div>
    <div class="card-body">
        <div
            class="table-responsive-sm"
        >
            <table
                class="table table-primary"
            >
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Titulo</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($lista_entradas as $registros){?>
                    <tr class="">
                        <td><?php echo $registros['id'];?></td>
                        <td><?php echo $registros['fecha'];?></td>
                        <td><?php echo $registros['titulo'];?></td>
                        <td><?php echo $registros['descripcion'];?></td>
                        <td><img  src="../../../assets/img/entradas/<?php echo $registros['imagen'];?>" width="90" height="90"></td>
                        <td> <a
                                name=""
                                id=""
                                class="btn btn-info"
                                href="editar.php?txtID=<?php echo $registros['id'];?>"
                                role="button"
                                >Editar</a
                            >
                            |
                            <a
                                name=""
                                id=""
                                class="btn btn-danger"
                                href="index.php?txtID=<?php echo $registros['id'];?>"
                                role="button"
                                >Eliminar</a
                            >
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
        
    </div>
    <div class="card-footer text-muted"></div>
</div>

<?php 
include("../../templates/footer.php")
?>