<h1 class="title">Shop</h1>
<div class="filtres">
    <form style="display: flex;" id="myForm" method="get" action="index.php?url=Home&marque=<?= $idBrand ?>&size=<?= $idSize ?>">
        <select name="marques" class="marques" onchange="document.getElementById('myForm').submit()">
            <option value="0" class="optionSize" <?= ($idBrand == 0) ? "selected" : "" ?>>All brands</option>
            <?php foreach ($marques as $key => $value) { ?>
                <option value="<?= $value->idBrand ?>" class="optionSize" <?= ($idBrand == $value->idBrand) ? "selected" : "" ?>>
                    <?= $value->nameBrand ?>
                </option>
            <?php } ?>
        </select>
        <select name="sizes" class="marques" onchange="document.getElementById('myForm').submit()">
            <option value="0" class="optionSize" <?= ($idSize == 0) ? "selected" : "" ?>>All sizes</option>
            <?php foreach ($sizes as $key => $value) { ?>
                <option value="<?= $value->sizeSneaker ?>" class="optionSize" <?= ($idSize == $value->sizeSneaker) ? "selected" : "" ?>>
                    <?= $value->sizeSneaker ?>
                </option>
            <?php } ?>
        </select>
    </form>
</div>
<div class="center">
    <?php if (!empty($tabPairesCards)) { ?>
        <?php foreach ($tabPairesCards as $paire) { ?>
            <div class="card">
                <a href="index.php?url=Detail&id=<?= $paire->sneaker->idSneaker ?>">
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
                </a>
                <div class="postedBy">
                    <?php if ($paire->vendeur->imgUser != "") { ?>
                        <img src="<?= $paire->vendeur->imgUser ?>" alt="avatar" class="avatar" />
                    <?php } else { ?>
                        <img src="./src/View/img/anonymous.png" alt="avatar" class="avatar" />
                    <?php } ?>
                    <p>Posted by <span><?= $paire->vendeur->surnameUser ?></span></p>
                </div>
            </div>

        <?php }
    } else { ?>
        <div class="centerGestion favoritesEmpty">
            <div class="cardGestion cardGestionFavorites">
                <h1 class="noFavorites">We're sorry, no Sneaker matches your search.</h1>
            </div>
        </div>
    <?php } ?>
</div>
<?php if($pages > 1){ ?>
<div class="pagination">
    <?php for ($i = 1; $i <= $pages; $i++) { ?>
        <?php if (isset($_GET["marques"])) { ?>
            <a class="<?= ($currentPage == $i) ? "currentPage" : "" ?>"
                href="index.php?url=home&marques=<?= $_GET["marques"] ?>&sizes=<?= $_GET["sizes"] ?>&page=<?= $i ?>"><?= $i ?></a>
        <?php } else { ?>
            <a class="<?= ($currentPage == $i) ? "currentPage" : "" ?>" href="index.php?url=home&page=<?= $i ?>"><?= $i ?></a>
        <?php } ?>
    <?php } ?>
</div>
<?php } ?>
</body>

</html>