<?php include './theme/header.php';?>

    h2> Add Key </h2>
                   
<?php
//Includes
include_once('includes/db_connect.php');

//Functions
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
} 

//Form Data
$game_id = $_POST['game_id'];
$platform_id = $_POST['platform_id'];
$key = test_input($_POST['key']);
$user_id = $_SESSION["user_id"];
        
//SQL
$addgamesql = "INSERT INTO keyshare.keys (game_id,platform_id,keycode,created_user_id,created_dttm) VALUES ($game_id,'$platform_id','$key','$user_id',curdate()) ";
$insertdlc = $mysqli->query($addgamesql);

//Print Response
if ( $insertdlc ) {
    echo "Key Added" ;
    }
else {
    die("Error: {$mysqli->errno} : {$mysqli->error}");
}

include './theme/sidebar.php';
include './theme/footer.php';?>