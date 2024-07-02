<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
Projet : SneakersMarket (TPI)
Auteur : Léo Triano
Desc. : Site d'achat-revente de sneakers
Version : 1.0
Date : Mai 2024
Page : Modele de la page détail
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
class Detail
{

    /**
     * Récupère la paire correspondant à l'id reçu en paramètre
     *
     * @param integer $idSneaker // id de la paire désirée
     * @return Sneaker|false // Retourne la paire ou faux si erreur
     */
    function GetSneakerById(int $idSneaker): Sneaker|false
    {
        $s = "SELECT * FROM VIEW_SNEAKERS WHERE idSneaker = :idSneaker";
        $statement = Database::prepare($s, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        try {
            $statement->execute(array(':idSneaker' => $idSneaker));

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return new Sneaker($row["idSneaker"], $row["sizeSneaker"], $row["priceSneaker"], $row["imgSneaker"], $row["descriptionSneaker"], $row["nameSStatut"], $row["nameBrand"], $row["nameModel"], $row["nameVisibility"]);
            }
        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
        }

        return false;
    }

    /**
     * Renvoie true ou false si la paire sélectionnée est déjà dans les favoris de l'utilisateur
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
     * Ajoute la paire de détail dans les favoris
     *
     * @param integer $idSneaker // Paire
     * @param integer $idUser // Utilisateur
     * @return void
     */
    function AddToFavorite(int $idSneaker, int $idUser): void
    {
        try {
            $s = "INSERT INTO FAVORITES(idUser, idSneaker) VALUES(:idUser, :idSneaker)";
            $statement = Database::prepare($s);

            $statement->bindParam(':idSneaker', $idSneaker);
            $statement->bindParam(':idUser', $idUser);

            $statement->execute();

        } catch (PDOException $e) {
            echo 'Problème d\'insertion en base de données: ' . $e->getMessage();
        }
    }

    /**
     * Supprime la paire de détail dans les favoris
     *
     * @param integer $idSneaker // Paire
     * @param integer $idUser // Utilisateur
     * @return void
     */
    function RemoveFromFavorite(int $idSneaker, int $idUser): void
    {
        try {
            $s = "DELETE FROM FAVORITES  WHERE idSneaker = :idSneaker AND idUser = :idUser";
            $statement = Database::prepare($s);

            $statement->bindParam(':idSneaker', $idSneaker);
            $statement->bindParam(':idUser', $idUser);

            $statement->execute();

        } catch (PDOException $e) {
            echo 'Problème d\'insertion en base de données: ' . $e->getMessage();
        }
    }

