<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
Projet : TPI
Auteur : Léo Triano
Desc. : Site de Sneakers
Version : 1.0
Date : Mai 2024
Page : Controller de la page Login
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */



// Récupère le modèle
require("./src/Model/Constants.php");

require("./src/Model/objects/User.php");
require("./src/Model/objects/School.php");
require ('./src/Model/AuthModel.php');


// Instancie un nouvel objet shop
$authInstance = new Auth();

$nameUser = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$emailUser= filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
$pwdUser = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
$surnameUser = filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_STRING);
$idSchool = filter_input(INPUT_POST, 'school', FILTER_VALIDATE_INT);

$submitRegister = filter_input(INPUT_POST, 'submitRegister', FILTER_SANITIZE_STRING);
$submitLogin = filter_input(INPUT_POST, 'submitLogin', FILTER_SANITIZE_STRING);

$user = new User();
$errorMessages = [];
$schools = $authInstance->GetAllSchools();


if($submitRegister == "Submit"){
    $user = new User(0, $nameUser, $surnameUser, $emailUser, $pwdUser);

    $errorMessages = $authInstance->ErrorMessagesRegister($user, $idSchool, $_FILES['img']);

    if(empty($errorMessages)){
        $authInstance->Register($user, $idSchool, $_FILES["img"]);
        $img = Constants::ConvertImgTo64($_FILES["img"]);
        $authInstance->ValuesSession(new User(Database::lastInsertId(), $nameUser, $surnameUser, $emailUser, "", $idSchool, $img));
        header("Location: index.php?url=Home");
    }
}
else if ($submitLogin == "Submit"){
    $user = new User(0, "", "", $emailUser, $pwdUser);

    $errorMessages = $authInstance->ErrorMessagesLogin($user);

    if(empty($errorMessages)){
        $authInstance->login($user->emailUser);
        header("Location: index.php?url=Home");
    }
}

// Récupère la vue
require ('./src/View/AuthView.php');





