<div class="anchors">
    <h1>Navigation</h1>
    <a href="#users">Manage users</a>
    <br>
    <a href="#addU">Add an user</a>
    <br>
    <a href="#sneakers">Manage sneakers</a>
    <hr>
    <a href="#schools">Manage schools</a>
    <br>
    <a href="#meetPoints">Manage meet points</a>
</div>
<a id="users"></a>
<h1 class="title">Manage users</h1>
<form action="index.php?url=Admin#users" method="post">
    <input type="text" name="searchBarUsers" class="searchBar searchBarUsers"
        placeholder="Search by name, surname or email..." autocomplete="off">
</form>
<div class="center">
    <?php if (!empty($users)) { ?>
        <?php foreach ($users as $user) { ?>
            <div class="card cardUsers">
                <a href="index.php?url=ManageUser&idUser=<?= $user->idUser ?>">

                    <img src="./src/View/img/logo.png" alt="logo" class="logo" />
                    <?php if ($user->imgUser != "") { ?>
                        <img class="imgSneaker imgUsers" src="<?= $user->imgUser ?>" />
                    <?php } else { ?>
                        <img src="./src/View/img/anonymous.png" alt="logo" class="imgSneaker imgUsers" />
                    <?php } ?>
                    <main class="main">
                        <div class="titre">
                            <h1 class="marqueModele">
                                <?= $user->nameUser ?>
                                <?= $user->surnameUser ?>
                            </h1>
                            <h1 class="h1Prix smaller"><span class="prix">
                                    <?= $adminInstance->GetSchoolFromId($user->idSchool)->nameSchool ?>
                                </span></h1>
                        </div>
                        <p class="h1Size"><?= $user->emailUser ?></p>
                </a>
                <div class="gestionUsers">
                    <form action="index.php?url=ModifyUser" method="post">
                        <input type="hidden" name="idUser" value="<?= $user->idUser ?>">
                        <input class="submit" type="submit" name="submit" value="Modify">
                    </form>
                    <form action="" class="" method="post">
                        <input type="hidden" name="idUser" value="<?= $user->idUser ?>">
                        <?php if ($adminInstance->CountUsersTransactions($user->idUser) > 0) { ?>
                            <?php if ($adminInstance->IsBlocked($user->idUser)) { ?>
                                <input class="submit green" type="submit" name="submit" value="Unblock">
                            <?php } else { ?>
                                <input class="submit red" type="submit" name="submit" value="Block">
                            <?php }
                        } else { ?>
                            <input class="submit red" type="submit" name="submit" value="Delete">

                        <?php } ?>
                    </form>
                </div>
                </main>
            </div>
        <?php } ?>
        <?php if ($pages > 1) { ?>

            <div class="pagination">
                <?php for ($i = 1; $i <= $pages; $i++) { ?>
                    <a class="<?= ($currentPage == $i) ? "currentPage" : "" ?>"
                        href="index.php?url=Admin&page=<?= $i ?>"><?= $i ?></a>
                <?php } ?>
            </div>
        <?php } ?>
    <?php } else { ?>
        <div class="centerGestion favoritesEmpty">
            <div class="cardGestion cardGestionFavorites">
                <h1 class="noFavorites">No user matches your search.</h1>
            </div>
        </div>
    <?php } ?>
