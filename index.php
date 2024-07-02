<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
Projet : SneakersMarket (TPI)
Auteur : Léo Triano
Desc. : Site d'achat-revente de sneakers
Version : 1.0
Date : Mai 2024
Page : Page index qui gère toutes les redirections grâce aux paramètre url passé en get
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

session_start();

require_once ("src/Model/database.php");

// Tableau qui contiendra toutes les redirections possibles
$possibleRedirections = [];

// Tableau qui contient toutes les fichiers à ignorer
$ignoredFiles = [/* Ajouter les fichiers à la main */];

// Récupérer tous les fichiers Controller
$files = glob('src/Controller/*Controller.php');

foreach ($files as $file) {

    // Supprimer le chemin de fichier pour garder que le nom
    $file = str_replace("src/Controller/", "", $file);
    $file = str_replace("Controller.php", "", $file);

    // Vérifier si ce n'est pas un fichier à ignorer
    if (!in_array($file, $ignoredFiles)) {
        // Ajouter la redirection au tableau
        $possibleRedirections[] = $file;
    }
}

// Vérifier si on ressoit le paramètre url en get, sinon mettre la redirection par défaut à Home
$redirection = (isset($_GET["url"])) ? filter_input(INPUT_GET, 'url', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : "Home";

// Vérifier si la redirection est une redirection autorisée, sinon renvoyer à home
$redirection = (!in_array($redirection, $possibleRedirections)) ? "Home" : $redirection;

// Rediriger
foreach ($possibleRedirections as $key) {
    if ($redirection == $key) {
        require_once ("src/Controller/" . $key . "Controller.php");
    }
}