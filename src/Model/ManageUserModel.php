<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
Projet : SneakersMarket (TPI)
Auteur : Léo Triano
Desc. : Site d'achat-revente de sneakers
Version : 1.0
Date : Mai 2024
Page : Modèle de la page manage user
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
class ManageUser{
    /**
     * Récupère l'utilisateur avec l'id donné
     *
     * @param integer $idUser // l'id à vérifier
     * @return User|false // L'utilisateur s'il existe, false s'il existe pas
     */
    function GetUserById(int $idUser): User|false
    {
        $s = "SELECT * FROM USERS WHERE idUser = :idUser";
        $statement = Database::prepare($s, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        try {
            $statement->execute(array(':idUser' => $idUser));

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return new User($row["idUser"], $row["nameUser"], $row["surnameUser"], $row["emailUser"], $row["pwdUser"], $row["idSchool"], $row["imgUser"], $row["idRole"]);
            }
        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
        }

        return false;
    }

    /**
     * Récupère toutes les sneakers en vente
     *
     * @param integer $indexFirst // [Pagination] index du premier utilisateur
     * @param integer $indexLast // [Pagination] index du dernier utilisateur
     * @return array // Tableau de ViewTransaction
     */
    function GetAllShoesInSale(int $idSeller, int $indexFirst, int $indexLast): array
    {
        $arr = array();

        $s = "SELECT * FROM VIEW_TRANSACTIONS WHERE nameStatut LIKE 'In progress' AND idSeller = :idSeller LIMIT :indexFirst, :indexLast";
        $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        try {
            $statement->bindParam(':idSeller', $idSeller, PDO::PARAM_INT);
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
     * Compte le nombre de sneakers dans la base de données
     *
     * @return integer // Le nombre de sneakers
     */
    function CountSneakers($idUser): int
    {
        $s = "SELECT COUNT(*) FROM VIEW_TRANSACTIONS WHERE nameStatut LIKE 'In progress' AND idSeller = :idSeller";
        $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        try {
            $statement->bindParam(':idSeller', $idUser, PDO::PARAM_INT);
            $statement->execute();
            $count = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
            return (int) $count["COUNT(*)"];

        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
            return 0;
        }
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
     * Récupère toutes les paires que l'utilisateur a vendu
     *
     * @return array // tableau des paires
     */
    function SneakersSold($idUser): array
    {
        $arr = array();

        $s = "SELECT * FROM VIEW_TRANSACTIONS WHERE nameStatut LIKE 'Sold' AND idSeller = :idSeller";
        $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        try {
            $statement->bindParam(':idSeller', $idUser);

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

}