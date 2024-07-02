<h1 class="title"><?= $currentUser->nameUser ?> <?= $currentUser->surnameUser ?>'s sneakers in sale</h1>
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
                    <a class="linkStar linkStarGestion" href="#" data-user-id="<?= $idUser ?>"
                        data-sneaker-id="<?= $sneaker->sneaker->idSneaker ?>">
                        <div class="invertedRemove"></div>
                    </a>
                </div>
            </div>
        <?php } ?>
        <?php if ($pagesSneaker > 1) { ?>
            <div class="pagination">
                <?php for ($i = 1; $i <= $pagesSneaker; $i++) { ?>
                    <a class="<?= ($currentPageSneaker == $i) ? "currentPage" : "" ?>"
                        href="index.php?url=ManageUser&idUser=<?= $idUser ?>&pageSneaker=<?= $i ?>#sneakers"><?= $i ?></a>
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
<h1 class="title"><?= $currentUser->nameUser ?> <?= $currentUser->surnameUser ?>'s sneakers sold</h1>
<div class="center">
    <?php if (!empty($sneakersSold)) { ?>
        <?php foreach ($sneakersSold as $paire) { ?>
            <div class="card">
                <img src="./src/View/img/logo.png" alt="logo" class="logo" />
                <img class="imgSneaker" src="<?= $paire->sneaker->imgSneaker ?>" />
                <main class="main">
                    <div class="titre">
                        <h1 class="marqueModele">
                            <?= $paire->sneaker->nameBrand ?> <?= $paire->sneaker->nameModel ?>
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
                <h1 class="noFavorites"><?= $currentUser->nameUser ?> <?= $currentUser->surnameUser ?> haven't sold any Sneaker.</h1>
            </div>
        </div>
    <?php } ?>
</div>
<script src="./src/View/js/modalManageUser.js"></script>