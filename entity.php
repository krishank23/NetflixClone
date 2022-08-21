<?php

require_once("includes/header.php");

if(!isset($_GET["id"])){

    ErrorMessage::show("No ID passed into page");

}
global $dbh;
$entityId = $_GET["id"];
$entity = new Entity($dbh , $entityId );


$preview = new PreviewProvider($dbh , $_SESSION['userLoggedIn']);
echo $preview->createPreviewVideo($entity);


$seasonProvider = new SeasonProvider( $dbh , $_SESSION['userLoggedIn']);
echo $seasonProvider->create($entity);

$seasonProvider = new CategoryContainers( $dbh , $_SESSION['userLoggedIn'] );
echo $seasonProvider->showCategory($entity->getCategoryId() , "You might also like" );