</div>
<a id="addU"></a>
<h1 class="title">Add an user</h1>
<div class="centerGestion favoritesEmpty">
    <div class="cardGestion cardGestionFavorites">
        <form action="index.php?url=Admin#addU" method="post" class="formulaire" enctype="multipart/form-data">
            <div class="ligne">
                <p class="errorEmailRegister">
                    <?= (isset($errorMessages["errorName"])) ? $errorMessages["errorName"] : "" ?>
                </p>
                <p class="errorPasswordRegister">
                    <?= (isset($errorMessages["errorSurname"])) ? $errorMessages["errorSurname"] : "" ?>
                </p>
            </div>
            <div class="ligne">
                <input type="text" name="nameUser" class="name" placeholder="Name" autocomplete="off"
                    value="<?= $nameUser ?>">
                <input type="text" name="surnameUser" class="surname" placeholder="Surname" autocomplete="off"
                    value="<?= $surnameUser ?>">
            </div>
            <br>
            <div class="ligne">
                <p class="errorEmailRegister">
                    <?= (isset($errorMessages["errorEmailRegister"])) ? $errorMessages["errorEmailRegister"] : "" ?>
                </p>
                <p class="errorPasswordRegister">
                    <?= (isset($errorMessages["errorPasswordRegister"])) ? $errorMessages["errorPasswordRegister"] : "" ?>
                </p>
            </div>
            <div class="ligne">
                <input type="email" name="emailUser" class="email" placeholder="Email" autocomplete="off"
                    value="<?= $emailUser ?>">
                <input type="password" name="pwdUser" class="passwordRegister" placeholder="Password">
            </div>
            <br>
            <div class="ligne">
                <p class="errorPasswordRegister">
                    <?= (isset($errorMessages["errrorSchoolRegister"])) ? $errorMessages["errrorSchoolRegister"] : "" ?>
                </p>
                <p class="errorPasswordRegister">
                    <?= (isset($errorMessages["errorImg"])) ? $errorMessages["errorImg"] : "" ?>
                </p>
            </div>
            <div class="ligne">
                <select name="idSchool" class="school">
                    <option value="-1" class="optionSize">Select School</option>
                    <?php foreach ($schools as $key => $value) { ?>
                        <option value="<?= $value->idSchool ?>" class="optionSize" <?= ($idSchool == $value->idSchool) ? "selected" : "" ?>><?= $value->nameSchool ?></option>
                    <?php } ?>
                </select>
                <input type="file" name="imgUser" class="selectImg">
            </div>

            <input type="submit" value="Register" name="submit" class="submitLogin">
        </form>
    </div>
</div>
<a id="sneakers"></a>
<h1 class="title">Manage Sneakers</h1>
<div class="center">
    <?php if (!empty($shoesInSale)) { ?>
        <?php foreach ($shoesInSale as $sneaker) { ?>
            <div class="card">
                <img src="./src/View/img/logo.png" alt="logo" class="logo" />
                <img class="imgSneaker" src="<?= $sneaker->sneaker->imgSneaker ?>" />
                <main class="main">
                    <div class="titre">
                        <h1 class="marqueModele">
                            <?= $sneaker->sneaker->nameBrand ?>         <?= $sneaker->sneaker->nameModel ?>
                        </h1>
                        <h1><span class="prix">
                                <?= $sneaker->sneaker->priceSneaker ?>$
                            </span></h1>
                    </div>
                    <p class="h1Size">Size <?= $sneaker->sneaker->sizeSneaker ?></p>
                    <p class="description">
                        <?= html_entity_decode($sneaker->sneaker->descriptionSneaker) ?>
                    </p>
                    <br>
                </main>
                <div class="starGestion">
                    <div class="postedBy postedByGestion">
                        <?php if ($sneaker->vendeur->imgUser != "") { ?>
                            <img src="<?= $sneaker->vendeur->imgUser ?>" alt="avatar" class="avatar" />
                        <?php } else { ?>
                            <img src="./src/View/img/anonymous.png" alt="avatar" class="avatar" />
                        <?php } ?>
                        <p>Posted by <span><?= $sneaker->vendeur->surnameUser ?></span></p>
                    </div>
                    <!-- Ajoutez l'attribut data-id avec l'ID de la sneaker -->
                    <a class="linkStar linkStarGestion" href="#" data-id="<?= $sneaker->sneaker->idSneaker ?>">
                        <div class="invertedRemove"></div>
                    </a>
                </div>
            </div>
        <?php } ?>
        <?php if ($pagesSneaker > 1) { ?>
            <div class="pagination">
                <?php for ($i = 1; $i <= $pagesSneaker; $i++) { ?>
                    <a class="<?= ($currentPageSneaker == $i) ? "currentPage" : "" ?>"
                        href="index.php?url=Admin&pageSneaker=<?= $i ?>#sneakers"><?= $i ?></a>
                <?php } ?>
            </div>
        <?php } ?>
    <?php } else { ?>
        <div class="centerGestion favoritesEmpty">
            <div class="cardGestion cardGestionFavorites">
                <h1 class="noFavorites">There is no Sneaker in sale.</h1>
            </div>
        </div>
    <?php } ?>
</div>
<div id="confirmModal" class="modal">
    <div class="modal-content">
        <p>Are you sure you want to delete this sneaker?</p>
        <div class="modal-buttons">
            <button id="confirmDelete">Yes</button>
            <button id="cancelDelete">No</button>
        </div>
    </div>
