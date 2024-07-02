<h1 class="title" style="padding-top:10rem">My favorites</h1>
<div class="center">
    <a id="favorites"></a>
    <?php if (!empty($userFavList)) { ?>
        <?php foreach ($userFavList as $key => $value) { ?>
            <div class="card">
                <a href="index.php?url=Detail&id=<?= $value->sneaker->idSneaker ?>">
                    <img src="./src/View/img/logo.png" alt="logo" class="logo" />
                    <img class="imgSneaker" src="<?= $value->sneaker->imgSneaker ?>" />
                    <main class="main">
                        <div class="titre">
                            <h1 class="marqueModele">
                                <?= $value->sneaker->nameBrand ?>         <?= $value->sneaker->nameModel ?>
                            </h1>
                            <h1><span class="prix">
                                    <?= $value->sneaker->priceSneaker ?>$
                                </span></h1>
                        </div>
                        <p class="h1Size">Size <?= $value->sneaker->sizeSneaker ?></p>
                        <p class="description">
                            <?= html_entity_decode($value->sneaker->descriptionSneaker) ?>
                        </p>
                        <br>
                    </main>
                    <div class="starGestion">
                        <div class="postedBy postedByGestion">
                            <?php if ($value->vendeur->imgUser != "") { ?>
                                <img src="<?= $value->vendeur->imgUser ?>" alt="avatar" class="avatar" />
                            <?php } else { ?>
                                <img src="./src/View/img/anonymous.png" alt="avatar" class="avatar" />
                            <?php } ?>
                            <p>Posted by <span><?= $value->vendeur->surnameUser ?></span></p>
                        </div>
                        <a class="linkStar linkStarGestion"
                            href="index.php?url=Favorites&favorite=yes&idSneaker=<?= $value->sneaker->idSneaker ?>">
                            <div class="invertedStar"></div>
                        </a>
                    </div>
                </a>
            </div>
        <?php }
    } else { ?>
        <div class="centerGestion favoritesEmpty">
            <div class="cardGestion cardGestionFavorites">
                <h1 class="noFavorites">You don't have any Sneaker added to your favorites.</h1>
            </div>
        </div>
    <?php } ?>
</div>
<?php if ($pages > 1) { ?>

    <div class="pagination">
        <?php for ($i = 1; $i <= $pages; $i++) { ?>
            <a class="<?= ($currentPage == $i) ? "currentPage" : "" ?>"
                href="index.php?url=Favorites&page=<?= $i ?>"><?= $i ?></a>
        <?php } ?>
    </div>
<?php } ?>