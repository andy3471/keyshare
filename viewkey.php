<?php include './theme/header.php';

//get id from url, else redirect
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header('Location: games.php');
    exit();
}

$sql = "
SELECT K.game_id, G.gamename, K.keycode, K.owned_user as ownedbyid, CU.user_id, CU.username AS addedby, P.platformname  FROM `keys` AS K
JOIN games as G
ON K.game_id = G.game_id
JOIN users as CU
ON K.created_user_id = CU.user_id
JOIN platforms as P
ON K.platform_id = P.platform_id
WHERE key_id = $id
LIMIT 1
";

$result = $mysqli->query($sql);



if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo '<h2>'.$row["gamename"].' - '.$row["platformname"].'</h2>';

        
        //Check Unclaimed
        if (empty($row["ownedbyid"])) {
            
            echo '  <form action="claimkey.php" method="post">
                        <input name="key" class="form-control" type="text" value ="*****-*****-*****-*****" disabled>
                        <input type="hidden" name="key_id" value="'.$id.'" /> <br>
                        <input type="submit" class="btn btn-default" value="Claim Key">';
            echo '  <br> Claim Key to view <br>';
            
            echo 'Key shared by '.$row["addedby"].'<br>';
            
            $profile->getprofilepic($mysqli,$row["user_id"]);
            }
        else {
            
            //Check if owned by me
                if ($row["ownedbyid"] == $_SESSION["user_id"]) {
                    echo '<input name="key" class="form-control" type="text" value ="'.$row["keycode"].'" disabled>';
                    echo '<br> Key Claimed <br>';
                    echo 'Key shared by '.$row["addedby"].'<br>';
            
                        $profile->getprofilepic($mysqli,$row["user_id"]);
                }
                
                else {
            echo ''
            . '<br> Unfortunately the key has already been claimed by another user';
            }
        }
        echo '</p>';

       }
   
   
} else {

}

     
include './theme/sidebar.php';
include './theme/footer.php';?>