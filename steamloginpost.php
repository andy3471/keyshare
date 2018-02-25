<?php
include './theme/loginheader.php';
include_once('includes/db_connect.php');

include_once('./steamauth/steamauth.php');
include_once('./steamauth/userInfo.php');


?>
    
    </head>
    <body>
                <h1> Login </h1>

<?php
// Includes
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
} 


// Vars
$steamid = $steamprofile['steamid'];
$displayname = test_input($steamprofile['personaname']);
$profilepic = $steamprofile['avatarfull'];

//SQL
$findusersql = "SELECT user_id, role_id, username, approved, displayname FROM users WHERE username = '$steamid' AND steamuser = 1 LIMIT 1";
$result = $mysqli->query($findusersql);

// Print Response
if ( $result->num_rows == 1 ) {
        while($row = $result->fetch_assoc()) {
            if($row["approved"] == 0 ) {
                echo "User account not yet approved.";
                exit();           
            } else {
			echo "Signed In";
                        $user_id = $row["user_id"];                       
                        
                        //Update User Info
                        $updateusersql = "UPDATE users
                                       SET displayname = '$displayname',
                                       profilepic = '$profilepic'
                                       WHERE user_id = $user_id";

                        $updateuser = $mysqli->query($updateusersql);
                        
                        
                        if ( $updateuser ) {
                            }
                        else {
                            die("Error: {$mysqli->errno} : {$mysqli->error}");
                        }

                        
                        session_start();
                        $_SESSION["displayname"] = $displayname;
                        $_SESSION["user_id"] = $row["user_id"];
                        $_SESSION["role_id"] = $row["role_id"];
                        $_SESSION["steamuser"] = 1;
                        
                       //Cache Karma
                                $sql = "
                                SELECT (IFNULL(C.createdkeys,0) - IFNULL(O.ownedkeys,0)) AS karma FROM users AS U
                                LEFT OUTER JOIN (
                                        SELECT COUNT(created_user_id) AS createdkeys, created_user_id AS user_id FROM `keys`
                                        WHERE removed IS NULL
                                        AND created_user_id = $user_id
                                        GROUP BY created_user_id
                                    ) AS C
                                ON C.user_id = U.user_id
                                LEFT OUTER JOIN (
                                        SELECT count(owned_user) AS ownedkeys, owned_user AS user_id FROM `keys`
                                        WHERE removed IS NULL
                                    AND owned_user = $user_id
                                        GROUP BY owned_user
                                    ) AS O
                                ON O.user_id = U.user_id
                                WHERE U.approved = 1
                                AND U.user_id = $user_id
                                LIMIT 1
                                ";

                                $result = $mysqli->query($sql);
                                    if ( $result->num_rows == 1 ) {
                                        while($row = $result->fetch_assoc()) {
                                            $_SESSION["karma"] = $row["karma"];
                                        }
                                    }
                                
                        
                        header("location: ./games.php");
		}
        }
    } if ( $result->num_rows == 0 ) {
        $addusersql = "insert into users (username,role_id,create_date,approved,displayname,steamuser,profilepic) VALUES ('$steamid',1,curdate(),0,'$displayname',1,'$profilepic') ";
        $insertuser = $mysqli->query($addusersql);

        // Print Response
        if ( $insertuser ) {
            echo "User account Created. Awaiting Approval" ;
            }
        else {
            die("Error: {$mysqli->errno} : {$mysqli->error}");
        }

} 
        
    
    else {
    die("Error: {$mysqli->errno} : {$mysqli->error}");
}




?>
    </body>
</html>