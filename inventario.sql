CREATE DATABASE  IF NOT EXISTS `inventario_sistemas` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `inventario_sistemas`;
-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: inventario_sistemas
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `celulares`
--

DROP TABLE IF EXISTS `celulares`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `celulares` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cedula` varchar(20) DEFAULT NULL,
  `serial` varchar(50) DEFAULT NULL,
  `imei` varchar(50) DEFAULT NULL,
  `placa_activos` varchar(50) DEFAULT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `fecha_compra` date DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cedula` (`cedula`),
  CONSTRAINT `celulares_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `empleados` (`cedula`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `celulares`
--

LOCK TABLES `celulares` WRITE;
/*!40000 ALTER TABLE `celulares` DISABLE KEYS */;
INSERT INTO `celulares` VALUES (1,'41242379','3312423525','56457474','cp-0005','motorola','15','2025-02-25',NULL,NULL),(2,'41242379','9281927361','12423566345','cp-00065','motorola','g13','2025-02-26',NULL,NULL),(3,'1121831496','142353462','35345734525','cp-00056','motorola','g56','2025-03-07',NULL,NULL),(4,'214156163','1241252363472','2463545723632','cp-200','lenovo','g56','2025-03-12',NULL,NULL);
/*!40000 ALTER TABLE `celulares` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `computadores`
--

DROP TABLE IF EXISTS `computadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `computadores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cedula` varchar(20) DEFAULT NULL,
  `dispositivo` varchar(50) DEFAULT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `referencia` varchar(50) DEFAULT NULL,
  `mac` varchar(50) DEFAULT NULL,
  `placa_activos` varchar(50) DEFAULT NULL,
  `serial` varchar(50) DEFAULT NULL,
  `ram` varchar(20) DEFAULT NULL,
  `estado_entrega` varchar(50) DEFAULT NULL,
  `disco_duro` varchar(50) DEFAULT NULL,
  `cuenta_email` varchar(100) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `fecha_compra` date DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cedula` (`cedula`),
  CONSTRAINT `computadores_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `empleados` (`cedula`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `computadores`
--

LOCK TABLES `computadores` WRITE;
/*!40000 ALTER TABLE `computadores` DISABLE KEYS */;
INSERT INTO `computadores` VALUES (1,'41242379','portatil','lenovo','thinkbook','13134125243634','cp-00032','131212412412','8gb','nuevo','256gb','sdasdaf@gmail.com','2025-02-26',NULL,NULL),(2,'41242379','portatil','lenovo','thinkbook','131341252436345','cp-102','1312536236','8gb','nuevo','256gb','sdasda3f@gmail.com',NULL,'2025-03-12',NULL),(3,'12125126','portatil','lenovo','thinkbook','34634623626','cp-103','3463473736','8gb','nuevo','256gb','sdasd4a3f@gmail.com','2025-03-12','2025-03-12',NULL);
/*!40000 ALTER TABLE `computadores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empleados`
--

DROP TABLE IF EXISTS `empleados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empleados` (
  `cedula` varchar(20) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `cargo` varchar(50) DEFAULT NULL,
  `area` varchar(50) DEFAULT NULL,
  `sub_area` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`cedula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleados`
--

LOCK TABLES `empleados` WRITE;
/*!40000 ALTER TABLE `empleados` DISABLE KEYS */;
INSERT INTO `empleados` VALUES ('1121831496','Sebastian Amaya','auxiliar it','direccion ','sistemas'),('12125126','Juan diego','bascula','agronomico','extractora'),('214151251','pipto amaya','bascula','direccion ','sistemas'),('214156163','pepito perez','coordinadora','direccion ','sanidad'),('41242379','mariana diaz','coordinadora','agronomico','sanidad');
/*!40000 ALTER TABLE `empleados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `impresoras`
--

DROP TABLE IF EXISTS `impresoras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `impresoras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cedula` varchar(20) DEFAULT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `serial` varchar(50) DEFAULT NULL,
  `placa_activos` varchar(50) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `fecha_asignacion` date DEFAULT NULL,
  `fecha_compra` date DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cedula` (`cedula`),
  CONSTRAINT `impresoras_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `empleados` (`cedula`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `impresoras`
--

LOCK TABLES `impresoras` WRITE;
/*!40000 ALTER TABLE `impresoras` DISABLE KEYS */;
INSERT INTO `impresoras` VALUES (1,'1121831496','epson','L3150','3574588737','cp-205','vieja','2025-03-12','2025-03-12',NULL),(2,'1121831496','epson','L3150','3574588737','cp-205','vieja','2025-03-12','2025-03-12',NULL);
/*!40000 ALTER TABLE `impresoras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `radios`
--

DROP TABLE IF EXISTS `radios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `radios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cedula` varchar(20) DEFAULT NULL,
  `serial` varchar(50) DEFAULT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `placa_activos_fijos` varchar(50) DEFAULT NULL,
  `dispositivo` varchar(50) DEFAULT NULL,
  `referencia` varchar(50) DEFAULT NULL,
  `estado_entrega` varchar(50) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `fecha_compra` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cedula` (`cedula`),
  CONSTRAINT `radios_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `empleados` (`cedula`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `radios`
--

LOCK TABLES `radios` WRITE;
/*!40000 ALTER TABLE `radios` DISABLE KEYS */;
INSERT INTO `radios` VALUES (1,'1121831496','23643272626','motorola','cp202','radio','negro','nuevo','buen estado','2025-03-12','2025-03-12');
/*!40000 ALTER TABLE `radios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `responsables_inventario`
--

DROP TABLE IF EXISTS `responsables_inventario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `responsables_inventario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `cargo` varchar(50) NOT NULL,
  `area` varchar(50) NOT NULL,
  `sub_area` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cedula` (`cedula`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `responsables_inventario`
--

LOCK TABLES `responsables_inventario` WRITE;
/*!40000 ALTER TABLE `responsables_inventario` DISABLE KEYS */;
INSERT INTO `responsables_inventario` VALUES (1,'Mauricio Devia','17360557','auxiliar it','Direccion financiera','sistemas'),(2,'Felix Barraza','1001787805','auxiliar it','Direccion financiera','sistemas'),(3,'Juan Felipe Henao','87942226','Lider it','Direccion financiera','sistemas');
/*!40000 ALTER TABLE `responsables_inventario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sim_cards`
--

DROP TABLE IF EXISTS `sim_cards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sim_cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cedula` varchar(20) DEFAULT NULL,
  `dispositivo` varchar(50) DEFAULT NULL,
  `linea_celular` varchar(50) DEFAULT NULL,
  `fecha_compra` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cedula` (`cedula`),
  CONSTRAINT `sim_cards_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `empleados` (`cedula`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sim_cards`
--

LOCK TABLES `sim_cards` WRITE;
/*!40000 ALTER TABLE `sim_cards` DISABLE KEYS */;
INSERT INTO `sim_cards` VALUES (1,'1121831496','celular','3025143566',NULL),(2,'41242379','celular','3123462985',NULL),(5,'214151251','celular','124126723266','2025-03-12');
/*!40000 ALTER TABLE `sim_cards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) DEFAULT NULL,
  `contrasena` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'admin_sistemas','$2y$10$RU0PrG6lP3GeEIDUmgLWnef2FAMOHIRaY7vR4wFkR0RDiA5jvjxVK');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'inventario_sistemas'
--

--
-- Dumping routines for database 'inventario_sistemas'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-12 16:25:27