</div>
<a id="schools"></a>
<h1 class="title">Manage schools</h1>
<div class="centerGestion favoritesEmpty">
    <div class="cardGestion cardGestionFavorites">
        <div class="errorMsg">
            <p><?= (isset($errorMsgCreateSchool["nameSchool"])) ? $errorMsgCreateSchool["nameSchool"] : "" ?></p>
            <p></p>
        </div>
        <form action="index.php?url=Admin#schools" method="post" class="addMeetPoint">
            <input type="text" name="nameSchool" placeholder="School's name" class="name" autocomplete="off"
                value="<?= $nameMeetPoint ?>">
            <input type="submit" class="submit" name="submit" value="Create school">
        </form>
        <table class="tableMeetPoints">
            <tr>
                <th>Name</th>
                <th>Action</th>
            </tr>
            <?php foreach ($adminInstance->GetAllSchools() as $key => $value) { ?>
                <form action="index.php?url=Admin#meetPoints" method="post">

                    <tr>
                        <th><input type="text" name="editNameSchool" class="name editInfoMeetPoint"
                                value="<?= $value->nameSchool ?>" autocomplete="off"></th>
                        <th>
                            <div class="submitMeetPoints">
                                <input type="hidden" name="idSchool" value="<?= $value->idSchool ?>">
                                <?php if (!$adminInstance->DoesSchoolHasUser($value->idSchool)) { ?>
                                    <input type="submit" name="submit" style="background-color: #dc3545;"
                                        class="submit removeSubmit" value="Remove school">
                                <?php } else { ?>
                                    <input type="submit" class="submit removeSubmit locked" value="Remove school" disabled>
                                <?php } ?>
                                <input type="submit" name="submit" class="submit" value="Edit school">
                            </div>
                        </th>
                    </tr>
                </form>

            <?php } ?>
        </table>
    </div>
</div>

<a id="meetPoints"></a>
<h1 class="title">Manage meet points</h1>
<div class="centerGestion favoritesEmpty">
    <div class="cardGestion cardGestionFavorites">
        <div class="errorMsg">
            <p><?= (isset($errorMessages["nameMeetPoint"])) ? $errorMessages["nameMeetPoint"] : "" ?></p>
            <p><?= (isset($errorMessages["adressMeetPoint"])) ? $errorMessages["adressMeetPoint"] : "" ?></p>
            <p><?= (isset($errorMessages["descriptionMeetPoint"])) ? $errorMessages["descriptionMeetPoint"] : "" ?></p>
            <p></p>
        </div>
        <form action="index.php?url=Admin#meetPoints" method="post" class="addMeetPoint">
            <input type="text" name="nameMeetPoint" placeholder="Meet point's name" class="name" autocomplete="off"
                autocomplete="off" value="<?= $nameMeetPoint ?>">
            <input type="text" name="adressMeetPoint" placeholder="Meet point's adress" class="name" autocomplete="off"
                autocomplete="off" value="<?= $adressMeetPoint ?>">
            <input type="text" name="descriptionMeetPoint" placeholder="Meet point's description" class="name"
                autocomplete="off" autocomplete="off" value="<?= $descriptionMeetPoint ?>">
            <input type="submit" class="submit" name="submit" value="Create meet point">
        </form>
        <table class="tableMeetPoints">
            <tr>
                <th>Name</th>
                <th>Adress</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
            <?php foreach ($adminInstance->GetAllMeetPoints() as $key => $value) { ?>
                <form action="index.php?url=Admin#meetPoints" method="post">

                    <tr>
                        <th><input type="text" name="editNameMeetPoint" class="name editInfoMeetPoint" autocomplete="off"
                                value="<?= html_entity_decode($value->nameMeetPoint) ?>"></th>
                        <th><input type="text" name="editAdressMeetPoint" class="name editInfoMeetPoint" autocomplete="off"
                                value="<?= html_entity_decode($value->adressMeetPoint) ?>"></th>
                        <th><input type="text" name="editDescriptionMeetPoint" class="name editInfoMeetPoint"
                                autocomplete="off" value="<?= html_entity_decode($value->descriptionMeetPoint) ?>"></th>
                        <th>
                            <div class="submitMeetPoints">
                                <input type="hidden" name="idMeetPoint" value="<?= $value->idMeetPoint ?>">
                                <?php if (!$adminInstance->DoesTransactionHasMeetPoint($value->idMeetPoint)) { ?>
                                    <input type="submit" name="submit" style="background-color: #dc3545;"
                                        class="submit removeSubmit" value="Remove meet point">
                                <?php } else { ?>
                                    <input type="submit" class="submit removeSubmit locked" value="Remove meet point" disabled>
                                <?php } ?>
                                <input type="submit" name="submit" class="submit" value="Edit meet point">
                            </div>
                        </th>
                    </tr>
                </form>

            <?php } ?>
        </table>
    </div>
</div>
<script src="./src/View/js/modal.js"></script>