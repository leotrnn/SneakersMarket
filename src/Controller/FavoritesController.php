<?php

if (!isset($_SESSION['idUser'])) {
    header("Location: index.php?url=Home");
    exit;
}
require("./src/Model/Constants.php");

require ('./src/Model/FavoritesModel.php');

require ('./src/Model/objects/Brand.php');
require ('./src/Model/objects/Modele.php');
require ('./src/Model/objects/Sneaker.php');
require ('./src/Model/objects/User.php');
require ('./src/Model/objects/MeetPoint.php');
require ('./src/Model/objects/ViewTransaction.php');


$favoritesInstance = new Favorites();
$userFavList = $favoritesInstance->UserFavList();
$idSneaker = filter_input(INPUT_GET, 'idSneaker', FILTER_SANITIZE_NUMBER_INT);

if (isset($_GET["favorite"])) {
    $favoritesInstance->RemoveFromFavorite($idSneaker, $_SESSION['idUser']);
    $_SESSION["customMessage"] = "Sneaker removed from favorites successfully";
    header("Location: index.php?url=Favorites");
    exit;
}

// Pagination des paires, tuto suivi et adapté au besoin
// https://nouvelle-techno.fr/articles/mettre-en-place-une-pagination-en-php
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $currentPage = (int) $_GET['page'];
} else {
    $currentPage = 1;
}

$nbArticles = $favoritesInstance->CountSneakers();
$parPage = 10;
$pages = ceil($nbArticles / $parPage);
$premier = ($currentPage * $parPage) - $parPage;

require ('./src/Controller/headerController.php');
include ('./src/View/FavoritesView.php');

if(isset($_SESSION["customMessage"])){
    $_SESSION["customMessage"] = "";
}