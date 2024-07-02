<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
Projet : SneakersMarket (TPI)
Auteur : Léo Triano
Desc. : Site d'achat-revente de sneakers
Version : 1.0
Date : Mai 2024
Page : Modele de la page admin
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
class Admin
{
    /**
     * Récupère tous les utilisateurs de la base de données. Si on a recherché quelque chose, récupère tous les utilisateurs correspondant à la recherche
     *
     * @param string|null $searchBarUsers // string recherchée dans la barre de recherche
     * @param integer $indexFirst // [Pagination] index du premier utilisateur
     * @param integer $indexLast // [Pagination] index du dernier utilisateur
     * @return array // Tableau de User
     */
    function GetAllUsers(string|null $searchBarUsers, int $indexFirst, int $indexLast): array
    {
        $arr = array();

        // SI on a recherché quelque chose
        if ($searchBarUsers != "") {
            $s = "SELECT * FROM USERS WHERE nameUser LIKE CONCAT('%', :search, '%') OR surnameUser LIKE CONCAT('%', :search, '%') OR emailUser LIKE CONCAT('%', :search, '%') AND idRole = 1  ORDER BY idUser DESC LIMIT :indexFirst, :indexLast";
            $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            try {
                $statement->bindParam(':search', $searchBarUsers, PDO::PARAM_STR);
                $statement->bindParam(':indexFirst', $indexFirst, PDO::PARAM_INT);
                $statement->bindParam(':indexLast', $indexLast, PDO::PARAM_INT);
                $statement->execute();
            } catch (PDOException $e) {
                echo 'Problème de lecture de la base de données: ' . $e->getMessage();
            }

            while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
                $u = new User($row["idUser"], $row["nameUser"], $row["surnameUser"], $row["emailUser"], "", $row["idSchool"], $row["imgUser"]);
                array_push($arr, $u);
            }
        } else {
            $s = "SELECT * FROM USERS WHERE idRole = 1  ORDER BY idUser DESC LIMIT :indexFirst, :indexLast";
            $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            try {
                $statement->bindParam(':indexFirst', $indexFirst, PDO::PARAM_INT);
                $statement->bindParam(':indexLast', $indexLast, PDO::PARAM_INT);
                $statement->execute();
            } catch (PDOException $e) {
                echo 'Problème de lecture de la base de données: ' . $e->getMessage();
            }

            while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
                $u = new User($row["idUser"], $row["nameUser"], $row["surnameUser"], $row["emailUser"], "", $row["idSchool"], $row["imgUser"]);
                array_push($arr, $u);
            }
        }

        return $arr;
    }

    /**
     * Récupère l'école en fonction de son id
     *
     * @param integer $idSchool // id de l'école voulue
     * @return School // l'école en entier
     */
    function GetSchoolFromId(int $idSchool): School
    {
        $s = "SELECT * FROM SCHOOLS WHERE idSchool = :idSchool";
        $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        try {
            $statement->bindParam(':idSchool', $idSchool, PDO::PARAM_INT);
            $statement->execute();
        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
        }

        $row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);

        $u = new School($row["idSchool"], $row["nameSchool"]);

        return $u;
    }

    /**
     * Compte le nombre d'utilisateurs
     *
     * @param string|null $searchBarUsers // Si l'utilisateur a recherché quelque chose on prend uniquement les utilisateurs correspondant à la recherche
     * @return integer // Le nombre d'utilisateurs
     */
    function CountUsers(string|null $searchBarUsers): int
    {
        if ($searchBarUsers != "") {
            $s = "SELECT COUNT(*) FROM USERS WHERE idRole = 1 AND nameUser LIKE CONCAT('%', :search, '%') OR surnameUser LIKE CONCAT('%', :search, '%') OR emailUser LIKE CONCAT('%', :search, '%')";
            $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            try {
                $statement->bindParam(':search', $searchBarUsers, PDO::PARAM_STR);
                $statement->execute();
                $count = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
                return (int) $count["COUNT(*)"];

            } catch (PDOException $e) {
                echo 'Problème de lecture de la base de données: ' . $e->getMessage();
                return 0;
            }
        } else {
            $s = "SELECT COUNT(*) FROM USERS WHERE idRole = 1";
            $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            try {
                $statement->execute();
                $count = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
                return (int) $count["COUNT(*)"];

            } catch (PDOException $e) {
                echo 'Problème de lecture de la base de données: ' . $e->getMessage();
                return 0;
            }
        }
    }


    /**
     * Compte le nombre de sneakers dans la base de données
     *
     * @return integer // Le nombre de sneakers
     */
    function CountSneakers(): int
    {
        $s = "SELECT COUNT(*) FROM TRANSACTIONS INNER JOIN USERS ON TRANSACTIONS.idSeller = USERS.idUser WHERE idTStatut = 1 AND idSeller != :idSeller AND idUStatut = 1";
        $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        try {
            $statement->bindParam(':idSeller', $_SESSION['idUser'], PDO::PARAM_INT);
            $statement->execute();
            $count = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
            return (int) $count["COUNT(*)"];

        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
            return 0;
        }
    }

    /**
     * Compte le nombre de transactions de l'utilisateur voulu
     *
     * @param integer $idUser // L'id de l'utilisateur souhaité
     * @return integer // Le nombre de transaction
     */
    function CountUsersTransactions(int $idUser): int
    {
        $s = "SELECT COUNT(*) FROM TRANSACTIONS WHERE idSeller = :idUser OR idBuyer = :idUser AND idTStatut = 2";
        $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        try {
            $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
            $statement->execute();
            $count = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
            return (int) $count["COUNT(*)"];

        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
            return 0;
        }
    }

    /**
     * Bloque l'utilisateur en changeant sont statut dans la base de données
     *
     * @param integer $idUser // L'id de l'utilisateur souhaité
     * @return bool // si l'opération a réussi ou non
     */
    function BlockUser(int $idUser): bool
    {
        try {
            // 1 - Active / 2 - Blocked
            $s = "UPDATE USERS SET idUStatut = 2 WHERE idUser = :idUser";
            $statement = Database::prepare($s);

            $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);

            $statement->execute();

            return true;

        } catch (PDOException $e) {
            echo 'Problème d\'insertion en base de données: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Vérifie si l'utilisateur est bloqué
     *
     * @param integer $idUser // l'id de l'utilisateur à vérifier
     * @return bool // Oui ou non
     */
    function IsBlocked(int $idUser): bool
    {
        $s = "SELECT * FROM USERS WHERE idUser = :idUser AND idUStatut = 2";
        $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        try {
            $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
            $statement->execute();
        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
        }

        $row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
        if ($row) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Débloque un utilisateur
     *
     * @param integer $idUser // L'id de l'utilisateur souhaité
     * @return boolean // si l'opération a réussi ou non
     */
    function UnblockUser(int $idUser): bool
    {
        try {
            // 1 - Active / 2 - Blocked
            $s = "UPDATE USERS SET idUStatut = 1 WHERE idUser = :idUser";
            $statement = Database::prepare($s);

            $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);

            $statement->execute();

            return true;

        } catch (PDOException $e) {
            echo 'Problème d\'insertion en base de données: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Supprime l'utiisateur de la base de données
     *
     * @param integer $idUser // l'id de l'utilisateur à supprimer
     * @return boolean // si l'opération a réussi ou non
     */
    function DeleteUser(int $idUser): bool
    {
        try {
            $s = "DELETE FROM USERS WHERE idUser = :idUser";
            $statement = Database::prepare($s);

            $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);

            $statement->execute();

            return true;

        } catch (PDOException $e) {
            echo 'Problème d\'insertion en base de données: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Supprime les offres d'achats de l'utilisateur
     *
     * @param integer $idUser // L'id de l'utilisateur souhaité
     * @return boolean // si l'opération a réussi ou non
     */
    function RemoveBuyingOffers(int $idUser): bool
    {
        try {
            $s = "UPDATE TRANSACTIONS SET idBuyer = NULL AND idMeetPoint = NULL AND idDateMeetPlace = NULL WHERE idBuyer = :idUser";
            $statement = Database::prepare($s);

            $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);

            $statement->execute();

            return true;

        } catch (PDOException $e) {
            echo 'Problème d\'insertion en base de données: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Récupère toutes les sneakers en vente
     *
     * @param integer $indexFirst // [Pagination] index du premier utilisateur
     * @param integer $indexLast // [Pagination] index du dernier utilisateur
     * @return array // Tableau de ViewTransaction
     */
    function GetAllShoesInSale(int $indexFirst, int $indexLast): array
    {
        $arr = array();

        $s = "SELECT * FROM VIEW_TRANSACTIONS WHERE nameStatut LIKE 'In progress' AND idSeller != :idSeller LIMIT :indexFirst, :indexLast";
        $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        try {
            $statement->bindParam(':idSeller', $_SESSION['idUser']);
            $statement->bindParam(':indexFirst', $indexFirst, PDO::PARAM_INT);
            $statement->bindParam(':indexLast', $indexLast, PDO::PARAM_INT);


            $statement->execute();
        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
        }

        while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
            $sneaker = new Sneaker($row["idSneaker"], $row["sizeSneaker"], $row["priceSneaker"], $row["imgSneaker"], $row["descriptionSneaker"], $row["nameSStatut"], $row["nameBrand"], $row["nameModel"], $row["nameVisibility"]);
            $acheteur = new User($row["idBuyer"], $row["nameBuyer"], $row["surnameBuyer"], $row["emailBuyer"], "", 0, $row["imgBuyer"]);
            $vendeur = new User($row["idSeller"], $row["nameSeller"], $row["surnameSeller"], $row["emailSeller"], "", 0, $row["imgSeller"]);

            $u = new ViewTransaction($row["idTransaction"], $sneaker, $acheteur, $vendeur, $row["nameStatut"], new MeetPoint(0, "", $row["adressMeetPoint"], "", $row["dateHourMeetPlace"]));
            array_push($arr, $u);
        }

        return $arr;
    }

    /**
     * Vérifie si une sneaker existe dans la base de données
     *
     * @param integer $idSneaker // l'id de la sneaker à vérifier
     * @return boolean // Oui ou non
     */
    function DoesSneakerExist(int $idSneaker): bool
    {
       

        try {
            $s = "SELECT * FROM TRANSACTIONS WHERE idSneaker = :idSneaker";
            $statement = Database::prepare($s);

            $statement->bindParam(':idSneaker', $idSneaker, PDO::PARAM_INT);

            $statement->execute();

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return true;
            }
        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
        }

        return false;
    }

    /**
     * Supprime la sneaker en vente de la base
     *
     * @param integer $idSneaker // l'id de la sneaker
     * @return void
     */
    function RemoveSneakerInSale(int $idSneaker): void
    {
        if (self::DoesSneakerExist($idSneaker)) {
            try {
                $s = "DELETE FROM TRANSACTIONS WHERE idSneaker = :idSneaker";
                $statement = Database::prepare($s);

                $statement->bindParam(':idSneaker', $idSneaker, PDO::PARAM_INT);

                $statement->execute();

            } catch (PDOException $e) {
                echo 'Problème d\'insertion en base de données: ' . $e->getMessage();
            }
        }
    }

    /**
     * Récupère toutes les écoles de la base de données
     *
     * @return array
     */
    function GetAllSchools(): array
    {
        $arr = array();

        $s = "SELECT * FROM SCHOOLS ORDER BY idSchool DESC";
        $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        try {
            $statement->execute();
        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
        }

        while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
            $u = new School($row["idSchool"], $row["nameSchool"]);
            array_push($arr, $u);
        }

        return $arr;
    }

    /**
     * Récupère tout les points de rendez-vous de la base
     *
     * @return array
     */
    function GetAllMeetPoints(): array
    {
        $arr = array();

        $s = "SELECT * FROM MEETPOINTS ORDER BY idMeetPoint DESC";
        $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        try {
            $statement->execute();
        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
        }

        while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
            $u = new MeetPoint($row["idMeetPoint"], $row["nameMeetPoint"], $row["adressMeetPoint"], $row["descriptionMeetPoint"]);
            array_push($arr, $u);
        }

        return $arr;
    }

    /**
     * Vérifie si le point de rendez-vous existe
     *
     * @param MeetPoint $meetPoint // Le point de rendez vous à vérifier
     * @return boolean // oui ou non
     */
    function DoesMeetPointExist(MeetPoint $meetPoint): bool
    {
        $nameMeetPoint = Constants::AntiXSS($meetPoint->nameMeetPoint);

        $s = "SELECT * FROM MEETPOINTS WHERE nameMeetPoint = :nameMeetPoint";
        $statement = Database::prepare($s, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        try {
            $statement->bindParam(':nameMeetPoint', $nameMeetPoint);
            $statement->execute();

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Vérifie les données envoyées pour créer un point de rendez vous
     *
     * @param MeetPoint $meetPoint // Le point de rendez vous souhaitant être créé
     * @return array // tableau des potentielles erreurs
     */
    function ErrorCreateMeetPoint(MeetPoint $meetPoint): array
    {
        $errorMsg = [];
        if (self::DoesMeetPointExist($meetPoint)) {
            $errorMsg["nameMeetPoint"] = Constants::MEET_POINT_EXIST;
        }
        if ($meetPoint->nameMeetPoint == "") {
            $errorMsg["nameMeetPoint"] = Constants::NOT_EMPTY;
        }
        if ($meetPoint->adressMeetPoint == "") {
            $errorMsg["adressMeetPoint"] = Constants::NOT_EMPTY;
        }
        if ($meetPoint->descriptionMeetPoint == "") {
            $errorMsg["descriptionMeetPoint"] = Constants::NOT_EMPTY;
        }

        return $errorMsg;
    }

    /**
     * Vérifie les données envoyées pour modifier un point de rendez vous
     *
     * @param MeetPoint $meetPoint // Le point de rendez vous souhaitant être modifié
     * @return array // tableau des potentielles erreurs
     */
    function ErrorEditMeetPoint(MeetPoint $meetPoint): array
    {
        $errorMsg = [];
        if ($meetPoint->nameMeetPoint == "") {
            $errorMsg["nameMeetPoint"] = Constants::NOT_EMPTY;
        }
        if ($meetPoint->adressMeetPoint == "") {
            $errorMsg["adressMeetPoint"] = Constants::NOT_EMPTY;
        }
        if ($meetPoint->descriptionMeetPoint == "") {
            $errorMsg["descriptionMeetPoint"] = Constants::NOT_EMPTY;
        }

        return $errorMsg;
    }

    /**
     * Crée le point de rendez vous dans la base de données
     *
     * @param MeetPoint $meetPoint // Point de rendez vous à ajouter
     * @return boolean // L'opération a réussi ou non
     */
    function CreateMeetPoint(MeetPoint $meetPoint) : bool
    {
        try {
            $nameMeetPoint = Constants::AntiXSS($meetPoint->nameMeetPoint);
            $adressMeetPoint = Constants::AntiXSS($meetPoint->adressMeetPoint);
            $descriptionMeetPoint = Constants::AntiXSS($meetPoint->descriptionMeetPoint);

            $s = "INSERT INTO MEETPOINTS(nameMeetPoint, adressMeetPoint, descriptionMeetPoint) VALUES(:nameMeetPoint, :adressMeetPoint, :descriptionMeetPoint)";
            $statement = Database::prepare($s);
            $statement->bindParam(':nameMeetPoint', $nameMeetPoint);
            $statement->bindParam(':adressMeetPoint', $adressMeetPoint);
            $statement->bindParam(':descriptionMeetPoint', $descriptionMeetPoint);

            $statement->execute();

            return true;

        } catch (PDOException $e) {
            echo 'Problème d\'insertion en base de données: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Vérifie si une transaction a le point de rendez-vous indiqué
     *
     * @param integer $idMeetPoint // Point de rendez vous à vérifier
     * @return boolean // Oui ou non
     */
    function DoesTransactionHasMeetPoint(int $idMeetPoint) : bool
    {

        $s = "SELECT * FROM TRANSACTIONS WHERE idMeetPoint = :idMeetPoint";
        $statement = Database::prepare($s, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        try {
            $statement->bindParam(':idMeetPoint', $idMeetPoint);
            $statement->execute();

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Supprime le point de rendez vous dans la base de données
     *
     * @param integer $idMeetPoint // id du point de rendez vous à supprimer
     * @return boolean // L'opération a réussi ou non
     */ 
    function RemoveMeetPoint(int $idMeetPoint) : bool
    {
        if (!self::DoesTransactionHasMeetPoint($idMeetPoint)) {
            try {
                $s = "DELETE FROM MEETPOINTS WHERE idMeetPoint = :idMeetPoint";
                $statement = Database::prepare($s);

                $statement->bindParam(':idMeetPoint', $idMeetPoint);

                $statement->execute();

                return true;

            } catch (PDOException $e) {
                echo 'Problème d\'insertion en base de données: ' . $e->getMessage();
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Modifie le point de rendez vous souhaité dans la base de données
     *
     * @param MeetPoint $meetPoint // Point de rendez vous modifié
     * @return boolean // L'opération a réussi ou non
     */
    function EditMeetPoint(MeetPoint $meetPoint) : bool
    {
        try {
            $idMeetPoint = Constants::AntiXSS($meetPoint->idMeetPoint);
            $nameMeetPoint = Constants::AntiXSS($meetPoint->nameMeetPoint);
            $adressMeetPoint = Constants::AntiXSS($meetPoint->adressMeetPoint);
            $descriptionMeetPoint = Constants::AntiXSS($meetPoint->descriptionMeetPoint);

            $s = "UPDATE MEETPOINTS SET nameMeetPoint = :nameMeetPoint, adressMeetPoint = :adressMeetPoint, descriptionMeetPoint = :descriptionMeetPoint WHERE idMeetPoint = :idMeetPoint";
            $statement = Database::prepare($s);

            $statement->bindParam(':nameMeetPoint', $nameMeetPoint);
            $statement->bindParam(':adressMeetPoint', $adressMeetPoint);
            $statement->bindParam(':descriptionMeetPoint', $descriptionMeetPoint);
            $statement->bindParam(':idMeetPoint', $idMeetPoint);

            $statement->execute();

            return true;

        } catch (PDOException $e) {
            echo 'Problème d\'insertion en base de données: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Vérifie si les données pour modifier une école sont correctes
     *
     * @param School $school // L'école à modifier
     * @return array // Le tableau des potentielles erreurs
     */
    function ErrorEditSchool(School $school) : array
    {
        $errorMsg = [];
        if ($school->nameSchool == "") {
            $errorMsg["nameSchool"] = Constants::NOT_EMPTY;
        }

        return $errorMsg;
    }

    /**
     * Vérifie si l'école indiquée est affiliée à un utilisateur ou plus
     *
     * @param integer $idSchool // id de l'école à vérifier
     * @return boolean // Oui ou non
     */
    function DoesSchoolHasUser(int $idSchool) : bool
    {
        $s = "SELECT * FROM USERS WHERE idSchool = :idSchool";
        $statement = Database::prepare($s, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        try {
            $statement->bindParam(':idSchool', $idSchool);
            $statement->execute();

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Supprime l'école souhaitée de la base
     *
     * @param integer $idSchool // id de l'école à supprimer
     * @return boolean // L'opération a réussi ou non
     */
    function RemoveSchool(int $idSchool) : bool
    {
        if (!self::DoesSchoolHasUser($idSchool)) {
            try {
                $s = "DELETE FROM SCHOOLS WHERE idSchool = :idSchool";
                $statement = Database::prepare($s);

                $statement->bindParam(':idSchool', $idSchool);

                $statement->execute();

                return true;

            } catch (PDOException $e) {
                echo 'Problème d\'insertion en base de données: ' . $e->getMessage();
                return false;
            }
        } else {
            return false;
        }

    }

    /**
     * Modifie l'école souhaitée dans la base de données
     *
     * @param School $school // école modifée
     * @return boolean // L'opération a réussi ou non
     */
    function EditSchool(School $school) : bool
    {
        try {
            $idSchool = Constants::AntiXSS($school->idSchool);
            $nameSchool = Constants::AntiXSS($school->nameSchool);

            $s = "UPDATE SCHOOLS SET nameSchool = :nameSchool WHERE idSchool = :idSchool";
            $statement = Database::prepare($s);

            $statement->bindParam(':nameSchool', $nameSchool);
            $statement->bindParam(':idSchool', $idSchool);

            $statement->execute();

            return true;

        } catch (PDOException $e) {
            echo 'Problème d\'insertion en base de données: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Vérifie si l'école indiquée existe dans la base de données
     *
     * @param School $school // école à vérifier
     * @return boolean // oui ou non
     */
    function DoesSchoolExist(School $school) : bool
    {
        $nameSchool = Constants::AntiXSS($school->nameSchool);

        $s = "SELECT * FROM SCHOOLS WHERE nameSchool = :nameSchool";
        $statement = Database::prepare($s, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        try {
            $statement->bindParam(':nameSchool', $nameSchool);
            $statement->execute();

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Vérifie si l'école voulant être créée est correcte
     *
     * @param School $school // école voulant être créée
     * @return array // tableau des potentielles erreurs
     */
    function ErrorCreateSchool(School $school) : array
    {
        $errorMsg = [];
        if (self::DoesSchoolExist($school)) {
            $errorMsg["nameSchool"] = Constants::SCHOOL_EXIST;
        }
        if ($school->nameSchool == "") {
            $errorMsg["nameSchool"] = Constants::NOT_EMPTY;
        }
        return $errorMsg;
    }

    /**
     * Crée l'école dans la base de données
     *
     * @param School $school // école à créer
     * @return boolean // L'opération a réussi ou non
     */
    function CreateSchool(School $school) : bool
    {
        try {
            $nameSchool = Constants::AntiXSS($school->nameSchool);

            $s = "INSERT INTO SCHOOLS(nameSchool) VALUES(:nameSchool)";
            $statement = Database::prepare($s);
            $statement->bindParam(':nameSchool', $nameSchool);


            $statement->execute();

            return true;

        } catch (PDOException $e) {
            echo 'Problème d\'insertion en base de données: ' . $e->getMessage();
            return false;
        }
    }
}