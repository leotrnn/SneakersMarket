<?php

if (!isset($_SESSION['idUser']) || $_SESSION['idRole'] != 2) {
    header("Location: index.php?url=Home");
    exit;
}
require ("./src/Model/Constants.php");

require ('./src/Model/AdminModel.php');
require ('./src/Model/objects/User.php');
require ('./src/Model/objects/Sneaker.php');
require ('./src/Model/objects/ViewTransaction.php');
require ('./src/Model/objects/MeetPoint.php');

require ('./src/Model/AuthModel.php');
require ('./src/Model/objects/School.php');


// Validation des données d'entrée
$searchBarUsers = filter_input(INPUT_POST, 'searchBarUsers', FILTER_SANITIZE_STRING);
$idUser = filter_input(INPUT_POST, 'idUser', FILTER_SANITIZE_NUMBER_INT);
$submit = filter_input(INPUT_POST, 'submit', FILTER_SANITIZE_STRING);
$nameUser = filter_input(INPUT_POST, 'nameUser', FILTER_SANITIZE_STRING);
$surnameUser = filter_input(INPUT_POST, 'surnameUser', FILTER_SANITIZE_STRING);
$emailUser = filter_input(INPUT_POST, 'emailUser', FILTER_SANITIZE_STRING);
$pwdUser = filter_input(INPUT_POST, 'pwdUser', FILTER_SANITIZE_STRING);
$idSchool = filter_input(INPUT_POST, 'idSchool', FILTER_SANITIZE_NUMBER_INT);
$nameMeetPoint = filter_input(INPUT_POST, 'nameMeetPoint', FILTER_SANITIZE_STRING);
$adressMeetPoint = filter_input(INPUT_POST, 'adressMeetPoint', FILTER_SANITIZE_STRING);
$descriptionMeetPoint = filter_input(INPUT_POST, 'descriptionMeetPoint', FILTER_SANITIZE_STRING);
$idMeetPoint = filter_input(INPUT_POST, 'idMeetPoint', FILTER_SANITIZE_NUMBER_INT);

$editNameMeetPoint = filter_input(INPUT_POST, 'editNameMeetPoint', FILTER_SANITIZE_STRING);
$editAdressMeetPoint = filter_input(INPUT_POST, 'editAdressMeetPoint', FILTER_SANITIZE_STRING);
$editDescriptionMeetPoint = filter_input(INPUT_POST, 'editDescriptionMeetPoint', FILTER_SANITIZE_STRING);

$editNameSchool = filter_input(INPUT_POST, 'editNameSchool', FILTER_SANITIZE_STRING);
$nameSchool = filter_input(INPUT_POST, 'nameSchool', FILTER_SANITIZE_STRING);


// Création d'instances
$adminInstance = new Admin();
$authInstance = new Auth();

$errorMessages = [];
$schools = $authInstance->GetAllSchools();

// Logique de pagination
$currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$parPage = 8;

// Logique de pagination pour les utilisateurs
$nbArticles = $adminInstance->CountUsers($searchBarUsers);
$pages = ceil($nbArticles / $parPage);
$premier = ($currentPage * $parPage) - $parPage;

$users = $adminInstance->GetAllUsers($searchBarUsers, $premier, $parPage);

// Logique de pagination pour les sneakers
$parPageSneaker = 10;
$currentPageSneaker = isset($_GET['pageSneaker']) ? (int) $_GET['pageSneaker'] : 1;
$nbSneakers = $adminInstance->CountSneakers();
$pagesSneaker = ceil($nbSneakers / $parPageSneaker);
$premierSneaker = ($currentPageSneaker * $parPageSneaker) - $parPageSneaker;

$shoesInSale = $adminInstance->GetAllShoesInSale($premierSneaker, $parPageSneaker);

