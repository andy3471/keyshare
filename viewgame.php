<?php include './theme/header.php';

//get id from url, else redirect
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header('Location: games.php');
    exit();
}

$sql = "
SELECT game_id, gamename, description, image FROM games AS G
WHERE game_id = $id
LIMIT 1
";

$result = $mysqli->query($sql);




echo '<h2>';
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo $row["gamename"];
        
        
        echo '</h2>';
        $games->getgamepic($mysqli,$id);
        
        if (is_null($row["image"])) {
            echo '<br><a href="uploadgameimage.php?id='.$id.'">Add a game image</a><br> ';
        } else {
            echo '<br><a href="uploadgameimage.php?id='.$id.'">Update game image</a><br> ';
        }
        echo '<p>'.$row["description"].'</p>';

        
        

        //Get Available Keys
        $fetchkeys = "
        SELECT K.key_id, P.platformname, U.username, K.created_user_id as user_id FROM `keys` AS K
        JOIN platforms AS P
        ON K.platform_id = P.platform_id
        JOIN users AS U
        ON K.created_user_id = U.user_id
        WHERE K.game_id = $id
        AND removed IS NULL
        AND owned_user IS NULL
        ";

        $keyresults = $mysqli->query($fetchkeys);

            echo '<table class="table"><tr><th>Platform</th><th>Added By</th></tr>';
        if ($keyresults->num_rows > 0) {
            // output data of each row
            while($keyrow = $keyresults->fetch_assoc()) {
                
                echo '<tr><td><a href="./viewkey.php?id='.$keyrow["key_id"].'">'.$keyrow["platformname"].'</a></td>
                     <td><a href="./viewuser.php?id='.$keyrow["user_id"].'">'.$keyrow["username"].'</a></tr>';
            }
        } else {
            echo "0 Available Keys";
        }
            echo '</table>';
    echo '</div>
          ';
       }

   
   
} else {
    header('Location: games.php');
}

include './theme/sidebar.php';
include './theme/footer.php';?>