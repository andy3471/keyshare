<?php include './theme/header.php';?>

    <h2> Add DLC </h2>
                   
<?php
//Includes
include_once('includes/db_connect.php');
include_once('includes/games.php');

//Form Data
$game_id = $_POST['game_id'];
$name = $_POST['name'];
$user_id = $_SESSION["user_id"];
        
//SQL
$addgamesql = "insert into keyshare.dlc (dlcname,game_id,created_user_id,created_dttm) VALUES ('$name',$game_id,$user_id,curdate()) ";
$insertdlc = $mysqli->query($addgamesql);

//Print Response
if ( $insertdlc ) {
    echo "DLC Added" ;
    }
else {
    die("Error: {$mysqli->errno} : {$mysqli->error}");
}

include './theme/sidebar.php';
include './theme/footer.php';?>