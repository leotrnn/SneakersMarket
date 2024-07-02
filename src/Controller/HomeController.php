<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
Projet : TPI
Auteur : Léo Triano
Desc. : Site de Sneakers
Version : 1.0
Date : Mai 2024
Page : Controller de la page Shop
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */



// Récupère le modèle
require("./src/Model/Constants.php");

require ('./src/Model/HomeModel.php');
require ('./src/Model/objects/Sneaker.php');
require ('./src/Model/objects/User.php');
require ('./src/Model/objects/ViewTransaction.php');
require ('./src/Model/objects/Brand.php');
require ('./src/Model/objects/MeetPoint.php');




// Instancie un nouvel objet shop
$homeInstance = new Home();

// Récupère toutes les paires
$marques = $homeInstance->GetAllBrands();
$sizes = $homeInstance->GetAllSizes();


$idBrand = filter_input(INPUT_GET, 'marques', FILTER_SANITIZE_NUMBER_INT);
$idSize = filter_input(INPUT_GET, 'sizes', FILTER_SANITIZE_NUMBER_INT);


// Pagination des paires, tuto suivi et adapté au besoin
// https://nouvelle-techno.fr/articles/mettre-en-place-une-pagination-en-php
if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = (int)$_GET['page'];
}else{
    $currentPage = 1;
}

$nbArticles = $homeInstance->CountSneakers($idBrand);
$parPage = 10;
$pages = ceil($nbArticles / $parPage);
$premier = ($currentPage * $parPage) - $parPage;


$tabPairesCards = $homeInstance->GetAllSneakers($premier, $parPage);

if($idBrand != ""){
    $tabPairesCards = $homeInstance->FilterByBrand($idBrand, $premier, $parPage, $idSize);
}

// Récupère la vue
require('./src/Controller/headerController.php');
require ('./src/View/HomeView.php');

if(isset($_SESSION["customMessage"])){
    $_SESSION["customMessage"] = "";
}