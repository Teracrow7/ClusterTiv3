<?php 
include("../../bd.php");

if (isset($_GET['txtID'])) {
    //eliminar registro
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

    $sentencia=$conexion->prepare( "DELETE FROM slider WHERE `id` = :id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
}

//get slider
$sentencia=$conexion->prepare("SELECT * FROM `slider`");
$sentencia->execute();
$lista_slider=$sentencia->fetchAll(PDO::FETCH_ASSOC);
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
            >Agregar Noticia</a
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
                        <th scope="col">Título</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Acciones</th>
                    </tr>
                    
                </thead>
                <tbody>
                <?php foreach ($lista_slider as $registros){?>
                    <tr class="">
                        <td ><?php echo $registros['id'];?></td>
                        <td><img  src="../../../assets/img/slider/<?php echo $registros['imagen'];?>" width="90" height="90"></td>
                        <td><?php echo $registros['titulo'];?></td>
                        <td><?php echo $registros['descripcion'];?></td>
                        <td>
                            <a
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
    
</div>

<?php 
include("../../templates/footer.php")
?>