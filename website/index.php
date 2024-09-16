<?php
include("admin/bd.php"); // Asegúrate de que este archivo defina la variable $conexion correctamente

// Verifica que la conexión se haya establecido antes de continuar
if ($conexion) {

    //slider
    $sentencia = $conexion->prepare("SELECT * FROM slider");
    $sentencia->execute();
    $lista_noticias = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    // servicios
    $sentencia = $conexion->prepare("SELECT * FROM servicios");
    $sentencia->execute();
    $lista_servicios = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    // portafolio
   // $sentencia = $conexion->prepare("SELECT * FROM portafolio");
    //$sentencia->execute();
    //$lista_portafolio = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    // entradas
    $sentencia = $conexion->prepare("SELECT * FROM entradas");
    $sentencia->execute();
    $lista_entradas = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    // team
    $sentencia = $conexion->prepare("SELECT * FROM equipo");
    $sentencia->execute();
    $lista_equipo = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    // configuraciones
    $sentencia = $conexion->prepare("SELECT * FROM configuraciones");
    $sentencia->execute();
    $lista_configuraciones = $sentencia->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "Error: No se pudo conectar a la base de datos.";
    exit; // Salir si no hay conexión
}
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>CLUSTER TI CHIAPAS</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="#page-top"><img src="assets/img/logo.png" alt="..." /></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ms-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                        <li class="nav-item"><a class="nav-link" href="#services">Servicios</a></li>
                        <!--<li class="nav-item"><a class="nav-link" href="#portfolio">Portafolio</a></li>-->
                        <li class="nav-item"><a class="nav-link" href="#about">Eventos</a></li>
                        <li class="nav-item"><a class="nav-link" href="#team">Miembros</a></li>
                        <li class="nav-item"><a class="nav-link" href="#hub">Hub Tech</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Contacto</a></li>
                        
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead">
            <div class="container">
                <div class="masthead-subheading"><?php echo $lista_configuraciones[0]['valor']?></div>
                <div class="masthead-heading text-uppercase"><?php echo $lista_configuraciones[1]['valor']?></div>

                

<!-- Inicio del carrusel -->
<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
    <!-- Indicadores -->
    <div class="carousel-indicators">
        <?php foreach ($lista_noticias as $index => $item): ?>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo $index; ?>" class="<?php echo $index === 0 ? 'active' : ''; ?>" aria-current="<?php echo $index === 0 ? 'true' : 'false'; ?>" aria-label="Slide <?php echo $index + 1; ?>"></button>
        <?php endforeach; ?>
    </div>

    <!-- Contenido del carrusel -->
    <div class="carousel-inner">
        <?php foreach ($lista_noticias as $index => $item): ?>
        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
            <!-- Contenedor centrado sin fondo blanco -->
            <div class="slider-container" style="display: flex; justify-content: center; padding: 20px;">
                <div class="slider-item" style="width: 83%; padding: 0; border-radius: 55px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
                    <!-- Imagen con ajuste responsivo -->
                    <img src="assets/img/slider/<?php echo $item['imagen']; ?>" class="d-block w-100" style="height: 400px; object-fit: cover;" alt="<?php echo $item['titulo']; ?>">
                    <!-- Título y descripción debajo de la imagen -->
                    <div class="text-center mt-3">
                    <h5 style="color: black;"><?php echo $item['titulo']; ?></h5>
                    <p style="color: white;"><?php echo $item['descripcion']; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Controles del carrusel -->
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Siguiente</span>
    </button>
</div>

<!-- Asegúrate de incluir Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- CSS adicional para hacer el carrusel responsivo y centrado -->
<style>
    /* Ajuste del contenedor principal del slider */
    .slider-container {
        max-width: 100%;
        display: flex;
        align-items: center;
        /* Ajusta la posición del slider usando margen */
        margin-left: 0;  /* Cambia este valor para mover el slider a la izquierda o derecha si es necesario */
    }

    /* Asegura que la imagen mantenga sus proporciones en cualquier tamaño de pantalla */
    .slider-item img {
        width: 100%;
        height: auto;
    }

    /* Ajuste del borde redondeado */
    .slider-item {
        /* Puedes ajustar el tamaño del borde aquí */
        border-radius: 15px;  /* Cambia este valor para modificar el tamaño del borde redondeado */
    }

    /* Margen y espaciado para el texto */
    .carousel-caption h5, .carousel-caption p {
        margin: 0;
    }

    /* Margen para dispositivos pequeños */
    @media (max-width: 768px) {
        .slider-item {
            padding: 10px;
        }
        .slider-item img {
            max-height: 250px;
        }
    }
