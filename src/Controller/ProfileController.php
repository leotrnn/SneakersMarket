<?php

if (!isset($_SESSION['idUser'])) {
    header("Location: index.php?url=Home");
    exit;
}

require ("./src/Model/Constants.php");

require ('./src/Model/ProfileModel.php');
require ('./src/Model/objects/School.php');
require ('./src/Model/objects/User.php');


$profileInstance = new Profile();
$schools = $profileInstance->GetAllSchools();
$submitRegister = filter_input(INPUT_POST, 'submitRegister', FILTER_SANITIZE_STRING);
$errorMessages = [];

$idSchool = $_SESSION['idSchool'];
$nameUser = $_SESSION['nameUser'];
$surnameUser = $_SESSION['surnameUser'];
$emailUser = $_SESSION['emailUser'];

if ($submitRegister == "Submit") {
    $idSchool = filter_input(INPUT_POST, 'school', FILTER_VALIDATE_INT);
    $nameUser = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $emailUser = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $surnameUser = filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_STRING);


    $user = new User($_SESSION['idUser'], $nameUser, $surnameUser, $emailUser, "", $idSchool);

    $errorMessages = $profileInstance->ErrorMessagesRegister($user, $idSchool, $_FILES['img']);
    if (empty($errorMessages)) {
        if ($profileInstance->UpdateProfile($user, $_FILES["img"])) {
            $_SESSION["customMessage"] = "Profile updated successfully";
            header("Location: index.php?url=Profile");
        }
    }
} else if ($submitRegister == "Delete profile picture") {
    $profileInstance->DeleteProfilePicture();

    $_SESSION["customMessage"] = "Profile updated successfully";
    header("Location: index.php?url=Profile");
}

require ('./src/Controller/headerController.php');

require ('./src/View/ProfileView.php');

if (isset($_SESSION["customMessage"]) && $submitRegister == "") {
    $_SESSION["customMessage"] = "";
}

