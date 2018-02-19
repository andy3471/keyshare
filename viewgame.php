<?php include './theme/header.php';

//get id from url, else redirect
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header('Location: games.php');
    exit();
}

$sql = "
SELECT game_id, gamename, description FROM games AS G
WHERE game_id = $id
LIMIT 1
";

$result = $mysqli->query($sql);


echo '<div id="bodytitle"><h2>';
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo $row["gamename"];
        
        
        echo '</div></h2> <div id="bodytext"><p>';
        echo $row["description"];
        echo '</p>';


        //Get Available Keys
        $fetchkeys = "
        select K.key_id, P.platformname, U.username, K.created_user_id as user_id from keyshare.keys AS K
        join keyshare.platforms as P
        on K.platform_id = P.platform_id
        join keyshare.users as U
        on K.created_user_id = U.user_id
        where K.game_id = $id
        and removed is null
        and owned_user is null
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
          </div>';
       }

   
   
} else {
    header('Location: games.php');
}

include './theme/sidebar.php';
include './theme/footer.php';?>