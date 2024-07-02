<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sneakers Market</title>
    <link rel="stylesheet" href="./src/View/css/global.css">
    <link rel="stylesheet" href="./src/View/css/home.css">
    <link rel="stylesheet" href="./src/View/css/detail.css">
    <link rel="stylesheet" href="./src/View/css/header.css">
    <link rel="stylesheet" href="./src/View/css/auth.css">
    <link rel="stylesheet" href="./src/View/css/about.css">
    <link rel="stylesheet" href="./src/View/css/gestion.css">
    <link rel="stylesheet" href="./src/View/css/profile.css">
    <link rel="stylesheet" href="./src/View/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="your-integrity-hash" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="./src/View/img/logo.png">
</head>

<body>
    <header>
        <div class="headerNav">
            <nav>
                <ul>
                    <li><a href="index.php?url=Home"><img src="./src/View/img/logo.png" class="logoHeader"
                                alt="logo"></a></li>
                    <li><a class="navA" href="index.php?url=Home">Home</a></li>
                    <?php if (isset($_SESSION["idUser"])) { ?>
                        <li><a class="navA" href="index.php?url=Gestion">Dashboard</a></li>
                        <li><a class="navA" href="index.php?url=Favorites">Favorites</a></li>
                    <?php } ?>
                    <li><a class="navA" href="index.php?url=About">About</a></li>

                    <?php if (isset($_SESSION["idRole"])) {
                        if ($_SESSION["idRole"] == 2) { ?>
                            <li><a class="navA" href="index.php?url=Admin">Admin</a></li><?php }
                    } ?>
                    <?php if (isset($_SESSION['idUser'])) { ?>
                        <li><a class="navA" href="index.php?url=Logout">Logout</a></li>

                    <?php } else { ?>
                        <li><a class="navA" href="index.php?url=Auth">Login</a></li>

                    <?php } ?>
                </ul>
                <ul>
                    <li class="searchBarLi">
                        <form action="" method="post">
                            <input type="text" name="searchBar" class="searchBar" placeholder="Search by name..."
                                autocomplete="off">
                        </form>

                    </li>
                    <li>
                        <?php if (isset($_SESSION["surnameUser"])) { ?>
                            <a class="navA linkProfile" href="index.php?url=Profile">
                                <p><?= $_SESSION["surnameUser"] ?></p>
                                <img src="<?= (isset($_SESSION['imgUser']) && $_SESSION["imgUser"] != "") ? $_SESSION['imgUser'] : "./src/View/img/anonymous.png" ?>" class="avatarHeader" alt="Avatar">
                            </a>
                        <?php } else { ?>
                            <p class="nameUser">Anonymous</p>
                            <img src="./src/View/img/anonymous.png" class="avatarHeader" alt="Avatar">
                        <?php } ?>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <p class="customMessages customSuccess"><?= (isset($_SESSION['customMessage'])) ? $_SESSION['customMessage'] : "" ?>
    </p>
    <p class="customMessages customError"><?= (isset($_SESSION['customError'])) ? $_SESSION['customError'] : "" ?></p>