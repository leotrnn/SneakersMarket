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
  <link rel="stylesheet" href="./src/View/css/detail.css">
</head>

<body>
  <section class="productCard">
    <div class="container">
      <div class="info">
        <a href="index.php?url=Shop" class="goBackLink"><i class="fa fa-arrow-circle-left"
            aria-hidden="true"></i>Home</a>
        <div class="namePrice">
          <h1>
            <?= $paire->nameBrand ?> <?= $paire->nameModel ?>
          </h1>
          <h1 class="price">
            <?= $paire->priceSneaker ?>$
          </h1>
        </div>
        <h1 class="desc">
          Size <?= $paire->sizeSneaker ?> - <?= html_entity_decode($paire->descriptionSneaker) ?>
          </h3>
          <div class="attribs">
            <form method="post" action="" class="form">
              <div class="attrib">
                <?php if (!isset($_SESSION['idUser'])) { ?>
                  <p class="errorNotConnected"><a class="errorNotConnected" href="index.php?url=Auth">*You must be
                      connected to like or reserve this Sneaker</a></p>
                <?php } else { ?>
                  <div style="display:flex; align-items:center">
                    <div style="display:block">
                      <p style="width:100%" class="errorMeetPoint">
                        <?= (isset($errorMessages["meetPoint"])) ? $errorMessages["meetPoint"] : "" ?>
                      </p>
                      <select name="meetPoint" <?= ($detailInstance->IsReserved($idSneaker)) ? "disabled" : "" ?>
                        class="size" onchange="document.getElementById('myForm').submit()">
                        <option value="0" class="optionSize" <?= ($idMeetPoint == 0) ? "selected" : "" ?>>Select a meet point
                        </option>
                        <?php foreach ($meetPoints as $key => $value) { ?>
                          <option value="<?= $value->idMeetPoint ?>" class="optionSize"
                            <?= ($idMeetPoint == $value->idMeetPoint) ? "selected" : "" ?>>
                            <?= $value->nameMeetPoint ?>
                          </option>
                        <?php } ?>
                      </select>
                    </div>
                    <div style="display:block; margin-left:2%;">
                      <p style="width:100%" class="errorMeetPoint">
                        <?= (isset($errorMessages["meetingDate"])) ? $errorMessages["meetingDate"] : "" ?>
                      </p>
                      <input type="datetime-local" style="margin-left:2%;  height:33px" id="datetime" name="meetingDate"
                        <?= ($detailInstance->IsReserved($idSneaker)) ? "disabled" : "" ?>>
                    </div>
                  </div>
                  <div class="moitie">
                    <a class="linkStar" href="index.php?url=Detail&id=<?= $paire->idSneaker ?>&favorite=yes">
                      <div class="<?= ($isFavorite) ? "invertedStar" : "star" ?>"></div>
                    </a>
                    <?php if (!$detailInstance->IsReserved($paire->idSneaker) && !$detailInstance->doesUserHasReserved($idSneaker)) { ?>
                      <input class="submit" type="submit" name="submit" value="Reserve">
                    <?php } else if ($detailInstance->IsReserved($paire->idSneaker) && $detailInstance->doesUserHasReserved($idSneaker)) { ?>
                        <input class="submit" type="submit" name="submit" value="Cancel">
                    <?php } ?>
                  </div>
                <?php } ?>
              </div>
            </form>
          </div>
      </div>
      <div class="colorLayer"></div>
      <div class="preview">
        <div class="img">
          <img class="activ" src="<?= $paire->imgSneaker ?>" alt="img 1">
        </div>
      </div>
    </div>
  </section>
  <p class="customMessages customSuccess"><?= (isset($_SESSION['customMessage'])) ? $_SESSION['customMessage'] : "" ?>
  </p>
  <p class="customMessages customError"><?= (isset($_SESSION['customError'])) ? $_SESSION['customError'] : "" ?></p>
</body>

</html>