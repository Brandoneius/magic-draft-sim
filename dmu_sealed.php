<?php
//Global will host the global function and data base log in information
//require_once("protected/global.php");
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
Header("Cache-Control: max-age=3000, must-revalidate");
?>
<html>
<header>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</header>

<div class="jumbotron">
  <h1>Dominaria United Sealed Draft Sim</h1> 
  <p>Sealed is too expensive</p> 
</div>

<!-- <nav class="navbar navbar">
  <div class="container-fluid">
    <div class="navbar-header">
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="index.php" class='navtext'>Home</a></li>
      <li><a href="videos.php" class='navtext'>Music Videos</a></li>
      <li><a href="lessons.php" class='navtext'>Lessons</a></li>
      <li><a href="about.php" class='navtext'>About Me</a></li>
      <li><a href="contact.php" class='navtext'>Contact</a></li>
    </ul>
  </div>
</nav> -->
  
<div class="container">
  <h3>Click on the button to generate a sealed pool</h3>
  <form action="dmu_sealed.php" method="POST" role="form" >
  <button type="submit" name="submit" value="submit" class="btn btn-default">Submit</button>
</form>

<?php

function create_pack(){
    //A DMU pack is 1 rare (13.25% chance to be mythic) 3 uncommon, 10 common, and 1 basic land
    //Going to set up an array with 1-15 as the indices each being the card to be taken track of
    $pack = array(
        "r1"=>0,
        "u1"=>0,
        "u2"=>0,
        "c1"=>0,
        "c2"=>0,
        "c3"=>0,
        "c4"=>0,
        "c5"=>0,
        "c6"=>0,
        "c7"=>0,
        "c8"=>0,
        "c9"=>0,
        "c10"=>0,
        "l1"=>0
    );

    $dbServerName = "162.241.30.19";
    $dbUsername = "insulin8_card_fetch";
    $dbPassword = "?Sop_JI,Y[*&";
    $dbName = "insulin8_dmu_cards";
    
    //Connect to mysqli
    $conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);
   
    //Uncommons
    $uncommons = array();
    $uncommon_amount = 3;
    $sql = "SELECT id, name FROM dmu WHERE rarity = 'uncommon';";
    $result = $conn->query($sql);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
        $uncommons[] = $row["name"]; 
        }
        $iterator = 0;
        while($iterator < $uncommon_amount){
            $iterator += 1;
            $uncommon_key = array_rand($uncommons);
            $array_key = "u" . $iterator;
            $pack[$array_key] = $uncommons[$uncommon_key];
            unset($uncommons[$uncommon_key]);
        }
    } else {
         echo "0 results";
        }
    
    //Commons
    $commons = array();
    $common_amount = 10;
    $sql = "SELECT id, name FROM dmu WHERE rarity = 'common' AND superTypes != 'Basic';";
    $result = $conn->query($sql);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
        $commons[] = $row["name"]; 
        }
        $iterator = 0;
        while($iterator < $common_amount){
            $iterator += 1;
            $common_key = array_rand($commons);
            $array_key = "c" . $iterator;
            $pack[$array_key] = $commons[$common_key];
            unset($commons[$common_key]);
        }
    } else {
         echo "0 results";
        }    


    $basics = array();
    $basic_amount = 1;
    $sql = "SELECT id, name FROM dmu WHERE rarity = 'common' AND superTypes = 'Basic';";
    $result = $conn->query($sql);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
        $basics[] = $row["name"]; 
        }
        $iterator = 0;
        while($iterator < $basic_amount){
            $iterator += 1;
            $basic_key = array_rand($basics);
            $array_key = "l" . $iterator;
            $pack[$array_key] = $basics[$basic_key];
        }
    } else {
         echo "0 results";
        } 
        

    //Mythic or Rare
    $mythic_amount = 1;
    $rare_amount = 1;
    $mythic_chance = rand(1,10000);
    if($mythic_chance <= 1350){
        $sql = "SELECT id, name, scryfall_img_url FROM dmu WHERE rarity = 'mythic';";
        $result = $conn->query($sql);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
          }
        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()) {
                $mythics[] = $row["name"];
            }
            $iterator = 0;
            while($iterator < $mythic_amount){
                $iterator += 1;
                $mythic_key = array_rand($mythics);
                $array_key = "r" . $iterator;
                $pack[$array_key] = $mythics[$mythic_key];
            }
        }
    } else {
        $sql = "SELECT id, name FROM dmu WHERE rarity = 'rare';";
        $result = $conn->query($sql);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
          }
        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()) {
            $rares[] = $row["name"]; 
            }
            $iterator = 0;
            while($iterator < $rare_amount){
                $iterator += 1;
                $rare_key = array_rand($rares);
                $array_key = "r" . $iterator;
                $pack[$array_key] = $rares[$rare_key];
            }
        }
    }
    
    // $sql = "SELECT id, name,scryfall_img_url FROM dmu WHERE scryfall_img_url != 1;";
    // $result = $conn->query($sql);
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    //   }
    // if ($result->num_rows > 0){
    //     while($row = $result->fetch_assoc()) {
    //     $mythics[] = $row["id"] . "~" . $row['scryfall_img_url'];
    //     echo "<img src='" . $row['scryfall_img_url'] . "'>";
    // }
    // }

    $conn->close();

    return $pack;
}


    if(isset($_POST['submit'])){
        $i = 1;
        while ($i < 7){
            $packs = create_pack();
            echo "<br><b>Pack:" . $i . "</b></br>";
            foreach($packs as $card){
                echo $card . "<br>";
            }
            $i += 1;
        }


        // $first_pack = create_pack();
        // //var_dump($first_pack);
        // foreach($first_pack as $card){
        //     echo $card . "<br>";
        // }

        // foreach($card as $first_pack){
        //     echo "$card";
        //     $card_array = explode("~",$card);
        //     echo "<img src='" . $card_array['scryfall_img_url'] . "'>";
        // }
    }

?>
</div>
</body>
</html>