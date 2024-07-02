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
-- Table structure for table `SCHOOLS`
--

DROP TABLE IF EXISTS `SCHOOLS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `SCHOOLS` (
  `idSchool` int(11) NOT NULL AUTO_INCREMENT,
  `nameSchool` varchar(250) NOT NULL,
  PRIMARY KEY (`idSchool`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `FAVORIS`
--

DROP TABLE IF EXISTS `FAVORIS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `FAVORIS` (
  `idFavoris` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` int(11) NOT NULL,
  `idSneaker` int(11) NOT NULL,
  PRIMARY KEY (`idFavoris`),
  KEY `FAVORIS_FK` (`idUser`),
  KEY `FAVORIS_FK_1` (`idSneaker`),
  CONSTRAINT `FAVORIS_FK` FOREIGN KEY (`idUser`) REFERENCES `USERS` (`idUser`) ON DELETE CASCADE,
  CONSTRAINT `FAVORIS_FK_1` FOREIGN KEY (`idSneaker`) REFERENCES `SNEAKERS` (`idSneaker`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `MARQUES`
--

DROP TABLE IF EXISTS `MARQUES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `MARQUES` (
  `idMarque` int(11) NOT NULL AUTO_INCREMENT,
  `nameBrand` varchar(250) NOT NULL,
  PRIMARY KEY (`idMarque`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `MODELE`
--

DROP TABLE IF EXISTS `MODELE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `MODELE` (
  `idModele` int(11) NOT NULL AUTO_INCREMENT,
  `nameModel` varchar(250) NOT NULL,
  PRIMARY KEY (`idModele`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PTRENCONTRE`
--

DROP TABLE IF EXISTS `PTRENCONTRE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `PTRENCONTRE` (
  `idMeetPoint` int(11) NOT NULL AUTO_INCREMENT,
  `nomMeetPoint` varchar(250) NOT NULL,
  `adressMeetPoint` varchar(250) NOT NULL,
  `descriptionMeetPoint` varchar(250) NOT NULL,
  `dateHourMeetPlace` datetime NOT NULL,
  PRIMARY KEY (`idMeetPoint`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ROLES`
--

DROP TABLE IF EXISTS `ROLES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ROLES` (
  `idRole` int(11) NOT NULL AUTO_INCREMENT,
  `nomRole` varchar(100) NOT NULL,
  PRIMARY KEY (`idRole`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
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
  `prixSneaker` double NOT NULL DEFAULT 0,
  `imgSneaker` longtext DEFAULT 'notFound',
  `descriptionSneaker` varchar(250) NOT NULL,
  `idSStatut` int(11) DEFAULT 1,
  `idMarque` int(11) NOT NULL,
  `idModele` int(11) NOT NULL,
  `idVisibilite` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idSneaker`),
  KEY `SNEAKERS_FK` (`idModele`),
  KEY `SNEAKERS_FK_1` (`idVisibilite`),
  KEY `SNEAKERS_FK_2` (`idSStatut`),
  KEY `SNEAKERS_FK_3` (`idMarque`),
  CONSTRAINT `SNEAKERS_FK` FOREIGN KEY (`idModele`) REFERENCES `MODELE` (`idModele`),
  CONSTRAINT `SNEAKERS_FK_1` FOREIGN KEY (`idVisibilite`) REFERENCES `VISIBILITE` (`idVisibilite`),
  CONSTRAINT `SNEAKERS_FK_2` FOREIGN KEY (`idSStatut`) REFERENCES `SSTATUT` (`idSStatut`),
  CONSTRAINT `SNEAKERS_FK_3` FOREIGN KEY (`idMarque`) REFERENCES `MARQUES` (`idMarque`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `SSTATUT`
--

DROP TABLE IF EXISTS `SSTATUT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `SSTATUT` (
  `idSStatut` int(11) NOT NULL AUTO_INCREMENT,
  `nomSStatut` varchar(250) NOT NULL,
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
  PRIMARY KEY (`idTransaction`),
  KEY `TRANSACTIONS_FK` (`idMeetPoint`),
  KEY `TRANSACTIONS_FK_1` (`idTStatut`),
  KEY `TRANSACTIONS_FK_3` (`idBuyer`),
  KEY `TRANSACTIONS_FK_4` (`idSeller`),
  KEY `TRANSACTIONS_FK_2` (`idSneaker`),
  CONSTRAINT `TRANSACTIONS_FK` FOREIGN KEY (`idMeetPoint`) REFERENCES `PTRENCONTRE` (`idMeetPoint`),
  CONSTRAINT `TRANSACTIONS_FK_1` FOREIGN KEY (`idTStatut`) REFERENCES `TSTATUT` (`idTStatut`),
  CONSTRAINT `TRANSACTIONS_FK_2` FOREIGN KEY (`idSneaker`) REFERENCES `SNEAKERS` (`idSneaker`) ON DELETE CASCADE,
  CONSTRAINT `TRANSACTIONS_FK_3` FOREIGN KEY (`idBuyer`) REFERENCES `USERS` (`idUser`),
  CONSTRAINT `TRANSACTIONS_FK_4` FOREIGN KEY (`idSeller`) REFERENCES `USERS` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `TSTATUT`
--

DROP TABLE IF EXISTS `TSTATUT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TSTATUT` (
  `idTStatut` int(11) NOT NULL AUTO_INCREMENT,
  `nomStatut` varchar(250) NOT NULL,
  PRIMARY KEY (`idTStatut`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `USTATUT`
--

DROP TABLE IF EXISTS `USTATUT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `USTATUT` (
  `idUStatut` int(11) NOT NULL AUTO_INCREMENT,
  `nomUStatut` varchar(250) NOT NULL,
  PRIMARY KEY (`idUStatut`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
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
  KEY `USERS_FK` (`idUStatut`),
  KEY `USERS_FK_1` (`idSchool`),
  KEY `USERS_FK_2` (`idRole`),
  CONSTRAINT `USERS_FK` FOREIGN KEY (`idUStatut`) REFERENCES `USTATUT` (`idUStatut`),
  CONSTRAINT `USERS_FK_1` FOREIGN KEY (`idSchool`) REFERENCES `SCHOOLS` (`idSchool`),
  CONSTRAINT `USERS_FK_2` FOREIGN KEY (`idRole`) REFERENCES `ROLES` (`idRole`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
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
 1 AS `prixSneaker`,
 1 AS `imgSneaker`,
 1 AS `descriptionSneaker`,
 1 AS `nomSStatut`,
 1 AS `nameBrand`,
 1 AS `nameModel`,
 1 AS `nomVisibilite`*/;
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
 1 AS `prixSneaker`,
 1 AS `imgSneaker`,
 1 AS `descriptionSneaker`,
 1 AS `nameSStatut`,
 1 AS `idMarque`,
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
 1 AS `statutVendeur`,
 1 AS `imgSeller`,
 1 AS `adressMeetPoint`,
 1 AS `dateHourMeetPlace`,
 1 AS `nameStatut`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `VIEW_USERS`
--

DROP TABLE IF EXISTS `VIEW_USERS`;
/*!50001 DROP VIEW IF EXISTS `VIEW_USERS`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `VIEW_USERS` AS SELECT 
 1 AS `idUser`,
 1 AS `nameUser`,
 1 AS `surnameUser`,
 1 AS `emailUser`,
 1 AS `pwdUser`,
 1 AS `nameSchool`,
 1 AS `nomUStatut`,
 1 AS `nomRole`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `VISIBILITE`
--

DROP TABLE IF EXISTS `VISIBILITE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `VISIBILITE` (
  `idVisibilite` int(11) NOT NULL AUTO_INCREMENT,
  `nomVisibilite` varchar(250) NOT NULL,
  PRIMARY KEY (`idVisibilite`)
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
/*!50001 VIEW `VIEW_SNEAKERS` AS select `SNEAKERS`.`idSneaker` AS `idSneaker`,`SNEAKERS`.`sizeSneaker` AS `sizeSneaker`,`SNEAKERS`.`prixSneaker` AS `prixSneaker`,`SNEAKERS`.`imgSneaker` AS `imgSneaker`,`SNEAKERS`.`descriptionSneaker` AS `descriptionSneaker`,`SSTATUT`.`nomSStatut` AS `nomSStatut`,`MARQUES`.`nameBrand` AS `nameBrand`,`MODELE`.`nameModel` AS `nameModel`,`VISIBILITE`.`nomVisibilite` AS `nomVisibilite` from ((((`SNEAKERS` join `SSTATUT`) join `MARQUES`) join `MODELE`) join `VISIBILITE`) where `SNEAKERS`.`idSStatut` = `SSTATUT`.`idSStatut` and `SNEAKERS`.`idMarque` = `MARQUES`.`idMarque` and `SNEAKERS`.`idModele` = `MODELE`.`idModele` and `SNEAKERS`.`idVisibilite` = `VISIBILITE`.`idVisibilite` */;
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
/*!50001 VIEW `VIEW_TRANSACTIONS` AS select `T`.`idTransaction` AS `idTransaction`,`S`.`idSneaker` AS `idSneaker`,`S`.`sizeSneaker` AS `sizeSneaker`,`S`.`prixSneaker` AS `prixSneaker`,`S`.`imgSneaker` AS `imgSneaker`,`S`.`descriptionSneaker` AS `descriptionSneaker`,`MS`.`nomSStatut` AS `nameSStatut`,`M`.`idMarque` AS `idMarque`,`M`.`nameBrand` AS `nameBrand`,`MO`.`nameModel` AS `nameModel`,`V`.`nomVisibilite` AS `nameVisibility`,`UU`.`idUser` AS `idBuyer`,`UU`.`nameUser` AS `nameBuyer`,`UU`.`surnameUser` AS `surnameBuyer`,`UU`.`emailUser` AS `emailBuyer`,`UU`.`imgUser` AS `imgBuyer`,`UV`.`idUser` AS `idSeller`,`UV`.`nameUser` AS `nameSeller`,`UV`.`surnameUser` AS `surnameSeller`,`UV`.`emailUser` AS `emailSeller`,`UV`.`idUStatut` AS `statutVendeur`,`UV`.`imgUser` AS `imgSeller`,`PT`.`adressMeetPoint` AS `adressMeetPoint`,`PT`.`dateHourMeetPlace` AS `dateHourMeetPlace`,`TS`.`nomStatut` AS `nameStatut` from (((((((((`TRANSACTIONS` `T` left join `SNEAKERS` `S` on(`T`.`idSneaker` = `S`.`idSneaker`)) left join `SSTATUT` `MS` on(`S`.`idSStatut` = `MS`.`idSStatut`)) left join `MARQUES` `M` on(`S`.`idMarque` = `M`.`idMarque`)) left join `MODELE` `MO` on(`S`.`idModele` = `MO`.`idModele`)) left join `VISIBILITE` `V` on(`S`.`idVisibilite` = `V`.`idVisibilite`)) left join `USERS` `UU` on(`T`.`idBuyer` = `UU`.`idUser`)) left join `USERS` `UV` on(`T`.`idSeller` = `UV`.`idUser`)) left join `PTRENCONTRE` `PT` on(`T`.`idMeetPoint` = `PT`.`idMeetPoint`)) left join `TSTATUT` `TS` on(`T`.`idTStatut` = `TS`.`idTStatut`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `VIEW_USERS`
--

/*!50001 DROP VIEW IF EXISTS `VIEW_USERS`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`dbeaver_admin`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `VIEW_USERS` AS select `USERS`.`idUser` AS `idUser`,`USERS`.`nameUser` AS `nameUser`,`USERS`.`surnameUser` AS `surnameUser`,`USERS`.`emailUser` AS `emailUser`,`USERS`.`pwdUser` AS `pwdUser`,`SCHOOLS`.`nameSchool` AS `nameSchool`,`USTATUT`.`nomUStatut` AS `nomUStatut`,`ROLES`.`nomRole` AS `nomRole` from (((`USERS` join `SCHOOLS`) join `USTATUT`) join `ROLES`) where `USERS`.`idSchool` = `SCHOOLS`.`idSchool` and `USERS`.`idUStatut` = `USTATUT`.`idUStatut` and `USERS`.`idRole` = `ROLES`.`idRole` */;
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

-- Dump completed on 2024-05-02 16:39:29
