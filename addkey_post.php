<?php include './theme/header.php';?>

    <h2> Add Key </h2>
                   
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
$gamename = test_input($_POST['gamename']);
$platform_id = $_POST['platform_id'];
$key = test_input($_POST['key']);
$user_id = $_SESSION["user_id"];
 

//Check if game exists
$sql = "
SELECT game_id FROM games
WHERE gamename = '$gamename'
LIMIT 1
";

$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    
    while($row = $result->fetch_assoc()) {
        $game_id = $row["game_id"];#
    }
    
} else {
    $insertgame = "
        INSERT INTO games (gamename,created_user_id,created_dttm)
        VALUES ('$gamename','$user_id',curdate())
    ";

    $insertgameresult = $mysqli->query($insertgame);

    $sql = "
    SELECT game_id FROM games
    WHERE gamename = '$gamename'
    LIMIT 1
    ";

    $result = $mysqli->query($sql);
    while($row = $result->fetch_assoc()) {
        $game_id = $row["game_id"];
    }
}


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