    /**
     * Vérifie si l'utilisateur souhaité a réservé une paire
     *
     * @param integer $idSneaker // l'utilisateur à vérifier
     * @return boolean // oui ou non
     */
    function doesUserHasReserved(int $idSneaker) : bool
    {
        $s = "SELECT * FROM TRANSACTIONS WHERE idSneaker = :idSneaker AND idBuyer = :idBuyer";
        $statement = Database::prepare($s, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        try {
            $statement->execute(array(':idSneaker' => $idSneaker, ':idBuyer' => $_SESSION['idUser']));

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
     * Vérifie si la paire souhaitée est réservée
     *
     * @param integer $idSneaker // paire à vérifier
     * @return boolean // oui ou non
     */
    function IsReserved(int $idSneaker) : bool
    {
        $s = "SELECT * FROM TRANSACTIONS WHERE idSneaker = :idSneaker AND idBuyer IS NOT NULL";
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
     * Vérifie si les données passées sont conformes pour réserver
     *
     * @param integer $meetPoint // id du point de rendez vous
     * @param string|DateTime $meetingDate // date et heure de rendez vous
     * @return array // tableau des potentielles erreurs
     */
    function CheckErrorReserve(int $meetPoint, string|DateTime $meetingDate) : array
    {
        $errorMessages = [];
        $currentDate = new DateTime();
        $meetingDate = new DateTime($meetingDate);

        if ($meetPoint == 0 || $meetPoint == -1) {
            $errorMessages["meetPoint"] = "*Select a meet point";
        }


        if($meetingDate == "" || $meetingDate == NULL || $currentDate > $meetingDate){
            $errorMessages["meetingDate"] = "*Select a valid date";

        }

        return $errorMessages;
    }

    /**
     * Insère la date et l'heure du rendez vous en base de données
     *
     * @param integer $idMeetPoint // id du point de rendez vous
     * @param string|DateTime $meetingDate // date et heure de rendez vous
     * @return boolean // L'opération a réussi ou non
     */
    function InsertDateMeetPoint(int $idMeetPoint, string|DateTime $meetingDate) : bool
    {
        try {
            $s = "INSERT INTO DATEMEETPLACE(idMeetPoint, dateHourMeetPlace) VALUES(:idMeetPoint, :dateHourMeetPlace)";
            $statement = Database::prepare($s);

            $statement->bindParam(':idMeetPoint', $idMeetPoint);
            $statement->bindParam(':dateHourMeetPlace', $meetingDate);

            $statement->execute();

            return true;

        } catch (PDOException $e) {
            echo 'Problème d\'insertion en base de données: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Résèrve une paire dans la base de données
     *
     * @param integer $idSneaker // L'utilisateur souhaitant réserver
     * @param integer $idMeetPoint // L'id du point de rendez vous
     * @param string|DateTime $meetingDate // La date et l'heure de rendez vous
     * @return void
     */
    function Reserve(int $idSneaker, int $idMeetPoint, string|DateTime $meetingDate)
    {
        try {
            // Commence la transaction
            Database::beginTransaction();

            // Insère la date de rendez-vous
            self::InsertDateMeetPoint($idMeetPoint, $meetingDate);
            $idDateMeetPlace = Database::lastInsertId();

            // Met à jour le point de rendez-vous et le statut
            $s = "UPDATE TRANSACTIONS SET idBuyer = :idUser, idMeetPoint = :idMeetPoint, idTStatut = 3, idDateMeetPlace = :idDateMeetPlace WHERE idSneaker = :idSneaker";
            $statement = Database::prepare($s);

            $statement->bindParam(':idSneaker', $idSneaker);
            $statement->bindParam(':idMeetPoint', $idMeetPoint);
            $statement->bindParam(':idDateMeetPlace', $idDateMeetPlace);
            $statement->bindParam(':idUser', $_SESSION['idUser']);

            $statement->execute();

            Database::commit();
        } catch (PDOException $e) {
            // Annule la transaction
            Database::rollBack();

            echo 'Problème d\'insertion en base de données: ' . $e->getMessage();
        }
    }

    /**
     * Annule la réservation de la paire souhaitée
     *
     * @param integer $idSneaker // La paire à annuler
     * @return void
     */
    function CancelReserve(int $idSneaker)
    {
        try {
            $s = "UPDATE TRANSACTIONS SET idBuyer = NULL, idTStatut = 1, idDateMeetPlace = NULL WHERE idSneaker = :idSneaker";
            $statement = Database::prepare($s);

            $statement->bindParam(':idSneaker', $idSneaker);

            $statement->execute();

        } catch (PDOException $e) {
            echo 'Problème d\'insertion en base de données: ' . $e->getMessage();
        }
    }

    /**
     * Récupère tous les points de rencontres de la
     *
     * @return array
     */
    function GetAllMeetPoint(): array
    {
        $arr = array();

        $s = "SELECT * FROM MEETPOINTS";
        $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        try {
            $statement->execute();
        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
        }

        while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
            $u = new MeetPoint($row["idMeetPoint"], $row["nameMeetPoint"], $row["adressMeetPoint"], $row["descriptionMeetPoint"], "");
            array_push($arr, $u);
        }

        return $arr;
    }
}