</style>








                
            </div>
        </header>
        <!-- Services-->
        <section class="page-section" id="services">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase"><?php echo $lista_configuraciones[4]['valor']?></h2>
                    <h3 class="section-subheading text-muted"><?php echo $lista_configuraciones[5]['valor']?></h3>
                </div>
                <div class="row text-center">
                    <?php foreach ($lista_servicios as $registros){?>

                        <div class="col-md-4">
                            <span class="d-block mb-4">
                                <img src="assets/img/servicios/<?php echo $registros['icono']; ?>" alt="Imagen de Servicio" class="img-fluid" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                            </span>
                            <h4 class="my-3"><?php echo $registros['titulo']; ?></h4>
                            <p class="text-muted"><?php echo $registros['descripcion']; ?></p>
                        </div>

                    <?php }?>
        
                </div>
            </div>
        </section>
        <!-- Portfolio Grid-->
        <!-- 
        <section class="page-section bg-light" id="portfolio">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase"><?//php echo $lista_configuraciones[6]['valor']?></h2>
                    <h3 class="section-subheading text-muted"><?//php echo $lista_configuraciones[7]['valor']?></h3>
                </div>
                <div class="row">
                    <//?php foreach ($lista_portafolio as $registros){?>
                    <div class="col-lg-4 col-sm-6 mb-4">
                    -->
                        <!-- Portfolio item 1-->
                         <!-- 
                        <div class="portfolio-item">
                            <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal<?php echo $registros['id'];?>">
                                <div class="portfolio-hover">
                                    <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                                </div>
                                <img class="img-fluid" src="assets/img/portfolio/<//?php echo $registros['imagen'];?>" alt="..." />
                            </a>
                            <div class="portfolio-caption">
                                <div class="portfolio-caption-heading"><?//php echo $registros['titulo'];?></div>
                                <div class="portfolio-caption-subheading text-muted"><?//php echo $registros['subtitulo'];?></div>
                            </div>
                        </div>
                    </div>
                    <div class="portfolio-modal modal fade" id="portfolioModal<?//php echo $registros['id'];?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="close-modal" data-bs-dismiss="modal"><img src="assets/img/close-icon.svg" alt="Close modal" /></div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="modal-body">
                    -->
                                    <!-- Project details-->
                                     <!-- 
                                    <h2 class="text-uppercase"><?//php echo $registros['titulo'];?></h2>
                                    <p class="item-intro text-muted"><?//php echo $registros['subtitulo'];?></p>
                                    <img class="img-fluid d-block mx-auto" src="assets/img/portfolio/<?php echo $registros['imagen'];?>" alt="..." />
                                    <p><?//php echo $registros['descripcion'];?></p>
                                    <ul class="list-inline">
                                        <li>
                                            <strong>Cliente:</strong>
                                            <?//php echo $registros['cliente'];?>
                                        </li>
                                        <li>
                                            <strong>Categoria:</strong>
                                            <?//php echo $registros['categoria'];?>
                                        </li>
                                        <li>
                                            <strong>URL:</strong>
                                            <a href="<?//php echo $registros['url'];?>"><?//php echo $registros['url'];?></a>
                                        </li>
                                    </ul>
                                    <button class="btn btn-primary btn-xl text-uppercase" data-bs-dismiss="modal" type="button">
                                        <i class="fas fa-xmark me-1"></i>
                                        Cerrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                    <?//php }?>
                    
                    
            </div>
        </section>
                    -->
        <!-- About -->
<section class="page-section bg-light" id="about">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading text-uppercase"><?php echo $lista_configuraciones[8]['valor']?></h2>
            <h3 class="section-subheading text-muted"><?php echo $lista_configuraciones[9]['valor']?></h3>
        </div>
        <ul class="timeline">
            <?php 
            $contador = 1;
            foreach ($lista_entradas as $registros) { ?>
                <li <?php echo (($contador % 2) == 0) ? 'class="timeline-inverted"' : ""; ?>>
                    <div class="timeline-image" style="width: 245px; height: 175px; overflow: hidden; position: relative;">
                        <img class="rounded-circle img-fluid" 
                            src="assets/img/entradas/<?php echo $registros['imagen']; ?>" 
                            alt="..." 
                            style="object-fit: cover; left:0; width: 100%; height: 100%; position: absolute; top: 0; left: 0;" />
                    </div>
                    <div class="timeline-panel" style="height:100;"> <!-- Centrar el texto -->
                        <div class="timeline-heading">
                            <h4><?php echo $registros['fecha']; ?></h4>
                            <h4 class="subheading"><?php echo $registros['titulo']; ?></h4>
                        </div>
                        <div class="timeline-body">
                            <p class="text-muted"><?php echo $registros['descripcion']; ?></p>
                        </div>
                    </div>
                </li>
            <?php 
            $contador++;
            } ?>
            <li class="timeline-inverted">
                <div class="timeline-image">
                    <h4>
                        Y AUN NOS ESPERA
                        <br />
                        MAS!!!
                    </h4>
                </div>
            </li>
        </ul>
    </div>
