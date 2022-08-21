<?php
require_once ("includes/header.php");
global $dbh;
$preview = new PreviewProvider($dbh,$_SESSION['userLoggedIn']);
echo $preview->createPreviewVideo(NULL);

$container = new CategoryContainers($dbh,$_SESSION['userLoggedIn']);
echo $container->showAllCategories();