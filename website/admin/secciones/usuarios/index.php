<?php 
include("../../bd.php");

if (isset($_GET['txtID'])) {
    //eliminar registro
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

    $sentencia=$conexion->prepare( "DELETE FROM usuarios WHERE `id` = :id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
}


//get usuarios
$sentencia=$conexion->prepare("SELECT * FROM `usuarios`");
$sentencia->execute();
$lista_usuarios=$sentencia->fetchAll(PDO::FETCH_ASSOC);
include("../../templates/header.php")
?>
<div class="card">
    <div class="card-header"> <a
            name=""
            id=""
            class="btn btn-primary"
            href="crear.php"
            role="button"
            >Agregar</a
        ></div>
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
                <th scope="col">Nombre Usario</th>
                <th scope="col">Password</th>
                <th scope="col">Correo</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($lista_usuarios as $registros){?>
            <tr class="">
                <td ><?php echo $registros['id'];?></td>
                <td><?php echo $registros['usuario'];?></td>
                <td><?php echo $registros['password'];?></td>
                <td><?php echo $registros['correo'];?></td>
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
   
</div>


<?php 
include("../../templates/footer.php")
?>