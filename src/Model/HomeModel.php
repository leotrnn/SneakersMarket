<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
Projet : SneakersMarket (TPI)
Auteur : Léo Triano
Desc. : Site d'achat-revente de sneakers
Version : 1.0
Date : Mai 2024
Page : Modele de la page home
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
class Home
{
    public $idUser;

    function __construct()
    {
        // Initialisation de $idUser en fonction de $_SESSION
        $this->idUser = isset($_SESSION['idUser']) ? $_SESSION['idUser'] : 0;
    }

    /**
     * Récupère toutes les transactions pour les cards
     *
     * @param integer $indexFirst // index de la première paire pour pagination
     * @param integer $indexLast // index de la dernière paire pour pagination
     * 
     * @return array // Tableau de paires
     */
    function GetAllSneakers(int $indexFirst, int $indexLast): array
    {
        $statutSeller = 1;
        $nameVisibilty = "Visible";
        $arr = array();

        $s = "SELECT * FROM VIEW_TRANSACTIONS WHERE nameStatut LIKE 'In progress' AND idSeller != :idSeller AND statutSeller = :statutSeller AND nameVisibility LIKE :nameVisibilty ORDER BY nameBrand LIMIT :indexFirst, :indexLast";
        $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        try {

            // Problème résolu par chatgpt, ne pas spécifier que les paramètres soient des int faisait une sql syntax violation
            $statement->bindParam(':idSeller', $this->idUser, PDO::PARAM_INT);
            $statement->bindParam(':statutSeller', $statutSeller, PDO::PARAM_INT);
            $statement->bindParam(':nameVisibilty', $nameVisibilty, PDO::PARAM_STR);
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
     * Récupère toutes les marques de la base
     *
     * @return array
     */
    function GetAllBrands(): array
    {
        $arr = array();

        $s = "SELECT * FROM BRANDS";
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
     * Filtre les paires du listring par marque et / ou taille 
     *
     * @param integer|null $idBrand // id de la marque de la paire
     * @param integer|null $indexFirst // [Pagination] index de la première paire
     * @param integer|null $indexLast // [Pagination] index de la dernière paire
     * @param integer|null $idSize // id de la taille de la paire
     * @return array // tableau des paires
     */
    function FilterByBrand(int|null $idBrand, int|null $indexFirst, int|null $indexLast, int|null $idSize) : array
    {
        $arr = array();
    
        $query = "SELECT * FROM VIEW_TRANSACTIONS WHERE nameStatut LIKE 'In progress' AND idSeller != :idSeller AND statutSeller = 1";
        $params = array(':idSeller' => $this->idUser);
    
        if ($idBrand != 0 && $idBrand != -1 && $idBrand != null) {
            $query .= " AND idBrand = :idBrand";
            $params[':idBrand'] = $idBrand;
        }
    
        if ($idSize != 0 && $idSize != -1 && $idSize != null) {
            $query .= " AND sizeSneaker = :idSize";
            $params[':idSize'] = $idSize;
        }
    
        $query .= " LIMIT :indexFirst, :indexLast";
        $params[':indexFirst'] = $indexFirst;
        $params[':indexLast'] = $indexLast;
    
        $statement = Database::prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    
        try {
            foreach ($params as $param => $value) {
                // Réglage d'erreur demandé à chatgpt, vu qu'il fallait impérativement spécifier que l'index first et last soient des int ça faisait une erreur
                // https://chat.openai.com/share/d9c40bf0-5969-4163-807c-5f3303e8f1fd
                $statement->bindValue($param, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
            }
    
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
     * Compte le nombre de paires, par marque si indiqué
     *
     * @param integer|null $idBrand // id de la marque s'il y en a une, sinon null
     * @return integer // Le nombre de paires
     */
    function CountSneakers(int|null $idBrand): int
    {

        if ($idBrand != -1 && $idBrand != 0) {
            $s = "SELECT COUNT(*) FROM TRANSACTIONS  
            INNER JOIN SNEAKERS ON TRANSACTIONS.idSneaker = SNEAKERS.idSneaker 
            INNER JOIN USERS ON TRANSACTIONS.idSeller = USERS.idUser
            WHERE idTStatut = 1 AND SNEAKERS.idBrand = :idBrand AND idSeller != :idSeller AND idUStatut = 1";
            $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            try {
                $statement->bindParam(':idSeller', $this->idUser);
                $statement->bindParam(':idBrand', $idBrand);
                $statement->execute();
                $count = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
                return (int) $count["COUNT(*)"];

            } catch (PDOException $e) {
                echo 'Problème de lecture de la base de données: ' . $e->getMessage();
                return 0;
            }
        } else {
            $s = "SELECT COUNT(*) FROM TRANSACTIONS INNER JOIN USERS ON TRANSACTIONS.idSeller = USERS.idUser WHERE idTStatut = 1 AND idSeller != :idSeller AND idUStatut = 1";
            $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            try {
                $statement->bindParam(':idSeller', $this->idUser);
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
     * Récupère le nombre de tailles disponibles des paires
     *
     * @return array // Le tableau des paires contenant uniquement leur tailles
     */
    function GetAllSizes() : array
    {
        $arr = array();

        $s = "SELECT sizeSneaker FROM VIEW_TRANSACTIONS WHERE idSeller != :idUser AND statutSeller = 1 AND nameStatut LIKE 'in progress' GROUP BY sizeSneaker  ORDER BY sizeSneaker";
        $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        try {
            $statement->bindParam(":idUser", $this->idUser);
            $statement->execute();
        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
        }

        while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
            $u = new Sneaker(0, $row["sizeSneaker"]);
            array_push($arr, $u);
        }

        return $arr;
    }
}