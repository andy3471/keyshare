<?php include './theme/header.php';?>

<h2> Available Games </h2>

<?php

$sql = "
SELECT DISTINCT G.game_id, G.gamename FROM keyshare.games AS G
JOIN keyshare.keys K
ON K.Game_ID = G.Game_ID
where K.removed is null
and K.dlc_id is null
and K.owned_user is null
and K.dlc_id is null
order by G.gamename
";

$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
        echo '<div id="bodytext"> <table class="table"><tr><th> Game </th></tr>';
    while($row = $result->fetch_assoc()) {
        echo '<tr><td><a href="./viewgame.php?id='.$row["game_id"].'">'. $row["gamename"].'</a></td>';
    }
        echo '</table>';
} else {
    echo "0 results";
}

?>
                        

<?php include './theme/footer.php';?>