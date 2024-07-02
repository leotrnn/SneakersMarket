<?php

if (!isset($_SESSION['idUser']) || $_SESSION['idRole'] != 2) {
    header("Location: index.php?url=Home");
    exit;
}

require("./src/Model/Constants.php");

require ('./src/Model/ManageUserModel.php');
require ('./src/Model/objects/Sneaker.php');
require ('./src/Model/objects/User.php');
require ('./src/Model/objects/ViewTransaction.php');
require ('./src/Model/objects/MeetPoint.php');



$idUser = filter_input(INPUT_GET, 'idUser', FILTER_SANITIZE_NUMBER_INT);
$manageUserInstance = new ManageUser();

$currentPageSneaker = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$parPageSneaker = 10;
$currentPageSneaker = isset($_GET['pageSneaker']) ? (int) $_GET['pageSneaker'] : 1;
$nbSneakers = $manageUserInstance->CountSneakers($idUser);
$pagesSneaker = ceil($nbSneakers / $parPageSneaker);
$premierSneaker = ($currentPageSneaker * $parPageSneaker) - $parPageSneaker;

$currentUser = $manageUserInstance->GetUserById($idUser);
$shoesInSale = $manageUserInstance->GetAllShoesInSale($idUser, $premierSneaker, $parPageSneaker);
$sneakersSold = $manageUserInstance->SneakersSold($idUser);

if(!$currentUser || $idUser == ""){
    header("Location: index.php?url=Home");
    exit;
}


if (isset($_GET["remove"]) && isset($_GET["idSneaker"])) {
    $idSneaker = filter_input(INPUT_GET, 'idSneaker', FILTER_SANITIZE_NUMBER_INT);
    $manageUserInstance->RemoveSneakerInSale($idSneaker);
    $_SESSION["customMessage"] = "aaaaaSneaker successfully removed";
    header("Location: index.php?url=ManageUser&idUser=".$idUser);
    exit;
}


// Récupère la vue
require ('./src/Controller/headerController.php');
require ('./src/View/ManageUserView.php');
