<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
Projet : SneakersMarket (TPI)
Auteur : Léo Triano
Desc. : Site d'achat-revente de sneakers
Version : 1.0
Date : Mai 2024
Page : Modele de la page gestion
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

class Gestion
{
    /**
     * Vérifie si les données pour créer une nouvelle paire sont conformes
     *
     * @param integer $size // taille de la paire
     * @param float|integer $price // prix de la paire
     * @param array $img // image de la paire
     * @param string $desc // description de la paire
     * @param string $model // modèle de la paire
     * @param integer $idBrand // id de la marque de la paire
     * @return array // tableau des potentielles erreurs
     */
    function CheckErrorsCreateTransaction(int|string $size, float|int|string $price, array $img, string $desc, string $model, int $idBrand) : array
    {
        $erorrMessages = [];

        if (strlen($desc) > Constants::MAX_DESC_CAR) {
            $erorrMessages["errorDesc"] = Constants::DESC_MAX_CAR;
        }
        if (!preg_match("/[0-9]/", $price)) {
            $erorrMessages["errorPrice"] = Constants::MUST_BE_NUMBER;
        }

        if ($img["type"] != "image/png" && $img["type"] != "image/jpeg" && $img["type"] != "image/jpg") {
            $erorrMessages["errorImg"] = Constants::MUST_BE_IMG;
        }

        if($img["size"] > Constants::IMG_SIZE){
            $erorrMessages["errorImg"] = Constants::ERROR_IMG_SIZE;
        }

        if ($size == "") {
            $erorrMessages["errorSize"] = Constants::NOT_EMPTY;
        }
        if ($size < Constants::SIZE_MIN || $size > Constants::SIZE_MAX) {
            $erorrMessages["errorSize"] = Constants::SIZE_MIN_MAX;
        }
        if ($price == "") {
            $erorrMessages["errorPrice"] = Constants::NOT_EMPTY;
        }
        if ($price < Constants::PRICE_MIN) {
            $erorrMessages["errorPrice"] = Constants::PRICE_MIN_MAX;
        }
        if (empty($img["name"])) {
            $erorrMessages["errorImg"] = Constants::NOT_EMPTY;
        }
        if ($desc == "") {
            $erorrMessages["errorDesc"] = Constants::NOT_EMPTY;
        }
        if ($model == "") {
            $erorrMessages["errorModel"] = Constants::NOT_EMPTY;
        }
        if ($idBrand == -1) {
            $erorrMessages["errorBrand"] = Constants::SELECT_BRAND;
        }

        return $erorrMessages;
    }




    /**
     * Récupère toutes les marques de la base
     *
     * @return array // tableau des marques
     */
    function GetAllBrands(): array
    {
        $arr = array();

        $s = "SELECT * FROM BRANDS ORDER BY nameBrand ASC";
        $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        try {
            $statement->execute();
        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
        }

        while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
            $u = new Brand($row["idBrand"], $row["nameBrand"]);
            array_push($arr, $u);
        }

