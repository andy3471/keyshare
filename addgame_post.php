<?php include './theme/header.php';?>
    
    <h2> Add Game </h2>
            
<?php
//Includes
include_once('includes/db_connect.php');

//Function
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
} 
//Form Data
$name = test_input($_POST['name']);
$desc = test_input($_POST['desc']);
$user_id = $_SESSION["user_id"];
        
//SQL
$addgamesql = "insert into games (gamename,description,created_user_id,created_dttm) VALUES ( '$name','$desc','$user_id',curdate()) ";
$insertgame = $mysqli->query($addgamesql);

//Print Response
if ( $insertgame ) {
    echo "Game Added" ;
    }
else {
    die("Error: {$mysqli->errno} : {$mysqli->error}");
}

include './theme/sidebar.php';
include './theme/footer.php';?>