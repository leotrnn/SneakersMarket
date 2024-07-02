<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sneakers Market</title>
    <link rel="icon" type="image/x-icon" href="./src/View/img/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paper.js/0.12.15/paper-full.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="./src/View/css/global.css">
    <link rel="stylesheet" href="./src/View/css/auth.css">
</head>

<body>
    <section class="productCard">
        <div class="container">
            <div class="animation1 slide-right">
                <canvas id="canvas" class="canvas-back"></canvas>
            </div>
            <div class="info">
                <a href="index.php?url=Home" class="goBackLink"><i class="fa fa-arrow-circle-left"></i> Home</a>

                <form action="index.php?url=Auth&slide=right" method="post" class="formulaire" enctype="multipart/form-data">
                    <img src="./src/View/img/logo.png" class="logoLogin" alt="logo">
                    <h1 class="titleForm">Register</h1>
                    <div class="ligne">
                        <p class="errorNameRegister">
                            <?= (isset($errorMessages["errorName"])) ? $errorMessages["errorName"] : "" ?>
                        </p>
                        <p class="errorSurnameRegister">
                            <?= (isset($errorMessages["errorSurname"])) ? $errorMessages["errorSurname"] : "" ?>
                        </p>
                        <p class="errorSchoolRegister">
                            <?= (isset($errorMessages["errrorSchoolRegister"])) ? $errorMessages["errrorSchoolRegister"] : "" ?>
                        </p>
                    </div>
                    <div class="ligne">
                        <input type="text" name="name" class="name" placeholder="Name" autocomplete="off"
                            value="<?= $nameUser ?>">
                        <input type="text" name="surname" class="surname" placeholder="Surname" autocomplete="off"
                            value="<?= $surnameUser ?>">
                        <select name="school" class="school">
                            <option value="-1" class="optionSize">Select School</option>
                            <?php foreach ($schools as $key => $value) { ?>
                                <option value="<?= $value->idSchool ?>" class="optionSize" <?= ($idSchool == $value->idSchool) ? "selected" : "" ?>><?= $value->nameSchool ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <br>
                    <div class="ligne">
                        <p class="errorEmailRegister">
                            <?= (isset($errorMessages["errorEmailRegister"])) ? $errorMessages["errorEmailRegister"] : "" ?>
                        </p>
                        <p class="errorPasswordRegister">
                            <?= (isset($errorMessages["errorPasswordRegister"])) ? $errorMessages["errorPasswordRegister"] : "" ?>
                        </p>
                        <p class="errorPasswordRegister">
                            <?= (isset($errorMessages["errorImg"])) ? $errorMessages["errorImg"] : "" ?>
                        </p>
                    </div>
                    <div class="ligne">
                        <input type="email" name="email" class="email" placeholder="Email" autocomplete="off"
                            value="<?= $emailUser ?>">
                        <input type="password" name="password" class="passwordRegister" placeholder="Password">
                        <div class="imgDiv">
                        <input type="file" name="img" class="selectImg" id="">
                        </div>
                    </div>
                    <div class="submitDiv">
                        <input type="submit" value="Submit" name="submitRegister" class="submitLogin">
                        <a href="#" class="loginLink">Login</a>
                    </div>
                </form>
            </div>
            <div class="info">
                <a href="index.php?url=Home" class="goBackLink"><i class="fa fa-arrow-circle-left"></i> Home</a>

                <form action="index.php?url=Auth&slide=left" method="post" class="formulaire">
                    <img src="./src/View/img/logo.png" class="logoLogin" alt="logo">
                    <h1 class="titleForm">Login</h1>
                    <p class="errorLogin">
                        <?= (isset($errorMessages["errorLogin"])) ? $errorMessages["errorLogin"] : "" ?>
                    </p>
                    <input type="email" name="email" class="email" placeholder="Email" autocomplete="off"
                        value="<?= $emailUser ?>">
                    <input type="password" name="password" class="password" placeholder="Password">
                    <div class="submitDiv">
                        <input type="submit" value="Submit" name="submitLogin" class="submitLogin">
                        <a href="#" class="registerLink">Register</a>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script src="./src/View/js/auth.js"></script>

</body>

</html>