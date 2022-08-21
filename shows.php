<?php

require_once("includes/header.php");
global $dbh;

$preview = new PreviewProvider($dbh , $_SESSION['userLoggedIn']);
echo $preview->creatTVShowPreviewVideo();

$preview = new CategoryContainers($dbh ,$_SESSION['userLoggedIn']);
echo $preview->showTVShowCategories();


?>