switch ($submit) {
    case "Block":
        if ($adminInstance->BlockUser($idUser)) {
            $_SESSION["customMessage"] = "User successfully blocked";
            header("Location: index.php?url=Admin#users");
            exit;
        }
        break;

    case "Delete":
        if ($adminInstance->RemoveBuyingOffers($idUser)) {
            if ($adminInstance->DeleteUser($idUser)) {
                $_SESSION["customMessage"] = "User successfully deleted";
                header("Location: index.php?url=Admin#users");
                exit;
            }
        }
        break;

    case "Unblock":
        if ($adminInstance->UnblockUser($idUser)) {
            $_SESSION["customMessage"] = "User successfully unblocked";
            header("Location: index.php?url=Admin#users");
            exit;
        }
        break;

    case "Register":
        $user = new User(0, $nameUser, $surnameUser, $emailUser, $pwdUser);
        $errorMessages = $authInstance->ErrorMessagesRegister($user, $idSchool, $_FILES["imgUser"]);
        if (empty($errorMessages)) {
            $authInstance->Register($user, $idSchool, $_FILES["imgUser"]);
            $_SESSION["customMessage"] = "User created successfully";
            header("Location: index.php?url=Admin#addU");
            exit;
        }
        break;

    case "Create meet point":

        $meetPoint = new MeetPoint(0, $nameMeetPoint, $adressMeetPoint, $descriptionMeetPoint);

        $errorMessages = $adminInstance->ErrorCreateMeetPoint($meetPoint);

        if (empty($errorMessages)) {
            if ($adminInstance->CreateMeetPoint($meetPoint)) {
                $_SESSION["customMessage"] = "Meet point created successfully";
                header("Location: index.php?url=Admin#meetPoints");
                exit;
            }
        }
        break;

    case "Remove meet point":
        if ($adminInstance->RemoveMeetPoint($idMeetPoint)) {
            $_SESSION["customMessage"] = "Meet point removed Successfully";
            header("Location: index.php?url=Admin#meetPoints");
            exit;
        }
        break;

    case "Edit meet point":
        $meetPoint = new MeetPoint($idMeetPoint, $editNameMeetPoint, $editAdressMeetPoint, $editDescriptionMeetPoint);
        $erorrMsg = $adminInstance->ErrorEditMeetPoint($meetPoint);
        if (empty($erorrMsg)) {
            if ($adminInstance->EditMeetPoint($meetPoint)) {
                $_SESSION["customMessage"] = "Meet point edited Successfully";
                header("Location: index.php?url=Admin#meetPoints");
                exit;
            }
        } else {
            $_SESSION["customError"] = "Meet points' informations are incorrect";
            header("Location: index.php?url=Admin#meetPoints");
            exit;
        }

        break;

    case "Remove school":
        if ($adminInstance->RemoveSchool($idSchool)) {
            $_SESSION["customMessage"] = "School removed Successfully";
            header("Location: index.php?url=Admin#schools");
            exit;
        }
        break;

    case "Edit school":
        $school = new school($idSchool, $editNameSchool);
        $erorrMsgEditSchool = $adminInstance->ErrorEditSchool($school);
        if (empty($erorrMsgEditSchool)) {
            if ($adminInstance->EditSchool($school)) {
                $_SESSION["customMessage"] = "School edited Successfully";
                header("Location: index.php?url=Admin#schools");
                exit;
            }
        } else {
            $_SESSION["customError"] = "School' informations are incorrect";
            header("Location: index.php?url=Admin#schools");
            exit;
        }
        break;

    case "Create school":
        $school = new school(0, $nameSchool);
        $errorMsgCreateSchool = $adminInstance->ErrorCreateSchool($school);

        if (empty($errorMsgCreateSchool)) {
            if ($adminInstance->CreateSchool($school)) {
                $_SESSION["customMessage"] = "School created successfully";
                header("Location: index.php?url=Admin#schools");
                exit;
            }
        }
        break;
}

if (isset($_GET["remove"]) && isset($_GET["idSneaker"])) {
    $idSneaker = filter_input(INPUT_GET, 'idSneaker', FILTER_SANITIZE_NUMBER_INT);
    $adminInstance->RemoveSneakerInSale($idSneaker);
    $_SESSION["customMessage"] = "Sneaker successfully removed";
    header("Location: index.php?url=Admin#sneakers");
    exit;
}

require ('./src/Controller/headerController.php');
require ('./src/View/AdminView.php');

if (isset($_SESSION["customMessage"])) {
    $_SESSION["customMessage"] = "";
}

if (isset($_SESSION["customError"])) {
    $_SESSION["customError"] = "";
}