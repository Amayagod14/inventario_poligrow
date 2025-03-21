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
  `fecha_entrega` date DEFAULT NULL,
  `fecha_compra` date DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cedula` (`cedula`),
  CONSTRAINT `celulares_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `empleados` (`cedula`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;



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
  `fecha_entrega` date DEFAULT NULL,
  `fecha_compra` date DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cedula` (`cedula`),
  CONSTRAINT `computadores_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `empleados` (`cedula`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;


DROP TABLE IF EXISTS `dispositivos_dados_de_baja`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dispositivos_dados_de_baja` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_dispositivo` varchar(50) NOT NULL,
  `id_dispositivo` int(11) NOT NULL,
  `cedula` varchar(20) DEFAULT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `serial` varchar(50) DEFAULT NULL,
  `imei` varchar(50) DEFAULT NULL,
  `placa_activos` varchar(50) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `mac` varchar(50) DEFAULT NULL,
  `ram` varchar(20) DEFAULT NULL,
  `estado_entrega` varchar(50) DEFAULT NULL,
  `disco_duro` varchar(50) DEFAULT NULL,
  `cuenta_email` varchar(100) DEFAULT NULL,
  `referencia` varchar(50) DEFAULT NULL,
  `placa_activos_fijos` varchar(50) DEFAULT NULL,
  `dispositivo` varchar(50) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `linea_celular` varchar(50) DEFAULT NULL,
  `fecha_compra` date DEFAULT NULL,
  `fecha_baja` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cedula` (`cedula`),
  CONSTRAINT `dispositivos_dados_de_baja_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `empleados` (`cedula`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;



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
  `fecha_entrega` date DEFAULT NULL,
  `fecha_compra` date DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cedula` (`cedula`),
  CONSTRAINT `impresoras_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `empleados` (`cedula`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;



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
  `fecha_entrega` date DEFAULT NULL,
  `fecha_compra` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cedula` (`cedula`),
  CONSTRAINT `radios_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `empleados` (`cedula`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;



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
  `fecha_entrega` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cedula` (`cedula`),
  CONSTRAINT `sim_cards_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `empleados` (`cedula`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;





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
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-21 12:37:29
