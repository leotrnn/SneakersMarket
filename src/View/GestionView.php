<div class="anchors">
    <h1>Navigation</h1>
    <?php if ($gestionIsntance->IsUserNotBlocked()) { ?>
        <a href="#CTransaction">Sell a sneaker</a>
        <hr>

        <a href="#sale">My Sneakers</a>
        <br>
    <?php } ?>
    <a href="#reservations">My reservations</a>
    <br>
    <a href="#purchases">My purchases</a>
    <hr>
    <?php if ($gestionIsntance->IsUserNotBlocked()) { ?>
        <a href="#reserved">Purchase offers</a>
        <br>
    <?php } ?>
    <a href="#sold">Sneakers sold</a>
</div>
<?php if ($gestionIsntance->IsUserNotBlocked()) { ?>
    <a id="CTransaction"></a>
    <div class="centerGestion">
        <h1 class="titreTransaction">Sell a sneaker</h1>
        <div class="sellSneakerCard">
            <form action="index.php?url=Gestion" method="post" enctype="multipart/form-data">
                <img src="./src/View/img/logo.png" alt="logo" class="logo" />
                <img class="imgSneaker imgSellSneaker" src="./src/View/img/notFound.png" />
                <div class="imgDiv">
                    <p class="errors errorImg"> <?= (isset($errorMessages["errorImg"])) ? $errorMessages["errorImg"] : "" ?>
                    </p>
                    <input type="file" name="img" class="selectImg" id="" onchange="previewFile()">
                </div>
                <main class="main">
                    <div class="titre">
                        <div class="marqueModele">
                            <div class="brandSizeLigne">
                                <div class="brandDiv">
                                    <p class="errors errorMsgBrand">
                                        <?= (isset($errorMessages["errorBrand"])) ? $errorMessages["errorBrand"] : "" ?>
                                    </p>
                                    <select name="brand" class="brand" id="">
                                        <option value="-1">Brand</option>
                                        <?php foreach ($marques as $key => $value) { ?>
                                            <option value="<?= $value->idBrand ?>" class="optionSize"
                                                <?= ($idBrand == $value->idBrand) ? "selected" : "" ?>><?= $value->nameBrand ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="modeleDiv">
                                    <p class="errors errorMsgModele">
                                        <?= (isset($errorMessages["errorModel"])) ? $errorMessages["errorModel"] : "" ?>
                                    </p>
                                    <input type="text" name="modele" class="price white" placeholder="Model" id=""
                                        autocomplete="off" value="<?= $modele ?>">
                                </div>
                                <div class="prixDiv">
                                    <p class="errors errorMsgPrice">
                                        <?= (isset($errorMessages["errorPrice"])) ? $errorMessages["errorPrice"] : "" ?>
                                    </p>
                                    <span class="prixGestion">
                                        <input type="text" name="price" class="price" placeholder="price" id=""
                                            autocomplete="off" value="<?= $price ?>">$
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="h1Size">
                        <p>Size</p>
                        <input type="number" class="size" name="size" placeholder="size" id="" value="<?= $size ?>">
                        <p class="errors"><?= (isset($errorMessages["errorSize"])) ? $errorMessages["errorSize"] : "" ?></p>
                        <select name="statut" class="brand">
                            <option value="1">Visible</option>
                            <option value="2">Hidden</option>
                        </select>
                    </div>

                    <div class="descGestion">
                        <p class="errors"><?= (isset($errorMessages["errorDesc"])) ? $errorMessages["errorDesc"] : "" ?></p>
                        <input type="text" name="desc" class="desc" placeholder="Description" id="" autocomplete="off"
                            value="<?= $desc ?>">
                    </div>
                    <br>
                    <input type="submit" name="submit" class="submitTransaction" value="Create">
                </main>
            </form>
        </div>
    </div>
    <a id="sale"></a>
    <h1 class="title">My Sneakers in sale</h1>
    <div class="center">
        <?php if (!empty($tabPairesEnVente)) { ?>
            <?php foreach ($tabPairesEnVente as $paire) { ?>
                <div class="card">
                    <img src="./src/View/img/logo.png" alt="logo" class="logo" />
                    <img class="imgSneaker" src="<?= $paire->sneaker->imgSneaker ?>" />
                    <main class="main">
                        <div class="titre">
                            <h1 class="marqueModele">
                                <?= $paire->sneaker->nameBrand ?>             <?= $paire->sneaker->nameModel ?>
                            </h1>
                            <h1><span class="prix">
                                    <?= $paire->sneaker->priceSneaker ?>$
                                </span></h1>
                        </div>
                        <p class="h1Size">Size <?= $paire->sneaker->sizeSneaker ?></p>
                        <p class="description">
                            <?= html_entity_decode($paire->sneaker->descriptionSneaker) ?>
                        </p>
                        <br>
                    </main>
                    <div class="starGestion">
                        <div class="postedBy postedByGestion">
                            <?php if ($paire->vendeur->imgUser != "") { ?>
                                <img src="<?= $paire->vendeur->imgUser ?>" alt="avatar" class="avatar" />
                            <?php } else { ?>
                                <img src="./src/View/img/anonymous.png" alt="avatar" class="avatar" />
                            <?php } ?>
                            <p>Posted by <span><?= $paire->vendeur->surnameUser ?></span></p>
                        </div>
                        <a class="linkStar linkStarGestion"
                            href="index.php?url=Gestion&remove=yes&idSneaker=<?= $paire->sneaker->idSneaker ?>">
                            <div class="invertedRemove"></div>
                        </a>
                    </div>
                    <?php if($gestionIsntance->IsSneakerInvisible($paire->sneaker->idSneaker)){ ?>
                        <br>
                        <form action="" method="post">
                            <input type="hidden" name="idSneaker" value="<?= $paire->sneaker->idSneaker ?>">
                        <input type="submit" class="submitTransaction" name="submit" value="Set to Visible">
                        </form>
                    <?php } ?>
                </div>

            <?php }
        } else { ?>
            <div class="centerGestion favoritesEmpty">
                <div class="cardGestion cardGestionFavorites">
                    <h1 class="noFavorites">You don't have any Sneaker in sale.</h1>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>
<a id="reservations"></a>
<h1 class="title">My reservations</h1>
<div class="center">
    <?php if (!empty($arrSneakersReserved)) { ?>
        <?php foreach ($arrSneakersReserved as $paire) { ?>
            <div class="card">
                <img src="./src/View/img/logo.png" alt="logo" class="logo" />
                <img class="imgSneaker" src="<?= $paire->sneaker->imgSneaker ?>" />
                <main class="main">
                    <div class="titre">
                        <h1 class="marqueModele">
                            <?= $paire->sneaker->nameBrand ?>         <?= $paire->sneaker->nameModel ?>
                        </h1>
                        <h1><span class="prix">
                                <?= $paire->sneaker->priceSneaker ?>$
                            </span></h1>
                    </div>
                    <p class="h1Size">Size <?= $paire->sneaker->sizeSneaker ?></p>
                    <p class="description">
                        <?= html_entity_decode($paire->sneaker->descriptionSneaker) ?>
                    </p>
                    <br>
                </main>
                <div class="starGestion">
                    <div class="postedBy postedByGestion">
                        <?php if ($paire->vendeur->imgUser != "") { ?>
                            <img src="<?= $paire->vendeur->imgUser ?>" alt="avatar" class="avatar" />
                        <?php } else { ?>
                            <img src="./src/View/img/anonymous.png" alt="avatar" class="avatar" />
                        <?php } ?>
                        <p>Posted by <span><?= $paire->vendeur->surnameUser ?></span></p>
                    </div>
                </div>
                <form action="" method="post">
                    <input type="hidden" name="idSneaker" value="<?= $paire->sneaker->idSneaker ?>">
                    <input class="submit cancelPurchase" type="submit" name="submit" value="Cancel">
                </form>
            </div>

        <?php }
    } else { ?>
        <div class="centerGestion favoritesEmpty">
            <div class="cardGestion cardGestionFavorites">
                <h1 class="noFavorites">You haven't reserved any Sneaker.</h1>
            </div>
        </div>
    <?php } ?>
</div>
<a id="purchases"></a>
<h1 class="title">My purchases</h1>
<div class="center">
    <?php if (!empty($tabPairesAchetees)) { ?>
        <?php foreach ($tabPairesAchetees as $paire) { ?>
            <div class="card">
                <img src="./src/View/img/logo.png" alt="logo" class="logo" />
                <img class="imgSneaker" src="<?= $paire->sneaker->imgSneaker ?>" />
                <main class="main">
                    <div class="titre">
                        <h1 class="marqueModele">
                            <?= $paire->sneaker->nameBrand ?>         <?= $paire->sneaker->nameModel ?>
                        </h1>
                        <h1><span class="prix">
                                <?= $paire->sneaker->priceSneaker ?>$
                            </span></h1>
                    </div>
                    <p class="h1Size">Size <?= $paire->sneaker->sizeSneaker ?></p>
                    <p class="description">
                        <?= html_entity_decode($paire->sneaker->descriptionSneaker) ?>
                    </p>
                    <br>
                </main>
                <div class="starGestion">
                    <div class="postedBy postedByGestion">
                        <?php if ($paire->vendeur->imgUser != "") { ?>
                            <img src="<?= $paire->vendeur->imgUser ?>" alt="avatar" class="avatar" />
                        <?php } else { ?>
                            <img src="./src/View/img/anonymous.png" alt="avatar" class="avatar" />
                        <?php } ?>
                        <p>Posted by <span><?= $paire->vendeur->surnameUser ?></span></p>
                    </div>
                </div>
                <div class="meetPoint">
                    <?php $dhMeetPoint = new DateTime($paire->meetPoint->dateHourMeetPlace) ?>
                    <p><i class="fas fa-map-marker-alt"></i> <?= $paire->meetPoint->adressMeetPoint ?></p>
                    <p><i class="far fa-calendar-alt"></i> <?= $dhMeetPoint->format('d-m-Y H:i') ?>
                    </p>
                </div>
            </div>

        <?php }
    } else { ?>
        <div class="centerGestion favoritesEmpty">
            <div class="cardGestion cardGestionFavorites">
                <h1 class="noFavorites">You haven't purchased any Sneaker.</h1>
            </div>
        </div>
    <?php } ?>
</div>
<?php if ($gestionIsntance->IsUserNotBlocked()) { ?>
    <a id="reserved"></a>
    <h1 class="title">Purchase offers</h1>
    <div class="center">
        <?php if (!empty($sneakersReserved)) { ?>
            <?php foreach ($sneakersReserved as $paire) { ?>
                <div class="card">
                    <img src="./src/View/img/logo.png" alt="logo" class="logo" />
                    <img class="imgSneaker" src="<?= $paire->sneaker->imgSneaker ?>" />
                    <main class="main">
                        <div class="titre">
                            <h1 class="marqueModele">
                                <?= $paire->sneaker->nameBrand ?>            <?= $paire->sneaker->nameModel ?>
                            </h1>
                            <h1><span class="prix">
                                    <?= $paire->sneaker->priceSneaker ?>$
                                </span></h1>
                        </div>
                        <p class="h1Size">Size <?= $paire->sneaker->sizeSneaker ?></p>
                        <p class="description">
                            <?= html_entity_decode($paire->sneaker->descriptionSneaker) ?>
                        </p>
                        <br>
                    </main>
                    <div class="starGestion">
                        <div class="postedBy postedByGestion">
                            <?php if ($paire->acheteur->imgUser != "") { ?>
                                <img src="<?= $paire->acheteur->imgUser ?>" alt="avatar" class="avatar" />
                            <?php } else { ?>
                                <img src="./src/View/img/anonymous.png" alt="avatar" class="avatar" />
                            <?php } ?>
                            <p>Offered by <span><?= $paire->acheteur->surnameUser ?></span></p>
                        </div>
                    </div>
                    <div class="meetPoint">
                        <p><i class="fas fa-map-marker-alt"></i> <?= $paire->meetPoint->adressMeetPoint ?></p>
                        <?php $dhMeetPoint = new DateTime($paire->meetPoint->dateHourMeetPlace) ?>
                        <p><i class="far fa-calendar-alt"></i> <?= $dhMeetPoint->format('d-m-Y H:i') ?></p>
                    </div>
                    <form action="" method="post" class="acceptDeny">
                        <input type="hidden" name="idSneaker" value="<?= $paire->sneaker->idSneaker ?>">
                        <input class="submit acceptPurchase" type="submit" name="submit" value="Accept">
                        <input class="submit denyPurchase" type="submit" name="submit" value="Deny">
                    </form>
                </div>

            <?php }
        } else { ?>
            <div class="centerGestion favoritesEmpty">
                <div class="cardGestion cardGestionFavorites">
                    <h1 class="noFavorites">You didn't recieved any purchase offer.</h1>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>
<a id="sold"></a>
<h1 class="title">Sneakers sold</h1>
<div class="center">
    <?php if (!empty($sneakersSold)) { ?>
        <?php foreach ($sneakersSold as $paire) { ?>
            <div class="card">
                <img src="./src/View/img/logo.png" alt="logo" class="logo" />
                <img class="imgSneaker" src="<?= $paire->sneaker->imgSneaker ?>" />
                <main class="main">
                    <div class="titre">
                        <h1 class="marqueModele">
                            <?= $paire->sneaker->nameBrand ?>         <?= $paire->sneaker->nameModel ?>
                        </h1>
                        <h1><span class="prix">
                                <?= $paire->sneaker->priceSneaker ?>$
                            </span></h1>
                    </div>
                    <p class="h1Size">Size <?= $paire->sneaker->sizeSneaker ?></p>
                    <p class="description">
                        <?= html_entity_decode($paire->sneaker->descriptionSneaker) ?>
                    </p>
                    <br>
                </main>
                <div class="starGestion">
                    <div class="postedBy postedByGestion">
                        <?php if ($paire->acheteur->imgUser != "") { ?>
                            <img src="<?= $paire->acheteur->imgUser ?>" alt="avatar" class="avatar" />
                        <?php } else { ?>
                            <img src="./src/View/img/anonymous.png" alt="avatar" class="avatar" />
                        <?php } ?>
                        <p>Offered by <span><?= $paire->acheteur->surnameUser ?></span></p>
                    </div>
                </div>
                <div class="meetPoint">
                    <?php $dhMeetPoint = new DateTime($paire->meetPoint->dateHourMeetPlace) ?>
                    <p><i class="fas fa-map-marker-alt"></i> <?= $paire->meetPoint->adressMeetPoint ?></p>
                    <p><i class="far fa-calendar-alt"></i> <?= $dhMeetPoint->format('d-m-Y H:i') ?>
                    </p>
                </div>
            </div>

        <?php }
    } else { ?>
        <div class="centerGestion favoritesEmpty">
            <div class="cardGestion cardGestionFavorites">
                <h1 class="noFavorites">You haven't sold any Sneaker.</h1>
            </div>
        </div>
    <?php } ?>
</div>
</body>

<script src="./src/View/js/previewImg.js"></script>

</html>