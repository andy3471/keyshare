<?php include './theme/header.php';?>


<?php


$sql = "
SELECT K.key_id, G.gamename, P.platformname, K.owned_user AS owneduserid, OU.username AS ownedusername, K.created_user_id AS createduserid, CU.username AS createdusername, K.removed FROM keyshare.keys as K
LEFT JOIN games AS G
ON G.game_id = K.game_id
LEFT JOIN platforms AS P
ON P.platform_id = K.platform_id
LEFT JOIN users AS CU
ON K.created_user_id = CU.user_id
LEFT JOIN users AS OU
ON K.owned_user = OU.user_id
WHERE removed is null
ORDER BY G.gamename
";

$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
        echo '<div id="bodytext"> <table class="table"><tr><th> Key </th><th> Platform </th><th> Owned User </th><th> Shared By User </th></tr>';
    while($row = $result->fetch_assoc()) {
        echo '<tr><td><a href="./viewkey.php?id='.$row["key_id"].'">'. $row["gamename"].'</a></td>
              <td>'. $row["platformname"].'</td>
              <td><a href="./viewuser.php?id='.$row["owneduserid"].'">'. $row["ownedusername"].'</a></td>
              <td><a href="./viewuser.php?id='.$row["createduserid"].'">'. $row["createdusername"].'</a></td>
              <tr>';
    }
        echo '</table>';
} else {
    echo "0 results";
}

?>
                        

                </div>
            </div>


<?php include '../theme/footer.php';?>