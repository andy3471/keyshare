<?php include './theme/header.php';

//get id from url, else redirect
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header('Location: topusers.php');
    exit();
}

$sql = "
SELECT U.username, (IFNULL(C.createdkeys,0) - IFNULL(O.ownedkeys,0)) AS karma FROM users as U
LEFT OUTER JOIN (
	SELECT COUNT(created_user_id) AS createdkeys, created_user_id AS user_id FROM keyshare.keys
	WHERE removed is null
        AND created_user_id = $id
	GROUP BY created_user_id
    ) AS C
ON C.user_id = U.user_id
LEFT OUTER JOIN (
	select count(owned_user) AS ownedkeys, owned_user AS user_id from keyshare.keys
	WHERE removed is null
    AND owned_user = $id
	GROUP BY owned_user
    ) AS O
ON O.user_id = U.user_id
WHERE U.approved = 1
AND U.user_id = $id
LIMIT 1
";

$result = $mysqli->query($sql);


echo '<h2>';
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo $row["username"].'</h2> <p> Karma: '.$row["karma"].'</p>';


        //Get Available Keys
        $fetchkeys = "
        select G.gamename, K.key_id, P.platformname from keyshare.keys AS K
        join keyshare.platforms as P
        on K.platform_id = P.platform_id
        join keyshare.users as U
        on K.created_user_id = U.user_id
        join games AS G
        ON G.game_id = K.game_id
        where K.created_user_id = $id
        and removed is null
        and owned_user is null
        ";

        $keyresults = $mysqli->query($fetchkeys);

            echo '<table class="table"><tr><th>Game</th><th>Platform</th></tr>';
        if ($keyresults->num_rows > 0) {
            // output data of each row
            while($keyrow = $keyresults->fetch_assoc()) {
                
                echo '<tr><td><a href="./viewkey.php?id='.$keyrow["key_id"].'">'.$keyrow["gamename"].'</a></td><td>'.$keyrow["platformname"].'</tr>';
            }
        } else {
            echo "0 Donated Keys";
        }
            echo '</table>';
    echo '</div>
          </div>';
       }

   
   
} else {
   header('Location: topusers.php');
}

include './theme/sidebar.php';
include './theme/footer.php';?>