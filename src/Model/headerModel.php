<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
Projet : SneakersMarket (TPI)
Auteur : Léo Triano
Desc. : Site d'achat-revente de sneakers
Version : 1.0
Date : Mai 2024
Page : Modele du header
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
class Header
{

    public $idUser;

    function __construct()
    {
        // Initialisation de $idUser en fonction de $_SESSION
        $this->idUser = isset($_SESSION['idUser']) ? $_SESSION['idUser'] : 0;
    }

    /**
     * Sélectionne toutes les paires en fonction de la marque ou du modèle cherché
     *
     * @param string $input // marque ou modèle cherché
     * @param integer $indexFirst // [Pagination] index du premier utilisateur
     * @param integer $indexLast // [Pagination] index du dernier utilisateur
     * @return array // tableau des paires
     */
    function SearchBar(string $input, int $indexFirst, int $indexLast) : array
    {
        $arr = array();

        $s = "SELECT * FROM VIEW_TRANSACTIONS WHERE (nameBrand LIKE CONCAT('%', :input, '%') OR nameModel LIKE CONCAT('%', :input, '%')) AND idSeller != :idSeller AND nameStatut LIKE 'In progress' AND nameVisibility LIKE 'Visible' LIMIT :indexFirst, :indexLast";
        $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        try {

            $statement->bindParam(':input', $input);
            $statement->bindParam(':idSeller', $this->idUser);
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
     * Compte le nombre de paire trouvées via la recherche pour la pagination
     *
     * @param string $search // recherche
     * @return integer // nombre de paires trouvées
     */
    function CountSneakers(string $search): int
    {
        $s = "SELECT COUNT(*) FROM VIEW_TRANSACTIONS WHERE nameBrand LIKE CONCAT('%', :input, '%') OR nameModel LIKE CONCAT('%', :input, '%') AND idSeller != :idSeller AND nameVisiblity LIKE 'Visible' AND nameStatut LIKE 'In progress'";
        $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        try {
            $statement->bindParam(':input', $search);
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

