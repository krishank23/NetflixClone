<?php

require_once("includes/header.php");

if(!isset($_GET["id"])){

    ErrorMessage::show("No id passed to page");
}

global $dbh;
$preview = new PreviewProvider($dbh , $_SESSION['userLoggedIn'] );
echo $preview->creatCategoryPreviewVideo($_GET["id"]);

$preview = new CategoryContainers($dbh , $_SESSION['userLoggedIn'] );
echo $preview->showCategory($_GET["id"]);





