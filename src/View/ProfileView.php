<section class="productCard">
    <div class="container">
        <div class="animation1 bgPreview">
            <h1 class="title">Preview</h1>
            <div class="center">
                <div class="card">
                    <img src="./src/View/img/logo.png" alt="logo" class="logo" />
                    <?php if (isset($_SESSION['imgUser']) && $_SESSION["imgUser"] != "") { ?>
                        <img class="imgSneaker imgProfile" src="<?= $_SESSION['imgUser'] ?>" />
                    <?php } else { ?>
                        <img class="imgSneaker imgProfile" src="./src/View/img/anonymous.png" />
                    <?php } ?>
                    <main class="main">
                        <div class="titre">
                            <h1 class="marqueModele">
                                <?= $_SESSION['nameUser'] ?>
                                <?= $_SESSION['surnameUser'] ?>
                            </h1>
                            <h1 class="h1Prix"><span class="prix">
                                    <?= $profileInstance->GetSchoolFromId($_SESSION['idSchool'])->nameSchool ?>
                                </span></h1>
                        </div>
                        <p class="h1Size"><?= $_SESSION["emailUser"] ?></p>
                    </main>
                    </a>
                </div>
            </div>
        </div>
        <div class="info">
            <form action="index.php?url=Profile" method="post" class="formulaire" enctype="multipart/form-data">
                <img src="./src/View/img/logo.png" class="logoLogin" alt="logo">
                <h1 class="titleForm">Profile</h1>
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
                        <?= (isset($errorMessages["errorImg"])) ? $errorMessages["errorImg"] : "" ?>
                    </p>
                </div>
                <div class="ligne">
                    <input type="email" name="email" class="email" placeholder="Email" autocomplete="off"
                        value="<?= $emailUser ?>">
                    <div class="imgDiv">
                        <input type="file" name="img" class="selectImg" onchange="previewFile()" id="">
                    </div>
                    <div class="imgDiv">
                        <input type="submit" class="submitTransaction" name="submitRegister" value="Delete profile picture">
                    </div>
                </div>
                <div class="submitDiv">
                    <input type="submit" value="Submit" name="submitRegister" class="submitLogin">
                </div>
            </form>
        </div>
        <div class="info">
        </div>
    </div>
</section>
</body>
<script src="./src/View/js/previewImg.js"></script>

</html>