</section>







        <!-- Team-->
        <section class="page-section" id="team">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase"><?php echo $lista_configuraciones[10]['valor']?> </h2>
                    <h3 class="section-subheading text-muted"><?php echo $lista_configuraciones[11]['valor']?></h3>
                </div>
                <div class="row">
                <?php foreach ($lista_equipo as $registros){?>
                    <div class="col-lg-4">
                        <div class="team-member">
                            <img class="mx-auto rounded-circle" src="assets/img/team/<?php echo $registros['imagen'];?>" alt="..." />
                            <h4><?php echo $registros['nombrecompleto'];?></h4>
                            <p class="text-muted"><?php echo $registros['puesto'];?></p>
                            <a class="btn btn-dark btn-social mx-2" href="<?php echo $registros['twitter'];?>" aria-label="<?php echo $registros['nombrecompleto'];?> Twitter Profile"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-dark btn-social mx-2" href="<?php echo $registros['facebook'];?>" aria-label="<?php echo $registros['nombrecompleto'];?> Facebook Profile"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-dark btn-social mx-2" href="<?php echo $registros['linkedin'];?>" aria-label="<?php echo $registros['nombrecompleto'];?> LinkedIn Profile"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>

                    <?php }?>
                </div>
                <div class="row">
                    <div class="col-lg-8 mx-auto text-center"><p class="large text-muted"><?php echo $lista_configuraciones[12]['valor']?></p></div>
                </div>
            </div>
        </section>

        <!-- Hub (nueva sección)-->
        <section class="page-section bg-light" id="hub" style="padding: 60px 0; background-color: #f8f9fa;">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase" style="color: #333;">Hub Tech</h2>
                    <h3 class="section-subheading text-muted" style="color: #666;">¡Inauguramos un hub de innovación! Software para Android e iOS, conócelo dándole clic a la imagen</h3>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <!-- Imagen del Hub -->
                        <img class="img-fluid mb-4" src="assets/img/team/logo hub_Mesa de trabajo 1.jpg" alt="Hub Image" style="width: 100%; max-width: 800px; height: auto;" />
                        <!-- Botón "Conocer Hub" -->
                        <a href="https://hubtechiapas.com/" target="_blank" class="btn-hub">
                            Conocer Hub
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Agrega estos estilos en tu archivo CSS (styles.css) o dentro de <style> en el archivo HTML -->
        <style>
        /* Estilos del botón "Conocer Hub" */
        .btn-hub {
            display: inline-block;
            padding: 15px 30px;
            font-size: 16px;
            font-weight: bold;
            color: black;
            background-color: lightseagreen; /* Color azul para el botón */
            border: 2px solid white;
            border-radius: 5px;
            text-decoration: white;
            text-align: center;
            transition: all 0.3s ease;
        }

        .btn-hub:hover {
            color: black;
            background-color: lightgreen; /* Color azul más oscuro en hover */
            border-color: black;
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            
        }
        </style>

        <!-- Contact-->
        <section class="page-section" id="contact">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase"><?php echo $lista_configuraciones[13]['valor']?></h2>
                    <h3 class="section-subheading text-muted"><?php echo $lista_configuraciones[14]['valor']?></h3>
                </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="footer py-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 text-lg-start">Copyright &copy; CLUSTER TI CHIAPAS 2024</div>
                    <div class="col-lg-4 my-3 my-lg-0">
                        <a class="btn btn-dark btn-social mx-2" href="<?php echo $lista_configuraciones[15]['valor']?>" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="<?php echo $lista_configuraciones[16]['valor']?>" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="<?php echo $lista_configuraciones[17]['valor']?>" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a class="link-dark text-decoration-none me-3" href="#!">Privacy Policy</a>
                        <a class="link-dark text-decoration-none" href="#!">Terms of Use</a>
                    </div>
                </div>
            </div>
        </footer>
        
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>
