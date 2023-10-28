CREATE DATABASE  IF NOT EXISTS `teccam` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `teccam`;
-- MySQL dump 10.13  Distrib 8.0.32, for Win64 (x86_64)
--
-- Host: 192.168.81.21    Database: teccam
-- ------------------------------------------------------
-- Server version	5.6.40

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
-- Table structure for table `ajax`
--

DROP TABLE IF EXISTS `ajax`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ajax` (
  `ax_id` int(11) NOT NULL AUTO_INCREMENT,
  `ax_nombre` varchar(95) NOT NULL,
  `ax_codigo` varchar(2048) NOT NULL,
  PRIMARY KEY (`ax_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ajax_srv`
--

DROP TABLE IF EXISTS `ajax_srv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ajax_srv` (
  `ax_id` int(11) NOT NULL AUTO_INCREMENT,
  `ax_nombre` varchar(95) NOT NULL,
  `ax_codigo` varchar(2048) NOT NULL,
  PRIMARY KEY (`ax_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cable_modem_docsis`
--

DROP TABLE IF EXISTS `cable_modem_docsis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cable_modem_docsis` (
  `cmd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cmd_modelo` varchar(45) NOT NULL,
  `cmd_firmware` varchar(200) DEFAULT NULL,
  `cmd_firmware2` varchar(200) DEFAULT NULL,
  `cmd_firmware_file` varchar(200) DEFAULT NULL,
  `cmd_firmware_file2` varchar(200) DEFAULT NULL,
  `emp_id` int(11) NOT NULL,
  `cmd_wifi_5g` int(11) NOT NULL DEFAULT '0',
  `cmd_wifi_2g` int(11) NOT NULL DEFAULT '1',
  `cmd_mta` int(11) NOT NULL DEFAULT '0',
  `cmd_oid1` varchar(145) DEFAULT NULL,
  `cmd_oid1_value` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cmd_id`),
  UNIQUE KEY `cmd_id_UNIQUE` (`cmd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `constantes`
--

DROP TABLE IF EXISTS `constantes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `constantes` (
  `nombre` varchar(45) DEFAULT NULL,
  `cmts` varchar(45) DEFAULT NULL,
  `vlan` varchar(45) DEFAULT NULL,
  `usu_id` int(11) DEFAULT NULL,
  `cmts2` varchar(45) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary view structure for view `dhcp_vista`
--

DROP TABLE IF EXISTS `dhcp_vista`;
/*!50001 DROP VIEW IF EXISTS `dhcp_vista`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `dhcp_vista` AS SELECT 
 1 AS `ID`,
 1 AS `ReceivedAt`,
 1 AS `DeviceReportedTime`,
 1 AS `Priority`,
 1 AS `Message`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `docsis`
--

DROP TABLE IF EXISTS `docsis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `docsis` (
  `d_id` int(11) NOT NULL AUTO_INCREMENT,
  `mac_docsis` varchar(45) DEFAULT NULL,
  `ip_docsis` varchar(45) DEFAULT NULL,
  `cmts_rx_power` varchar(45) DEFAULT NULL,
  `cmts_snr` varchar(45) DEFAULT NULL,
  `microreflexiones` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `version_docsis` varchar(45) DEFAULT NULL,
  `ip_host` varchar(45) DEFAULT NULL,
  `d_fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`d_id`),
  KEY `in_fecha` (`d_fecha`),
  KEY `in_mac` (`mac_docsis`),
  KEY `in_ip_docsis` (`ip_docsis`),
  KEY `in_host` (`ip_host`)
) ENGINE=MyISAM AUTO_INCREMENT=17033179 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `empresas`
--

DROP TABLE IF EXISTS `empresas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empresas` (
  `emp_id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_razon_social` varchar(45) NOT NULL,
  `emp_cuit` char(13) NOT NULL,
  `emp_direccion` varchar(250) DEFAULT NULL,
  `emp_telefono` varchar(45) DEFAULT NULL,
  `emp_categoria` varchar(5) DEFAULT NULL,
  `emp_email` varchar(80) DEFAULT NULL,
  `emp_web` varchar(80) DEFAULT NULL,
  `emp_contacto_comercial` varchar(120) DEFAULT NULL,
  `emp_tel_cc` varchar(45) DEFAULT NULL,
  `emp_email_cc` varchar(80) DEFAULT NULL,
  `emp_contacto_administrativo` varchar(120) DEFAULT NULL,
  `emp_tel_ca` varchar(45) DEFAULT NULL,
  `emp_email_ca` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`emp_id`,`emp_razon_social`,`emp_cuit`)
) ENGINE=MyISAM AUTO_INCREMENT=344 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `evento`
--

DROP TABLE IF EXISTS `evento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `evento` (
  `ev_id` int(11) NOT NULL AUTO_INCREMENT,
  `ev_activo` int(11) NOT NULL DEFAULT '0',
  `ax_id` int(11) NOT NULL DEFAULT '1',
  `ev_fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usu_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`ev_id`)
) ENGINE=MyISAM AUTO_INCREMENT=609959 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `evento_srv`
--

DROP TABLE IF EXISTS `evento_srv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `evento_srv` (
  `ev_id` int(11) NOT NULL AUTO_INCREMENT,
  `ev_activo` int(11) NOT NULL DEFAULT '0',
  `ax_id` int(11) NOT NULL DEFAULT '1',
  `ev_fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usu_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`ev_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lista_opers`
--

DROP TABLE IF EXISTS `lista_opers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lista_opers` (
  `lo_id` int(11) NOT NULL AUTO_INCREMENT,
  `lo_nombre` varchar(45) NOT NULL,
  `lo_ip` varchar(45) NOT NULL,
  `lo_vlan` varchar(45) NOT NULL,
  `usu_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`lo_id`)
) ENGINE=MyISAM AUTO_INCREMENT=181 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lista_srv`
--

DROP TABLE IF EXISTS `lista_srv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lista_srv` (
  `lo_id` int(11) NOT NULL AUTO_INCREMENT,
  `lo_nombre` varchar(45) NOT NULL,
  `lo_ip` varchar(45) NOT NULL,
  `lo_vlan` varchar(45) NOT NULL,
  `usu_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`lo_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lote_prueba`
--

DROP TABLE IF EXISTS `lote_prueba`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lote_prueba` (
  `lp_id` int(11) NOT NULL AUTO_INCREMENT,
  `p_id` int(11) NOT NULL,
  `lo_id` int(11) NOT NULL,
  `lp_fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cli_usuario` varchar(45) NOT NULL,
  `ps_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`lp_id`),
  KEY `fk_prueba_idx` (`p_id`),
  CONSTRAINT `fk_prueba` FOREIGN KEY (`p_id`) REFERENCES `prueba` (`p_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=121757 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prueba`
--

DROP TABLE IF EXISTS `prueba`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prueba` (
  `p_id` int(11) NOT NULL AUTO_INCREMENT,
  `tp_id` int(11) NOT NULL,
  `p_fecha_inicio` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cli_usuario` varchar(45) DEFAULT NULL,
  `p_fecha_final` datetime DEFAULT NULL,
  `p_habilitado` int(11) NOT NULL DEFAULT '1',
  `stk_id` int(11) DEFAULT NULL,
  `p_cc` int(11) NOT NULL DEFAULT '0',
  `p_cant_ether` int(11) NOT NULL DEFAULT '4',
  `p_plataforma_nro` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`p_id`),
  KEY `index2` (`p_fecha_inicio`),
  KEY `index3` (`p_fecha_final`),
  KEY `fk_tp_idx` (`tp_id`),
  KEY `index5` (`cli_usuario`),
  KEY `index6` (`stk_id`),
  CONSTRAINT `fk_tp` FOREIGN KEY (`tp_id`) REFERENCES `tipo_prueba` (`tp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3476 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prueba_estado`
--

DROP TABLE IF EXISTS `prueba_estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prueba_estado` (
  `ps_id` int(11) NOT NULL AUTO_INCREMENT,
  `ps_nombre` varchar(45) NOT NULL,
  `ps_color` varchar(45) NOT NULL,
  PRIMARY KEY (`ps_id`),
  UNIQUE KEY `ps_id_UNIQUE` (`ps_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prueba_historico`
--

DROP TABLE IF EXISTS `prueba_historico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prueba_historico` (
  `ph_id` int(11) NOT NULL AUTO_INCREMENT,
  `lp_id` int(11) NOT NULL,
  `ps_id` int(11) NOT NULL,
  `ph_fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cli_usuario` varchar(45) NOT NULL,
  PRIMARY KEY (`ph_id`),
  UNIQUE KEY `ph_id_UNIQUE` (`ph_id`),
  KEY `fk_lpru_idx` (`lp_id`),
  KEY `index4` (`ph_fecha`),
  KEY `index5` (`cli_usuario`),
  KEY `fk_estado_idx` (`ps_id`),
  CONSTRAINT `fk_estado` FOREIGN KEY (`ps_id`) REFERENCES `prueba_estado` (`ps_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_lpru` FOREIGN KEY (`lp_id`) REFERENCES `lote_prueba` (`lp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=357266 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prueba_resultados`
--

DROP TABLE IF EXISTS `prueba_resultados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prueba_resultados` (
  `pr_id` int(11) NOT NULL AUTO_INCREMENT,
  `p_id` int(11) NOT NULL,
  `lo_id` int(11) NOT NULL,
  `pr_descripcion` varchar(45) DEFAULT NULL,
  `pr_resultado` varchar(400) DEFAULT NULL,
  `pr_fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`pr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prueba_resultados_docsis`
--

DROP TABLE IF EXISTS `prueba_resultados_docsis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prueba_resultados_docsis` (
  `pr_id` int(11) NOT NULL AUTO_INCREMENT,
  `p_id` int(11) NOT NULL,
  `pl_id` int(11) NOT NULL,
  `pr_navega` varchar(2048) DEFAULT NULL,
  `pr_fecha_inicio` datetime DEFAULT NULL,
  `pr_mac_docsis` varchar(45) DEFAULT NULL,
  `pr_ip_docsis` varchar(45) DEFAULT NULL,
  `pr_cmts_rx_power` varchar(45) DEFAULT NULL,
  `pr_cmts_snr` varchar(45) DEFAULT NULL,
  `pr_microreflexiones` varchar(45) DEFAULT NULL,
  `pr_status` varchar(45) DEFAULT NULL,
  `pr_version_docsis` varchar(45) DEFAULT NULL,
  `pr_ip_host` varchar(45) DEFAULT NULL,
  `pr_modelo` varchar(200) DEFAULT NULL,
  `lstk_id` int(11) DEFAULT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `pr_serie` varchar(90) DEFAULT NULL,
  `pr_tx` varchar(45) DEFAULT NULL,
  `pr_rx` varchar(45) DEFAULT NULL,
  `pr_mer` varchar(45) DEFAULT NULL,
  `pr_frec_ds` varchar(45) DEFAULT NULL,
  `pr_frec_us` varchar(45) DEFAULT NULL,
  `pr_sysname` varchar(90) DEFAULT NULL,
  `pr_sysdesc` varchar(300) DEFAULT NULL,
  `pr_result_test_velocidad` varchar(4096) DEFAULT NULL,
  `pr_wifi` varchar(1024) DEFAULT NULL,
  `pr_wifi_5g` varchar(1024) DEFAULT NULL,
  `pr_firmware` varchar(1024) DEFAULT NULL,
  `pr_mta` varchar(2048) DEFAULT NULL,
  `pr_fecha_final` datetime DEFAULT NULL,
  `pr_ot` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pr_id`),
  KEY `fecha` (`pr_fecha_inicio`),
  KEY `fk_pru_idx` (`p_id`),
  KEY `fk_plote_idx` (`pl_id`),
  CONSTRAINT `fk_plote` FOREIGN KEY (`pl_id`) REFERENCES `lote_prueba` (`lp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pru` FOREIGN KEY (`p_id`) REFERENCES `prueba` (`p_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=117067 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary view structure for view `prueba_resultados_docsis_vista`
--

DROP TABLE IF EXISTS `prueba_resultados_docsis_vista`;
/*!50001 DROP VIEW IF EXISTS `prueba_resultados_docsis_vista`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `prueba_resultados_docsis_vista` AS SELECT 
 1 AS `pr_id`,
 1 AS `p_id`,
 1 AS `pl_id`,
 1 AS `lo_id`,
 1 AS `pr_navega`,
 1 AS `pr_fecha_inicio`,
 1 AS `pr_mac_docsis`,
 1 AS `pr_ip_docsis`,
 1 AS `pr_microreflexiones`,
 1 AS `pr_status`,
 1 AS `pr_version_docsis`,
 1 AS `pr_modelo`,
 1 AS `lstk_id`,
 1 AS `emp_id`,
 1 AS `pr_serie`,
 1 AS `pr_tx`,
 1 AS `pr_rx`,
 1 AS `pr_mer`,
 1 AS `pr_frec_ds`,
 1 AS `pr_frec_us`,
 1 AS `pr_result_test_velocidad`,
 1 AS `pr_wifi`,
 1 AS `pr_wifi_5g`,
 1 AS `pr_firmware`,
 1 AS `pr_mta`,
 1 AS `pr_fecha_final`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `tftp_vista`
--

DROP TABLE IF EXISTS `tftp_vista`;
/*!50001 DROP VIEW IF EXISTS `tftp_vista`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `tftp_vista` AS SELECT 
 1 AS `ID`,
 1 AS `ReceivedAt`,
 1 AS `DeviceReportedTime`,
 1 AS `Priority`,
 1 AS `Message`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `tipo_prueba`
--

DROP TABLE IF EXISTS `tipo_prueba`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_prueba` (
  `tp_id` int(11) NOT NULL AUTO_INCREMENT,
  `tp_nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`tp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping events for database 'teccam'
--
/*!50106 SET @save_time_zone= @@TIME_ZONE */ ;
/*!50106 DROP EVENT IF EXISTS `flushing_sql2` */;
DELIMITER ;;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;;
/*!50003 SET character_set_client  = utf8 */ ;;
/*!50003 SET character_set_results = utf8 */ ;;
/*!50003 SET collation_connection  = utf8_general_ci */ ;;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;;
/*!50003 SET @saved_time_zone      = @@time_zone */ ;;
/*!50003 SET time_zone             = 'SYSTEM' */ ;;
/*!50106 CREATE*/ /*!50117 DEFINER=`jlvillaronga`@`%`*/ /*!50106 EVENT `flushing_sql2` ON SCHEDULE EVERY 1 MINUTE STARTS '2019-04-23 11:22:36' ON COMPLETION NOT PRESERVE ENABLE DO flush hosts */ ;;
/*!50003 SET time_zone             = @saved_time_zone */ ;;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;;
/*!50003 SET character_set_client  = @saved_cs_client */ ;;
/*!50003 SET character_set_results = @saved_cs_results */ ;;
/*!50003 SET collation_connection  = @saved_col_connection */ ;;
DELIMITER ;
/*!50106 SET TIME_ZONE= @save_time_zone */ ;

--
-- Dumping routines for database 'teccam'
--

--
-- Final view structure for view `dhcp_vista`
--

/*!50001 DROP VIEW IF EXISTS `dhcp_vista`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `dhcp_vista` AS select `Syslog`.`SystemEvents`.`ID` AS `ID`,`Syslog`.`SystemEvents`.`ReceivedAt` AS `ReceivedAt`,`Syslog`.`SystemEvents`.`DeviceReportedTime` AS `DeviceReportedTime`,`Syslog`.`SystemEvents`.`Priority` AS `Priority`,`Syslog`.`SystemEvents`.`Message` AS `Message` from `Syslog`.`SystemEvents` where ((`Syslog`.`SystemEvents`.`SysLogTag` = 'dhcpd:') or (`Syslog`.`SystemEvents`.`SysLogTag` like '%tftp%')) order by `Syslog`.`SystemEvents`.`ID` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `prueba_resultados_docsis_vista`
--

/*!50001 DROP VIEW IF EXISTS `prueba_resultados_docsis_vista`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`jlvillaronga`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `prueba_resultados_docsis_vista` AS select `prd`.`pr_id` AS `pr_id`,`prd`.`p_id` AS `p_id`,`prd`.`pl_id` AS `pl_id`,`lp`.`lo_id` AS `lo_id`,`prd`.`pr_navega` AS `pr_navega`,`prd`.`pr_fecha_inicio` AS `pr_fecha_inicio`,`prd`.`pr_mac_docsis` AS `pr_mac_docsis`,`prd`.`pr_ip_docsis` AS `pr_ip_docsis`,`prd`.`pr_microreflexiones` AS `pr_microreflexiones`,`prd`.`pr_status` AS `pr_status`,`prd`.`pr_version_docsis` AS `pr_version_docsis`,`prd`.`pr_modelo` AS `pr_modelo`,`prd`.`lstk_id` AS `lstk_id`,`prd`.`emp_id` AS `emp_id`,`prd`.`pr_serie` AS `pr_serie`,`prd`.`pr_tx` AS `pr_tx`,`prd`.`pr_rx` AS `pr_rx`,`prd`.`pr_mer` AS `pr_mer`,`prd`.`pr_frec_ds` AS `pr_frec_ds`,`prd`.`pr_frec_us` AS `pr_frec_us`,`prd`.`pr_result_test_velocidad` AS `pr_result_test_velocidad`,`prd`.`pr_wifi` AS `pr_wifi`,`prd`.`pr_wifi_5g` AS `pr_wifi_5g`,`prd`.`pr_firmware` AS `pr_firmware`,`prd`.`pr_mta` AS `pr_mta`,`prd`.`pr_fecha_final` AS `pr_fecha_final` from (`prueba_resultados_docsis` `prd` join `lote_prueba` `lp`) where (`prd`.`pl_id` = `lp`.`lp_id`) order by `prd`.`pr_id` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `tftp_vista`
--

/*!50001 DROP VIEW IF EXISTS `tftp_vista`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `tftp_vista` AS select `dhcp_vista`.`ID` AS `ID`,`dhcp_vista`.`ReceivedAt` AS `ReceivedAt`,`dhcp_vista`.`DeviceReportedTime` AS `DeviceReportedTime`,`dhcp_vista`.`Priority` AS `Priority`,`dhcp_vista`.`Message` AS `Message` from `teccam`.`dhcp_vista` where (`dhcp_vista`.`Message` like '%filename%') */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-10-28  0:30:12
