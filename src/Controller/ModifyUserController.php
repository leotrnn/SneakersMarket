<?php

if (!isset($_SESSION['idUser']) || $_SESSION['idRole'] != 2) {
    header("Location: index.php?url=Home");
    exit;
}

// Récupère le modèle
require("./src/Model/Constants.php");

require ('./src/Model/ModifyUserModel.php');
require ('./src/Model/objects/School.php');
require ('./src/Model/objects/User.php');



$modifyUserInstance = new ModifyUser();
$schools = $modifyUserInstance->GetAllSchools();
$idUser = filter_input(INPUT_POST, 'idUser', FILTER_SANITIZE_NUMBER_INT);
$submit = filter_input(INPUT_POST, 'submitRegister', FILTER_SANITIZE_STRING);
$errorMessages = [];


if ($idUser == "" || !$modifyUserInstance->DoesUserExist($idUser)) {
    header("Location: index.php?url=Home");
} else {
    $idSchool = $modifyUserInstance->GetUserById($idUser)->idSchool;
    $idUser = $modifyUserInstance->GetUserById($idUser)->idUser;
    $nameUser = $modifyUserInstance->GetUserById($idUser)->nameUser;
    $emailUser = $modifyUserInstance->GetUserById($idUser)->emailUser;
    $surnameUser = $modifyUserInstance->GetUserById($idUser)->surnameUser;
    $imgUtilisateur = $modifyUserInstance->GetUserById($idUser)->imgUser;
}


if ($submit == "Submit") {
    $idSchool = filter_input(INPUT_POST, 'school', FILTER_VALIDATE_INT);
    $nameUser = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $emailUser = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $surnameUser = filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_STRING);

    $user = new User($idUser, $nameUser, $surnameUser, $emailUser, "", $idSchool);
    $errorMessages = $modifyUserInstance->ErrorMessagesRegister($user, $idSchool, $_FILES["img"]);
    if (empty($errorMessages)) {
        if ($modifyUserInstance->UpdateProfile($user, $_FILES["img"])) {
            $_SESSION["customMessage"] = "User's profile updated successfully";
            header("Location: index.php?url=Admin");
            exit;
        }
    }

}

// Récupère la vue
require ('./src/Controller/headerController.php');
require ('./src/View/ModifyUserView.php');
