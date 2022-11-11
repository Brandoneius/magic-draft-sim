# magic-draft-sim
Drafting can be expensive. Created this sim to practice drafting. 

Initially downloaded card data from https://mtgjson.com/

Ran into some problems with cacheing on the Blue Host Server but got that figured out with sending POST to refresh what the server is returning. 

Got the packs to generate and return an array with each card name. 

Now thinking I am going to instead of making one array create an array for each array inside the $packs array. 

$packs = array(
  "1rare" => array(
                "id" => $row['id'],
                "scryfall_img_url"=>$row["scryfall_img_url"]
                ),
  "1uncommon" => 
  
  But will need to think more, need a way to keep the image url and ID/NAME. 
  Depating on creating a class for card, and instead of querying for a list of all cards, maybe do it individually, seems like a lot of unnecessary queries. 
