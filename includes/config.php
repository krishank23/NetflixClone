<?php
ob_start();
session_start();

date_default_timezone_set("Asia/Kolkata");

try{
    // db connections
    $dbh = new PDO("mysql:dbname=netflixDB;host=localhost","root","");
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);

} catch (PDOException $ex){
    exit("Connection Failed to DB". $ex->getMessage());
}