        return $arr;
    }

    /**
     * Récupère tous les modèles de la base
     *
     * @return array // tableaud es modèles
     */
    function GetAllModeles(): array
    {
        $arr = array();

        $s = "SELECT * FROM MODELS";
        $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        try {
            $statement->execute();
        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
        }

        while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
            $u = new Modele($row["idModel"], $row["nameModel"]);
            array_push($arr, $u);
        }

        return $arr;
    }
    
    /**
     * Insère la paire dans la base de données
     *
     * @param integer $size // taille de la paire
     * @param float|integer $price // prix de la paire
     * @param array $img // image de la paire
     * @param string $desc // description de la paire
     * @param integer $idModel // id du modèle de la paire
     * @param integer $idBrand // id de la marque de la paire
     * @return void
     */
    function InsertSneaker(int $size, float|int $price, array $img, string $desc, int $idModel, int $idBrand, int $statut): void
    {
        try {
            $size = Constants::AntiXSS($size);
            $price = Constants::AntiXSS($price);
            $desc = Constants::AntiXSS($desc);
            $idModel = Constants::AntiXSS($idModel);
            $idBrand = Constants::AntiXSS($idBrand);
            $img = Constants::ConvertImgTo64($img);

            $s = "INSERT INTO SNEAKERS(sizeSneaker, priceSneaker, imgSneaker, descriptionSneaker, idModel, idBrand, idVisibility) 
            VALUES(:size, :price, :img, :desc, :idModel, :idBrand, :statut)";
            $statement = Database::prepare($s);

            $statement->bindParam(':size', $size);
            $statement->bindParam(':price', $price);
            $statement->bindParam(':img', $img);
            $statement->bindParam('desc', $desc);
            $statement->bindParam('idModel', $idModel);
            $statement->bindParam('idBrand', $idBrand);
            $statement->bindParam('statut', $statut);


            $statement->execute();

        } catch (PDOException $e) {
            echo 'Problème d\'insertion en base de données: ' . $e->getMessage();
        }
    }

    /**
     * Vérifie si le modèle existe à partir de son nom
     *
     * @param string $nameModel // nom du modèle
     * @return Modele|false // le modèle ou false s'il n'existe pas
     */
    function DoesModeleExist(string $nameModel) : Modele|false
    {

        $s = "SELECT * FROM MODELS WHERE nameModel = :nameModel";
        $statement = Database::prepare($s, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        try {
            $statement->execute(array(':nameModel' => $nameModel));

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return new Modele($row["idModel"], $row["nameModel"]);
            }
        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
        }

        return false;

    }

    /**
     * Insère le modèle dans la base de données
     *
     * @param string $nameModel // nom du modèle
     * @return boolean // l'opération a réussi ou non
     */
    function InsertModele(string $nameModel) : bool
    {
        if (!self::DoesModeleExist($nameModel)) {
            try {
                $nameModel = Constants::AntiXSS($nameModel);
                $s = "INSERT INTO MODELS(nameModel) VALUES(:nameModel)";
                $statement = Database::prepare($s);

                $statement->bindParam(':nameModel', $nameModel);

                $statement->execute();
                return true;


            } catch (PDOException $e) {
                echo 'Problème d\'insertion en base de données: ' . $e->getMessage();
                return false;
            }
        }
        else{
            return false;
        }
    }


    /**
     * Insère la paire et la transaction affiliée à cette dernière en base de données
     *
     * @param integer $size // taille de la paire
     * @param integer $price // prix de la paire
     * @param array $img // image de la paire
     * @param string $desc // description de la paire
     * @param string $nameModel // nom du modèle de la paire
     * @param integer $idBrand // id de la marque de la paire
     * @return void
     */
    function CreateTransaction(int $size, int $price, array $img, string $desc, string $nameModel, int $idBrand, int $statut): void
    {
        try {
            // Début de la transaction
            Database::beginTransaction();

            // Si l'insertion du modèle se fait correctement
            if(self::InsertModele($nameModel) !== false){
                // Récupère l'id du dernier modèle inséréé
                $idModel = Database::lastInsertId();
            }
            else{
                // Sinon, récupère l'id du modèle
                $idModel = self::DoesModeleExist($nameModel)->idModel;
            }

            // Insère la sneaker en base
            self::InsertSneaker($size, $price, $img, $desc, $idModel, $idBrand, $statut);

            $idSneaker = Database::lastInsertId();

            // Insère la transaction
            $s = "INSERT INTO TRANSACTIONS(idSneaker, idSeller) VALUES(:idSneaker, :idSeller)";
            $statement = Database::prepare($s);

            $statement->bindParam(':idSneaker', $idSneaker);
            $statement->bindParam(':idSeller', $_SESSION['idUser']);


            $statement->execute();
            Database::commit();
        } catch (PDOException $e) {
            // Annule la transaction
            Database::rollBack();
            echo 'Problème d\'insertion en base de données: ' . $e->getMessage();
        }
    }

    /**
     * Récupère toutes les paires en vente
     *
     * @return array // tableau des paires
     */
    function GetAllShoesInSale(): array
    {
        $arr = array();

        $s = "SELECT * FROM VIEW_TRANSACTIONS WHERE nameStatut LIKE 'In progress' AND idSeller = :idSeller";
        $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        try {
            $statement->bindParam(':idSeller', $_SESSION['idUser']);

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
     * Vérifie si la paire existe dans la base
     *
     * @param integer $idSneaker // id de la paire à vérifier
     * @return boolean // oui ou non
     */
    function DoesSneakerExist(int $idSneaker) : bool
    {
        $s = "SELECT * FROM SNEAKERS WHERE idSneaker = :idSneaker";
        $statement = Database::prepare($s, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        try {
            $statement->execute(array(':idSneaker' => $idSneaker));

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return true;
            }
        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
            return false;
        }

        return false;
    }

    /**
     * Vérifie si l'utilisateur actuel n'est pas bloqué ou non
     *
     * @return boolean // Oui ou non
     */
    function IsUserNotBlocked() : bool
    {
        $s = "SELECT * FROM USERS WHERE idUser = :idUser AND idUStatut = 1";
        $statement = Database::prepare($s, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        try {
            $statement->execute(array(':idUser' => $_SESSION['idUser']));

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return true;
            }
        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
            return false;
        }

        return false;
    }

    /**
     * Supprime une paire de la base de données
     *
     * @param integer $idSneaker // id de la paire à supprimer
     * @return void
     */
    function RemoveSneakerInSale(int $idSneaker)
    {
        $idSneaker = Constants::AntiXSS($idSneaker);
        if (self::DoesSneakerExist($idSneaker)) {
            try {
                $s = "DELETE FROM TRANSACTIONS WHERE idSneaker = :idSneaker AND idSeller = :idUser";
                $statement = Database::prepare($s);

                $statement->bindParam(':idSneaker', $idSneaker);
                $statement->bindParam(':idUser', $_SESSION['idUser']);

                $statement->execute();

            } catch (PDOException $e) {
                echo 'Problème d\'insertion en base de données: ' . $e->getMessage();
            }
        }
    }

    /**
     * Récupère toutes les paires que l'utilisateur a acheté
     *
     * @return array // tableau des paires
     */
    function GetAllShoesPurchased(): array
    {
        $arr = array();

        $s = "SELECT * FROM VIEW_TRANSACTIONS WHERE nameStatut LIKE 'Sold' AND idBuyer = :idBuyer";
        $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        try {
            $statement->bindParam(':idBuyer', $_SESSION['idUser']);

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
     * Récupère toutes les paires que l'utilsiateur a réservé
     *
     * @return array // tableau des paires
     */
    function GetAllShoesReserved(): array
    {
        $arr = array();

        $s = "SELECT * FROM VIEW_TRANSACTIONS WHERE nameStatut LIKE 'Reserved' AND idBuyer = :idBuyer";
        $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        try {
            $statement->bindParam(':idBuyer', $_SESSION['idUser']);

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
     * Annule la réservation de l'utilisateur
     *
     * @param integer $idSneaker // id de la paire à annuler
     * @return boolean // l'opération a réussi ou non
     */
    function CancelReserve(int $idSneaker) : bool
    {
        try {
            $s = "UPDATE TRANSACTIONS SET idBuyer = NULL, idTStatut = 1 WHERE idSneaker = :idSneaker";
            $statement = Database::prepare($s);

            $statement->bindParam(':idSneaker', $idSneaker);

            $statement->execute();

            return true;

        } catch (PDOException $e) {
            echo 'Problème d\'insertion en base de données: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Récupère toutes les paires que l'utilisateur vend et son réservées
     *
     * @return array // tableau des paires
     */
    function SneakersReserved(): array
    {
        $arr = array();

        $s = "SELECT * FROM VIEW_TRANSACTIONS WHERE nameStatut LIKE 'Reserved' AND idSeller = :idSeller";
        $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        try {
            $statement->bindParam(':idSeller', $_SESSION['idUser']);

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
     * Accepte la réservation d'un utilisateur et finalise la transaction
     *
     * @param int $idSneaker // id de la paire
     * @return boolean // l'opération a réussi ou non
     */
    function AcceptReservation(int $idSneaker) : bool
    {
        try {
            $s = "UPDATE TRANSACTIONS SET idTStatut = 2 WHERE idSneaker = :idSneaker";
            $statement = Database::prepare($s);

            $statement->bindParam(':idSneaker', $idSneaker);

            $statement->execute();

            return true;

        } catch (PDOException $e) {
            echo 'Problème d\'insertion en base de données: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Supprime les favoris d'une paire si cette dernière a été vendue
     *
     * @param integer $idSneaker // id de la paire
     * @return boolean // l'opération a réussi ou non
     */
    function RemoveFavoritesSneakerSold(int $idSneaker) : bool
    {
        try {
            $s = "DELETE FROM FAVORITES WHERE idSneaker = :idSneaker";
            $statement = Database::prepare($s);

            $statement->bindParam(':idSneaker', $idSneaker);

            $statement->execute();

            return true;

        } catch (PDOException $e) {
            echo 'Problème d\'insertion en base de données: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Refuse la demande d'achat d'un utilisateur
     *
     * @param integer $idSneaker // l'id de la paire
     * @return boolean // l'opération a réussi ou non
     */
    function DenyReservation(int $idSneaker) : bool
    {
        try {
            $s = "UPDATE TRANSACTIONS SET idTStatut = 1, idBuyer = NULL, idMeetPoint = NULL, idDateMeetPlace = NULL WHERE idSneaker = :idSneaker";
            $statement = Database::prepare($s);

            $statement->bindParam(':idSneaker', $idSneaker);

            $statement->execute();

            return true;

        } catch (PDOException $e) {
            echo 'Problème d\'insertion en base de données: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Récupère toutes les paires que l'utilisateur a vendu
     *
     * @return array // tableau des paires
     */
    function SneakersSold(): array
    {
        $arr = array();

        $s = "SELECT * FROM VIEW_TRANSACTIONS WHERE nameStatut LIKE 'Sold' AND idSeller = :idSeller";
        $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        try {
            $statement->bindParam(':idSeller', $_SESSION['idUser']);

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

    function IsSneakerInvisible($idSneaker){
        $s = "SELECT * FROM VIEW_TRANSACTIONS WHERE nameVisibility LIKE 'hidden' AND idSneaker = :idSneaker";
        $statement = Database::prepare($s, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        try {
            $statement->execute(array(':idSneaker' => $idSneaker));

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return true;
            }
        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
            return false;
        }

        return false;
    }

    function SetSneakerToVisible($idSneaker){
        try {
            $s = "UPDATE SNEAKERS SET idVisibility = 1 WHERE idSneaker = :idSneaker";
            $statement = Database::prepare($s);

            $statement->bindParam(':idSneaker', $idSneaker);

            $statement->execute();

            return true;

        } catch (PDOException $e) {
            echo 'Problème d\'insertion en base de données: ' . $e->getMessage();
            return false;
        }
    }
}