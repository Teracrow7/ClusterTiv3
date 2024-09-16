CREATE DATABASE  IF NOT EXISTS `clusterti` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `clusterti`;
-- MySQL dump 10.13  Distrib 8.0.28, for Win64 (x86_64)
--
-- Host: localhost    Database: clusterti
-- ------------------------------------------------------
-- Server version	8.0.28

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `configuraciones`
--

DROP TABLE IF EXISTS `configuraciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `configuraciones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombreconfig` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `valor` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuraciones`
--

LOCK TABLES `configuraciones` WRITE;
/*!40000 ALTER TABLE `configuraciones` DISABLE KEYS */;
INSERT INTO `configuraciones` VALUES (1,'Bienvenida','Bienvenid@ a Cluster TI Chiapas'),(3,'bienvenida_secundaria','Creando Alianzas, Innovando Ideas'),(4,'boton_bienvenida','Empezar'),(5,'link_boton_principal','#services'),(6,'titulo-servicios','SERVICIOS'),(7,'descripcion-servicios','Servicios de Calidad y Profesionales'),(8,'titulo-portafolio','PORTFOLIO'),(9,'descripcion-portafolio','Lorem ipsum dolor sit amet consectetur.'),(10,'titulo-about','NOSOTROS'),(11,'descripcion-about','Nuestra Historia'),(12,'titulo-team','MIEMBROS'),(13,'descripcion-team','Nuestro equipo de trabajo profesional.'),(14,'mensaje-miembros','Nuestro equipo combina experiencia técnica y creatividad para desarrollar soluciones de software innovadoras y efectivas.'),(15,'titulo-contacto','CONTACTANOS'),(16,'descripcion-contacto','Contactanos en cualquier momento'),(17,'link-twitter','https://x.com/ClusterTI'),(18,'link-facebook','https://www.facebook.com/ClusterTIChiapas'),(19,'link-linkedin','https://www.linkedin.com/in/cluster-ti-chiapas-a-c-14b54a112/?originalSubdomain=mx');
/*!40000 ALTER TABLE `configuraciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entradas`
--

DROP TABLE IF EXISTS `entradas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `entradas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fecha` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entradas`
--

LOCK TABLES `entradas` WRITE;
/*!40000 ALTER TABLE `entradas` DISABLE KEYS */;
INSERT INTO `entradas` VALUES (4,'2024-05-21','Logo','¡Innovación! Software a la medida, ideas que se materializan','1716245112_326343995_1210229976270454_4966552485625561777_n.png'),(5,'2024-09-17','Inauguración del Hub','Creacion del logo ','1726154404_SLIDES CLUSTER_Mesa de trabajo 1 copia.jpg');
/*!40000 ALTER TABLE `entradas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipo`
--

DROP TABLE IF EXISTS `equipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `imagen` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nombrecompleto` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `puesto` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `twitter` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `linkedin` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipo`
--

LOCK TABLES `equipo` WRITE;
/*!40000 ALTER TABLE `equipo` DISABLE KEYS */;
INSERT INTO `equipo` VALUES (2,'1716248267_326343995_1210229976270454_4966552485625561777_n.png','clusterTI','empresa','https://x.com/clustertituxtla','https://www.facebook.com/ClusterTIChiapas/','https://www.linkedin.com/in/clustertichiapas'),(4,'1716421011_descargar.jpeg','Member One ','Dev','.https://x.com/ArmandoH','https://www.facebook.com/ArmandoH','https://www.linkedin.com/in/ArmandoH');
/*!40000 ALTER TABLE `equipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eventos`
--

DROP TABLE IF EXISTS `eventos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eventos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(1000) NOT NULL,
  `content` varchar(6000) NOT NULL,
  `cover` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventos`
--

LOCK TABLES `eventos` WRITE;
/*!40000 ALTER TABLE `eventos` DISABLE KEYS */;
/*!40000 ALTER TABLE `eventos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `portafolio`
--

DROP TABLE IF EXISTS `portafolio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `portafolio` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `subtitulo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `cliente` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `categoria` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `portafolio`
--

LOCK TABLES `portafolio` WRITE;
/*!40000 ALTER TABLE `portafolio` DISABLE KEYS */;
INSERT INTO `portafolio` VALUES (7,'Masivo XML','Pagina de Aterrizaje','1716420971_header-bg.jpg','Landing page ','Masivo XML','web','www.masivoxml.com'),(8,'PROJECT NAME','Lorem ipsum dolor sit amet consectetur.','1716240238_1716237648_Captura de pantalla 2024-05-20 141433.png','Use this area to describe your project. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est blanditiis dolorem culpa incidunt minus dignissimos deserunt repellat aperiam quasi sunt officia expedita beatae cupiditate, maiores repudiandae, nostrum','Threads',' Illustration','www.p.com'),(10,'punto de venta','aplicacion escritorio','1716421812_header-bg.jpg','lkajsdljaslkdjlajsd asdjalksjdlajslkd jalsjdlajsdljasd','google','aplicacion de escritorio','www.google.com');
/*!40000 ALTER TABLE `portafolio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Slider`
--


DROP TABLE IF EXISTS `Slider`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE `Slider` (
  `id` int NOT NULL AUTO_INCREMENT,
  `imagen` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;
LOCK TABLES `servicios` WRITE;
/*!40000 ALTER TABLE `slider` DISABLE KEYS */;
-- Inserción de 3 registros en la tabla Slider

INSERT INTO `Slider` (`imagen`, `titulo`, `descripcion`) 
VALUES 
('1726515762_SLIDES CLUSTER_Mesa de trabajo 1 copia.jpg', 'Inauguracion del HUB', 'Inauguracion del HUB'),
('1726516299_SLIDES CLUSTER-04.jpg', '', ''),
('1726516311_SLIDES CLUSTER-02.jpg', '', '');
/*!40000 ALTER TABLE `slider` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicios`
--

DROP TABLE IF EXISTS `servicios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `servicios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `icono` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Dumping data for table `servicios`
LOCK TABLES `servicios` WRITE;
/*!40000 ALTER TABLE `servicios` DISABLE KEYS */;
INSERT INTO `servicios` (`id`, `icono`, `titulo`, `descripcion`) VALUES 
(1, '1726152203_iconos cluster-02.jpg', 'Diseño de páginas Web', 'Diseñamos páginas web atractivas y funcionales'),
(2, '1726152046_iconos cluster_Mesa de trabajo 1.jpg', 'Desarrollo de Aplicaciones Móviles', 'Creación de aplicaciones móviles personalizadas para Android e iOS'),
(3, '1726152347_iconos cluster-03.jpg', 'Capacitaciones', 'Impartimos cursos de diversas áreas de tecnología'),
(4, '1726152419_iconos cluster-05.jpg', 'Desarrollo de Software a la Medida', 'Desarrollo de Software a la Medida');
/*!40000 ALTER TABLE `servicios` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `correo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(32) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (7,'Admin','$2y$10$k3h.cK0yK83miqMpVF2hG.dSGW4Zs6zJIZymyoyvj4lRGgDYwe6OO','admin@clusterti.com','dd05ce4684f11e28d368966da84c2472'),(8,'Test2024','$2y$10$NjE2tXd2vv9NL2S4ykMNi.3k.P/g06wjSj1T/pAyh/XTtnaDWHbia','test@clusterti.com',NULL);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-12  6:56:16
