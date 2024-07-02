-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: SneakersMarket
-- ------------------------------------------------------
-- Server version	5.5.5-10.6.12-MariaDB-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `BRANDS`
--

DROP TABLE IF EXISTS `BRANDS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `BRANDS` (
  `idBrand` int(11) NOT NULL AUTO_INCREMENT,
  `nameBrand` varchar(250) NOT NULL,
  PRIMARY KEY (`idBrand`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `DATEMEETPLACE`
--

DROP TABLE IF EXISTS `DATEMEETPLACE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `DATEMEETPLACE` (
  `idDateMeetPlace` int(11) NOT NULL AUTO_INCREMENT,
  `idMeetPoint` int(11) NOT NULL,
  `dateHourMeetPlace` datetime DEFAULT NULL,
  PRIMARY KEY (`idDateMeetPlace`),
  KEY `DATEMEETPLACE_FK` (`idMeetPoint`),
  CONSTRAINT `DATEMEETPLACE_FK` FOREIGN KEY (`idMeetPoint`) REFERENCES `MEETPOINTS` (`idMeetPoint`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `FAVORITES`
--

DROP TABLE IF EXISTS `FAVORITES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `FAVORITES` (
  `idFavorite` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` int(11) NOT NULL,
  `idSneaker` int(11) NOT NULL,
  PRIMARY KEY (`idFavorite`),
  KEY `FAVORIS_FK` (`idUser`),
  KEY `FAVORIS_FK_1` (`idSneaker`),
  CONSTRAINT `FAVORIS_FK` FOREIGN KEY (`idUser`) REFERENCES `USERS` (`idUser`) ON DELETE CASCADE,
  CONSTRAINT `FAVORIS_FK_1` FOREIGN KEY (`idSneaker`) REFERENCES `SNEAKERS` (`idSneaker`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `MEETPOINTS`
--

DROP TABLE IF EXISTS `MEETPOINTS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `MEETPOINTS` (
  `idMeetPoint` int(11) NOT NULL AUTO_INCREMENT,
  `nameMeetPoint` varchar(250) NOT NULL,
  `adressMeetPoint` varchar(250) NOT NULL,
  `descriptionMeetPoint` varchar(250) NOT NULL,
  PRIMARY KEY (`idMeetPoint`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `MODELS`
--

DROP TABLE IF EXISTS `MODELS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `MODELS` (
  `idModel` int(11) NOT NULL AUTO_INCREMENT,
  `nameModel` varchar(250) NOT NULL,
  PRIMARY KEY (`idModel`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ROLES`
--

DROP TABLE IF EXISTS `ROLES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ROLES` (
  `idRole` int(11) NOT NULL AUTO_INCREMENT,
  `nameRole` varchar(100) NOT NULL,
  PRIMARY KEY (`idRole`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `SCHOOLS`
--

DROP TABLE IF EXISTS `SCHOOLS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `SCHOOLS` (
  `idSchool` int(11) NOT NULL AUTO_INCREMENT,
  `nameSchool` varchar(250) NOT NULL,
  PRIMARY KEY (`idSchool`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `SNEAKERS`
--

DROP TABLE IF EXISTS `SNEAKERS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `SNEAKERS` (
  `idSneaker` int(11) NOT NULL AUTO_INCREMENT,
  `sizeSneaker` int(11) NOT NULL,
  `priceSneaker` double NOT NULL DEFAULT 0,
  `imgSneaker` longtext DEFAULT 'notFound',
  `descriptionSneaker` varchar(250) NOT NULL,
  `idSStatut` int(11) DEFAULT 1,
  `idBrand` int(11) NOT NULL,
  `idModel` int(11) NOT NULL,
  `idVisibility` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idSneaker`),
  KEY `SNEAKERS_FK` (`idModel`),
  KEY `SNEAKERS_FK_1` (`idVisibility`),
  KEY `SNEAKERS_FK_2` (`idSStatut`),
  KEY `SNEAKERS_FK_3` (`idBrand`),
  CONSTRAINT `SNEAKERS_FK` FOREIGN KEY (`idModel`) REFERENCES `MODELS` (`idModel`),
  CONSTRAINT `SNEAKERS_FK_1` FOREIGN KEY (`idVisibility`) REFERENCES `VISIBILITY` (`idVisibility`),
  CONSTRAINT `SNEAKERS_FK_2` FOREIGN KEY (`idSStatut`) REFERENCES `SSTATUT` (`idSStatut`),
  CONSTRAINT `SNEAKERS_FK_3` FOREIGN KEY (`idBrand`) REFERENCES `BRANDS` (`idBrand`)
) ENGINE=InnoDB AUTO_INCREMENT=187 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `SSTATUT`
--

DROP TABLE IF EXISTS `SSTATUT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `SSTATUT` (
  `idSStatut` int(11) NOT NULL AUTO_INCREMENT,
  `nameSStatut` varchar(250) NOT NULL,
  PRIMARY KEY (`idSStatut`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TRANSACTIONS`
--

DROP TABLE IF EXISTS `TRANSACTIONS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TRANSACTIONS` (
  `idTransaction` int(11) NOT NULL AUTO_INCREMENT,
  `idSneaker` int(11) NOT NULL,
  `idBuyer` int(11) DEFAULT NULL,
  `idSeller` int(11) NOT NULL,
  `idTStatut` int(11) DEFAULT 1,
  `idMeetPoint` int(11) DEFAULT NULL,
  `idDateMeetPlace` int(11) DEFAULT NULL,
  PRIMARY KEY (`idTransaction`),
  KEY `TRANSACTIONS_FK` (`idMeetPoint`),
  KEY `TRANSACTIONS_FK_1` (`idTStatut`),
  KEY `TRANSACTIONS_FK_3` (`idBuyer`),
  KEY `TRANSACTIONS_FK_2` (`idSneaker`),
  KEY `TRANSACTIONS_FK_5` (`idDateMeetPlace`),
  KEY `TRANSACTIONS_FK_4` (`idSeller`),
  CONSTRAINT `TRANSACTIONS_FK` FOREIGN KEY (`idMeetPoint`) REFERENCES `MEETPOINTS` (`idMeetPoint`),
  CONSTRAINT `TRANSACTIONS_FK_1` FOREIGN KEY (`idTStatut`) REFERENCES `TSTATUT` (`idTStatut`),
  CONSTRAINT `TRANSACTIONS_FK_2` FOREIGN KEY (`idSneaker`) REFERENCES `SNEAKERS` (`idSneaker`) ON DELETE CASCADE,
  CONSTRAINT `TRANSACTIONS_FK_3` FOREIGN KEY (`idBuyer`) REFERENCES `USERS` (`idUser`),
  CONSTRAINT `TRANSACTIONS_FK_4` FOREIGN KEY (`idSeller`) REFERENCES `USERS` (`idUser`) ON DELETE CASCADE,
  CONSTRAINT `TRANSACTIONS_FK_5` FOREIGN KEY (`idDateMeetPlace`) REFERENCES `DATEMEETPLACE` (`idDateMeetPlace`)
) ENGINE=InnoDB AUTO_INCREMENT=300 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TSTATUT`
--

DROP TABLE IF EXISTS `TSTATUT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TSTATUT` (
  `idTStatut` int(11) NOT NULL AUTO_INCREMENT,
  `nameStatut` varchar(250) NOT NULL,
  PRIMARY KEY (`idTStatut`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `USERS`
--

DROP TABLE IF EXISTS `USERS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `USERS` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `nameUser` varchar(250) NOT NULL,
  `surnameUser` varchar(250) NOT NULL,
  `emailUser` varchar(250) NOT NULL,
  `pwdUser` varchar(250) NOT NULL,
  `idSchool` int(11) NOT NULL,
  `idUStatut` int(11) NOT NULL DEFAULT 1,
  `imgUser` longtext DEFAULT '',
  `idRole` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idUser`),
  KEY `UTILISATEURS_FK` (`idUStatut`),
  KEY `UTILISATEURS_FK_1` (`idSchool`),
  KEY `UTILISATEURS_FK_2` (`idRole`),
  CONSTRAINT `UTILISATEURS_FK` FOREIGN KEY (`idUStatut`) REFERENCES `USTATUT` (`idUStatut`),
  CONSTRAINT `UTILISATEURS_FK_1` FOREIGN KEY (`idSchool`) REFERENCES `SCHOOLS` (`idSchool`),
  CONSTRAINT `UTILISATEURS_FK_2` FOREIGN KEY (`idRole`) REFERENCES `ROLES` (`idRole`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `USTATUT`
--

DROP TABLE IF EXISTS `USTATUT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `USTATUT` (
  `idUStatut` int(11) NOT NULL AUTO_INCREMENT,
  `nameUStatut` varchar(250) NOT NULL,
  PRIMARY KEY (`idUStatut`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary view structure for view `VIEW_SNEAKERS`
--

DROP TABLE IF EXISTS `VIEW_SNEAKERS`;
/*!50001 DROP VIEW IF EXISTS `VIEW_SNEAKERS`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `VIEW_SNEAKERS` AS SELECT 
 1 AS `idSneaker`,
 1 AS `sizeSneaker`,
 1 AS `priceSneaker`,
 1 AS `imgSneaker`,
 1 AS `descriptionSneaker`,
 1 AS `nameSStatut`,
 1 AS `nameBrand`,
 1 AS `nameModel`,
 1 AS `nameVisibility`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `VIEW_TRANSACTIONS`
--

DROP TABLE IF EXISTS `VIEW_TRANSACTIONS`;
/*!50001 DROP VIEW IF EXISTS `VIEW_TRANSACTIONS`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `VIEW_TRANSACTIONS` AS SELECT 
 1 AS `idTransaction`,
 1 AS `idSneaker`,
 1 AS `sizeSneaker`,
 1 AS `priceSneaker`,
 1 AS `imgSneaker`,
 1 AS `descriptionSneaker`,
 1 AS `nameSStatut`,
 1 AS `idBrand`,
 1 AS `nameBrand`,
 1 AS `nameModel`,
 1 AS `nameVisibility`,
 1 AS `idBuyer`,
 1 AS `nameBuyer`,
 1 AS `surnameBuyer`,
 1 AS `emailBuyer`,
 1 AS `imgBuyer`,
 1 AS `idSeller`,
 1 AS `nameSeller`,
 1 AS `surnameSeller`,
 1 AS `emailSeller`,
 1 AS `statutSeller`,
 1 AS `imgSeller`,
 1 AS `adressMeetPoint`,
 1 AS `dateHourMeetPlace`,
 1 AS `nameStatut`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `VIEW_UTILISATEURS`
--

DROP TABLE IF EXISTS `VIEW_UTILISATEURS`;
/*!50001 DROP VIEW IF EXISTS `VIEW_UTILISATEURS`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `VIEW_UTILISATEURS` AS SELECT 
 1 AS `idUser`,
 1 AS `nameUser`,
 1 AS `surnameUser`,
 1 AS `emailUser`,
 1 AS `pwdUser`,
 1 AS `nameSchool`,
 1 AS `nameUStatut`,
 1 AS `nameRole`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `VISIBILITY`
--

DROP TABLE IF EXISTS `VISIBILITY`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `VISIBILITY` (
  `idVisibility` int(11) NOT NULL AUTO_INCREMENT,
  `nameVisibility` varchar(250) NOT NULL,
  PRIMARY KEY (`idVisibility`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database 'SneakersMarket'
--

--
-- Final view structure for view `VIEW_SNEAKERS`
--

/*!50001 DROP VIEW IF EXISTS `VIEW_SNEAKERS`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`dbeaver_admin`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `VIEW_SNEAKERS` AS select `SNEAKERS`.`idSneaker` AS `idSneaker`,`SNEAKERS`.`sizeSneaker` AS `sizeSneaker`,`SNEAKERS`.`priceSneaker` AS `priceSneaker`,`SNEAKERS`.`imgSneaker` AS `imgSneaker`,`SNEAKERS`.`descriptionSneaker` AS `descriptionSneaker`,`SSTATUT`.`nameSStatut` AS `nameSStatut`,`BRANDS`.`nameBrand` AS `nameBrand`,`MODELS`.`nameModel` AS `nameModel`,`VISIBILITY`.`nameVisibility` AS `nameVisibility` from ((((`SNEAKERS` join `SSTATUT`) join `BRANDS`) join `MODELS`) join `VISIBILITY`) where `SNEAKERS`.`idSStatut` = `SSTATUT`.`idSStatut` and `SNEAKERS`.`idBrand` = `BRANDS`.`idBrand` and `SNEAKERS`.`idModel` = `MODELS`.`idModel` and `SNEAKERS`.`idVisibility` = `VISIBILITY`.`idVisibility` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `VIEW_TRANSACTIONS`
--

/*!50001 DROP VIEW IF EXISTS `VIEW_TRANSACTIONS`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`dbeaver_admin`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `VIEW_TRANSACTIONS` AS select distinct `T`.`idTransaction` AS `idTransaction`,`S`.`idSneaker` AS `idSneaker`,`S`.`sizeSneaker` AS `sizeSneaker`,`S`.`priceSneaker` AS `priceSneaker`,`S`.`imgSneaker` AS `imgSneaker`,`S`.`descriptionSneaker` AS `descriptionSneaker`,`MS`.`nameSStatut` AS `nameSStatut`,`M`.`idBrand` AS `idBrand`,`M`.`nameBrand` AS `nameBrand`,`MO`.`nameModel` AS `nameModel`,`V`.`nameVisibility` AS `nameVisibility`,`UU`.`idUser` AS `idBuyer`,`UU`.`nameUser` AS `nameBuyer`,`UU`.`surnameUser` AS `surnameBuyer`,`UU`.`emailUser` AS `emailBuyer`,`UU`.`imgUser` AS `imgBuyer`,`UV`.`idUser` AS `idSeller`,`UV`.`nameUser` AS `nameSeller`,`UV`.`surnameUser` AS `surnameSeller`,`UV`.`emailUser` AS `emailSeller`,`UV`.`idUStatut` AS `statutSeller`,`UV`.`imgUser` AS `imgSeller`,`PT`.`adressMeetPoint` AS `adressMeetPoint`,`MP`.`dateHourMeetPlace` AS `dateHourMeetPlace`,`TS`.`nameStatut` AS `nameStatut` from ((((((((((`TRANSACTIONS` `T` left join `SNEAKERS` `S` on(`T`.`idSneaker` = `S`.`idSneaker`)) left join `SSTATUT` `MS` on(`S`.`idSStatut` = `MS`.`idSStatut`)) left join `BRANDS` `M` on(`S`.`idBrand` = `M`.`idBrand`)) left join `MODELS` `MO` on(`S`.`idModel` = `MO`.`idModel`)) left join `VISIBILITY` `V` on(`S`.`idVisibility` = `V`.`idVisibility`)) left join `USERS` `UU` on(`T`.`idBuyer` = `UU`.`idUser`)) left join `USERS` `UV` on(`T`.`idSeller` = `UV`.`idUser`)) left join `MEETPOINTS` `PT` on(`T`.`idMeetPoint` = `PT`.`idMeetPoint`)) left join `TSTATUT` `TS` on(`T`.`idTStatut` = `TS`.`idTStatut`)) left join `DATEMEETPLACE` `MP` on(`T`.`idMeetPoint` = `MP`.`idMeetPoint`)) group by `T`.`idTransaction` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `VIEW_UTILISATEURS`
--

/*!50001 DROP VIEW IF EXISTS `VIEW_UTILISATEURS`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`dbeaver_admin`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `VIEW_UTILISATEURS` AS select `USERS`.`idUser` AS `idUser`,`USERS`.`nameUser` AS `nameUser`,`USERS`.`surnameUser` AS `surnameUser`,`USERS`.`emailUser` AS `emailUser`,`USERS`.`pwdUser` AS `pwdUser`,`SCHOOLS`.`nameSchool` AS `nameSchool`,`USTATUT`.`nameUStatut` AS `nameUStatut`,`ROLES`.`nameRole` AS `nameRole` from (((`USERS` join `SCHOOLS`) join `USTATUT`) join `ROLES`) where `USERS`.`idSchool` = `SCHOOLS`.`idSchool` and `USERS`.`idUStatut` = `USTATUT`.`idUStatut` and `USERS`.`idRole` = `ROLES`.`idRole` */;
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

-- Dump completed on 2024-05-15 13:03:25
