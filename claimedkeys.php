<?php include './theme/header.php';?>

                    <h2> My Games </h2>

<?php
                        
//vars
$user_id = $_SESSION["user_id"];

$sql = "
SELECT K.key_id, G.gamename, P.platformname FROM keyshare.keys AS K
JOIN keyshare.games G
ON K.Game_ID = G.Game_ID
JOIN keyshare.platforms P
ON K.platform_id = P.platform_id
where owned_user = $user_id
";

$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    echo '<table class="table"><tr><th>Game Name</th><th>Platform</th></tr>';
    while($row = $result->fetch_assoc()) {
        echo '<tr><td><a href="./viewkey.php?id='.$row["key_id"].'">'. $row["gamename"].'</a></td><td>'.$row["platformname"].'</td></tr>';
    }
    echo '</table>';
} else {
    echo "No Keys Claimed";
}

 include './theme/sidebar.php';
 include './theme/footer.php';?>