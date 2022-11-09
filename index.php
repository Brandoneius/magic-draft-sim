<?php
//Global will host the global function and data base log in information
require_once("protected/global.php");
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

function pack_create(){
    //A DMU pack is 1 rare (13.25% chance to be mythic) 3 uncommon, 10 common, and 1 basic land
    //Going to set up an array with 1-15 as the indices each being the card to be taken track of
    $pack = array(
        "r1"=>0,
        "u1"=>0,
        "u2"=>0

    );


    $dbServerName = "162.241.30.19";
    $dbUsername = "insulin8_card_fetch";
    $dbPassword = "?Sop_JI,Y[*&";
    $dbName = "insulin8_dmu_cards";
    $conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);
    $sql = "SELECT id, name FROM dmu WHERE rarity = 'uncommon';";
    $result = $conn->query($sql);



    $conn->close();
    return $pack;
    }

echo pack_create();

?>