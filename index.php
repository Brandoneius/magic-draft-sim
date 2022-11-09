<?php
//Global will host the global function and data base log in information
require_once("protected/global.php");
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// create connection
$conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);

// check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully<br>";


/*
 * get data from remote database table
 */
$sql = "SELECT id, name FROM dmu WHERE 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        //echo "id: " . $row["id"] . " SLOW <br>";
    }


} else {
    echo "0 results";
}


function pack_create(){
    //A DMU pack is 1 rare (13.25% chance to be mythic) 3 uncommon, 10 common, and 1 basic land
    //Going to set up an array with 1-15 as the indices each being the card to be taken track of
    $pack = array(
        "r1"=>0,
        "u1"=>0,
        "u2"=>0

    );

    $sql = "SELECT id, name FROM dmu WHERE rarity = 'uncommon';";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        foreach($result as $card){
            var_dump($card) . "<br>";
        }
    }

    return $pack;
    }

echo pack_create();
$conn->close();
?>