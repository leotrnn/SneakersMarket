<?php

if (!isset($_SESSION['idUser'])) {
    header("Location: index.php?url=Home");
    exit;
}
require ("./src/Model/Constants.php");

require ('./src/Model/GestionModel.php');

require ('./src/Model/objects/Brand.php');
require ('./src/Model/objects/Modele.php');
require ('./src/Model/objects/Sneaker.php');
require ('./src/Model/objects/User.php');
require ('./src/Model/objects/MeetPoint.php');
require ('./src/Model/objects/ViewTransaction.php');




$gestionIsntance = new Gestion();

$marques = $gestionIsntance->GetAllBrands();
$modeles = $gestionIsntance->GetAllModeles();

$size = filter_input(INPUT_POST, 'size', FILTER_SANITIZE_NUMBER_INT);
$price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT);
$desc = filter_input(INPUT_POST, 'desc', FILTER_SANITIZE_STRING);
$idBrand = filter_input(INPUT_POST, 'brand', FILTER_SANITIZE_NUMBER_INT);
$modele = filter_input(INPUT_POST, 'modele', FILTER_SANITIZE_STRING);
$submit = filter_input(INPUT_POST, 'submit', FILTER_SANITIZE_STRING);
$idSneaker = filter_input(INPUT_GET, 'idSneaker', FILTER_VALIDATE_INT);
$statut = filter_input(INPUT_POST, 'statut', FILTER_VALIDATE_INT);

$errorMessages = [];

$tabPairesEnVente = $gestionIsntance->GetAllShoesInSale();
$tabPairesAchetees = $gestionIsntance->GetAllShoesPurchased();
$arrSneakersReserved = $gestionIsntance->GetAllShoesReserved();
$sneakersReserved = $gestionIsntance->SneakersReserved();
$sneakersSold = $gestionIsntance->SneakersSold();

switch ($submit) {
    case "Create":
        $errorMessages = $gestionIsntance->CheckErrorsCreateTransaction($size, $price, $_FILES["img"], $desc, $modele, $idBrand);
        if (empty($errorMessages)) {
            $gestionIsntance->CreateTransaction($size, $price, $_FILES["img"], $desc, $modele, $idBrand, $statut);
            $_SESSION["customMessage"] = "Transaction added with success";
            header("Location: index.php?url=Gestion");
            exit;
        }
        break;
    case "Cancel":
        $idSneaker = filter_input(INPUT_POST, 'idSneaker', FILTER_SANITIZE_NUMBER_INT);

        if ($gestionIsntance->CancelReserve($idSneaker)) {
            $_SESSION["customMessage"] = "Reservation successfully removed";
            header("Location: index.php?url=Gestion#reservations");
            exit;
        }
        break;

    case "Accept":
        $idSneaker = filter_input(INPUT_POST, 'idSneaker', FILTER_SANITIZE_NUMBER_INT);
        if ($gestionIsntance->AcceptReservation($idSneaker)) {
            $_SESSION["customMessage"] = "Sneaker successfully sold";
            header("Location: index.php?url=Gestion#reserved");
            exit;
        }
        break;

    case "Deny":
        $idSneaker = filter_input(INPUT_POST, 'idSneaker', FILTER_SANITIZE_NUMBER_INT);
        if ($gestionIsntance->DenyReservation($idSneaker)) {
            $gestionIsntance->RemoveFavoritesSneakerSold($idSneaker);
            $_SESSION["customMessage"] = "purchase offer successfully canceled";
            header("Location: index.php?url=Gestion#reserved");
            exit;
        }
        break;

    case "Set to Visible":
        $idSneaker = filter_input(INPUT_POST, 'idSneaker', FILTER_SANITIZE_NUMBER_INT);
        $gestionIsntance->SetSneakerToVisible($idSneaker);

        $_SESSION["customMessage"] = "Sneaker successfully set to visible";
        header("Location: index.php?url=Gestion#sale");
        exit;
}

if (isset($_GET["remove"]) && isset($_GET["idSneaker"])) {
    $idSneaker = filter_input(INPUT_GET, 'idSneaker', FILTER_SANITIZE_NUMBER_INT);

    $gestionIsntance->RemoveSneakerInSale($idSneaker);
    $_SESSION["customMessage"] = "Sneaker successfully removed";
    header("Location: index.php?url=Gestion#sale");
    exit;
}

require ('./src/Controller/headerController.php');
include ('./src/View/GestionView.php');

if ($_SESSION["customMessage"] != "") {
    $_SESSION["customMessage"] = "";
}
