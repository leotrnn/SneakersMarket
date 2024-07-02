<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
Projet : TPI
Auteur : Léo Triano
Desc. : Site de Sneakers
Version : 1.0
Date : Mai 2024
Page : Controller de la page Detail
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

// Récupère le modèle
require("./src/Model/Constants.php");

require ('./src/Model/DetailModel.php');
require ('./src/Model/objects/Sneaker.php');
require ('./src/Model/objects/MeetPoint.php');


// Récupère les paramètres envoyés en get
if (filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)) {

    $idSneaker = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $addToFavorite = filter_input(INPUT_GET, 'favorite', FILTER_SANITIZE_STRING);
    $submit = filter_input(INPUT_POST, 'submit', FILTER_SANITIZE_STRING);
    $idMeetPoint = filter_input(INPUT_POST, 'meetPoint', FILTER_SANITIZE_NUMBER_INT);
    $meetingDate = filter_input(INPUT_POST, 'meetingDate', FILTER_SANITIZE_STRING);
    $formatted_datetime = date("Y-m-d H:i", strtotime($meetingDate));

    // Instancie un nouvel objet shop
    $detailInstance = new Detail();

    // Récupère toutes les paires
    $paire = $detailInstance->GetSneakerById($idSneaker);
    $isFavorite = "";
    $meetPoints = $detailInstance->GetAllMeetPoint();
    $errorMessages = [];


    // Si l'id ne correspond pas a une paire, retourner sur shop
    if (!$paire) {
        header("Location: index.php?url=Shop");
    }

    if (isset($_SESSION["idUser"])) {
        // Vérifie si la paire est en favorite ou non
        $isFavorite = $detailInstance->CheckIfFavorite($idSneaker, $_SESSION['idUser']);

        if ($addToFavorite == "yes") {
            if (!$isFavorite) {
                $detailInstance->AddToFavorite($idSneaker, $_SESSION['idUser']);
                $_SESSION["customMessage"] = "Sneaker added to favorites successfully";
            } else {
                $detailInstance->RemoveFromFavorite($idSneaker, $_SESSION['idUser']);
                $_SESSION["customMessage"] = "Sneaker removed from favorites successfully";
            }
            header("Location: index.php?url=Detail&id=" . $idSneaker);
            exit;
        }
    }

    if ($submit == "Reserve") {
        $errorMessages = $detailInstance->CheckErrorReserve($idMeetPoint, $formatted_datetime);
        if (empty($errorMessages)) {
            if (!$detailInstance->IsReserved($idSneaker)) {
                $detailInstance->Reserve($idSneaker, $idMeetPoint, $formatted_datetime);
                $_SESSION["customMessage"] = "Sneaker successfully reserved";
            }
            else{
                $_SESSION["customError"] = "We're sorry, another user already reserved this pair";
            }
            header("Location: index.php?url=Detail&id=" . $idSneaker);
            exit;
        }
    } else if ($submit == "Cancel") {
        if ($detailInstance->IsReserved($idSneaker)) {
            if($detailInstance->doesUserHasReserved($idSneaker)){
                $detailInstance->CancelReserve($idSneaker);
                $_SESSION["customMessage"] = "Reservation successfully canceled";
            }
        }
        header("Location: index.php?url=Detail&id=" . $idSneaker);
        exit;
    }

    // Récupère la vue
    require ('./src/View/DetailView.php');
} else {
    header("Location: index.php?url=Shop");
}


if (isset($_SESSION["customMessage"])) {
    $_SESSION["customMessage"] = "";
}

if (isset($_SESSION["customError"])) {
    $_SESSION["customError"] = "";
}


