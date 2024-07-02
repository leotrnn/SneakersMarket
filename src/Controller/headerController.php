<?php
if ($redirection == "ResultSearch") {
    require ('./src/Model/objects/Sneaker.php');
    require ('./src/Model/objects/User.php');
    require ('./src/Model/objects/ViewTransaction.php');
    require ('./src/Model/objects/Brand.php');
    require ('./src/Model/objects/MeetPoint.php');

}

include ('./src/Model/headerModel.php');


$headerInstance = new Header();

if (isset($_POST["searchBar"])) {
    var_dump($_POST["searchBar"]);
    $search = filter_input(INPUT_POST, 'searchBar', FILTER_SANITIZE_STRING);
    $search = Constants::AntiXSS($search);

    header("Location: index.php?url=ResultSearch&search=" . $search);
}

include ('./src/View/HeaderView.php');