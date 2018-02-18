<?php include './theme/header.php';?>


<?php


$sql = "
SELECT DISTINCT G.game_id, G.gamename, G.description, G.created_user_id, U.username AS createdusername FROM keyshare.games AS G
JOIN keyshare.users U
ON U.user_id = G.created_user_id
order by G.gamename
";

$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
        echo '<div id="bodytext"> <table class="table"><tr><th> Game </th><th> Description </th><th> Created User </th></tr>';
    while($row = $result->fetch_assoc()) {
        echo '<tr><td><a href="./viewgame.php?id='.$row["game_id"].'">'. $row["gamename"].'</a></td><td>'. $row["description"].'</td><td><a href="./viewuser.php?id='.$row["created_user_id"].'">'. $row["createdusername"].'</a></td><tr>';
    }
        echo '</table>';
} else {
    echo "0 results";
}

?>
                        

                </div>
            </div>


<?php include '../theme/footer.php';?>