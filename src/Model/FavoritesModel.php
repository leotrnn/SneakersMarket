<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
Projet : SneakersMarket (TPI)
Auteur : Léo Triano
Desc. : Site d'achat-revente de sneakers
Version : 1.0
Date : Mai 2024
Page : Modele de la page favoris
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
class Favorites
{
    /**
     * Sélectionne les paires favorites de l'utilisateur
     *
     * @return array // Le tableau des paires
     */
    function UserFavList() : array
    {
        $arr = array();

        $s = "SELECT 
        DISTINCT VIEW_TRANSACTIONS.*, FAVORITES.*, SNEAKERS.*, MODELS.*, BRANDS.* 
        FROM VIEW_TRANSACTIONS 
        JOIN FAVORITES ON VIEW_TRANSACTIONS.idSneaker = FAVORITES.idSneaker 
        JOIN SNEAKERS ON FAVORITES.idSneaker = SNEAKERS.idSneaker 
        JOIN MODELS ON SNEAKERS.idModel = MODELS.idModel 
        JOIN BRANDS ON SNEAKERS.idBrand = BRANDS.idBrand 
        WHERE FAVORITES.idUser = :idUser
        GROUP BY VIEW_TRANSACTIONS.idSneaker;";

        $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        try {
            $statement->bindParam(":idUser", $_SESSION['idUser']);
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
     * Renvoie true ou false si la paire sélectionnée est déjà dans les FAVORITES de l'utilisateur
     *
     * @param integer $idSneaker // Paire
     * @param integer $idUser // Utilisateur
     * @return boolean
     */
    function CheckIfFavorite(int $idSneaker, int $idUser): bool
    {
        $s = "SELECT * FROM FAVORITES WHERE idSneaker = :idSneaker AND idUser = :idUser";
        $statement = Database::prepare($s, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        try {
            $statement->execute(array(':idSneaker' => $idSneaker, ":idUser" => $idUser));

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
     * Vérifie si la paire indiquée existe dans la base de données
     *
     * @param integer $idSneaker // Paire à vérifier
     * @return boolean // Oui ou non
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
        }

        return false;
    }

    /**
     * Supprime la paire de détail dans les FAVORITES
     *
     * @param integer $idSneaker // Paire
     * @param integer $idUser // Utilisateur
     * @return void
     */
    function RemoveFromFavorite(int $idSneaker, int $idUser): void
    {
        if (self::DoesSneakerExist($idSneaker)) {
            try {
                $s = "DELETE FROM FAVORITES WHERE idSneaker = :idSneaker AND idUser = :idUser";
                $statement = Database::prepare($s);

                $statement->bindParam(':idSneaker', $idSneaker);
                $statement->bindParam(':idUser', $idUser);

                $statement->execute();

            } catch (PDOException $e) {
                echo 'Problème d\'insertion en base de données: ' . $e->getMessage();
            }
        }
    }

    /**
     * Compte le nombre de paires favorites dans la base
     *
     * @return integer // le nombre de paires favorites
     */
    function CountSneakers(): int
    {
        $s = "SELECT COUNT(*) FROM FAVORITES WHERE idUser = :idUser";
        $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        try {
            $statement->bindParam(":idUser", $_SESSION['idUser']);
            $statement->execute();
            $count = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
            return (int) $count["COUNT(*)"];

        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
            return 0;
        }

    }

}