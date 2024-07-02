<?php

require("./src/Model/Constants.php");
include('./src/Controller/headerController.php');

$headerInstance = new Header();
$search = "";

if(isset($_GET["search"])){
    $search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);
    $search = Constants::AntiXSS($search);

    if(isset($_GET['page']) && !empty($_GET['page'])){
        $currentPage = (int)$_GET['page'];
    }else{
        $currentPage = 1;
    }

    $nbArticles = $headerInstance->CountSneakers($search);
    $parPage = 10;
    $pages = ceil($nbArticles / $parPage);
    $premier = ($currentPage * $parPage) - $parPage;

    $tabPairesCards = $headerInstance->SearchBar($search, $premier, $parPage);
}
else{
    header("Location: index.php?url=Home");
}

include('./src/View/ResultSearchView.php');