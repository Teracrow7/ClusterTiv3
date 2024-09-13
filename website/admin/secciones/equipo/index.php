<?php 
include("../../bd.php");

if (isset($_GET['txtID'])) {
    //eliminar registro
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

    $sentencia=$conexion->prepare( "SELECT imagen FROM equipo WHERE `id` = :id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $registro_imagen = $sentencia->fetch(PDO::FETCH_LAZY);
    if(isset($registro_imagen['imagen'])){
        if(file_exists("../../../assets/img/team/".$registro_imagen['imagen'])){
             unlink("../../../assets/img/team/".$registro_imagen['imagen']);
        }
    }

    $sentencia=$conexion->prepare( "DELETE FROM equipo WHERE `id` = :id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
}


//get entradas
$sentencia=$conexion->prepare("SELECT * FROM `equipo`");
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
                        <th scope="col">Imagen</th>
                        <th scope="col">Nombre Completo</th>
                        <th scope="col">Puesto</th>
                        <th scope="col">Twitter</th>
                        <th scope="col">Facebook</th>
                        <th scope="col">Linkedin</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($lista_entradas as $registros){?>
                    <tr class="">
                        <td><?php echo $registros['id'];?></td>
                        <td><img  src="../../../assets/img/team/<?php echo $registros['imagen'];?>" width="50" height="50"></td>
                        <td><?php echo $registros['nombrecompleto'];?></td>
                        <td><?php echo $registros['puesto'];?></td>
                        <td><?php echo $registros['twitter'];?></td>
                        <td><?php echo $registros['facebook'];?></td>
                        <td><?php echo $registros['linkedin'];?></td>
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