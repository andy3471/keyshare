<?php include './theme/header.php';

//Functions
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
} 

//Form Data
$gamename = test_input($_POST['gamename']);
$description = test_input($_POST['description']);
$game_id = $_POST['game_id']; 


        $updategamesql = "UPDATE games
                   SET gamename = '$gamename',
                   description = '$description'
                   WHERE game_id = $game_id";

    $updategame = $mysqli->query($updategamesql);

//    Print Response
    if ( $updategame ) {
        echo "Game Updated" ;
        }
    else {
        die("Error: {$mysqli->errno} : {$mysqli->error}");
    }

include './theme/footer.php';?>