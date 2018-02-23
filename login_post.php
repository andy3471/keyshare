<?php
include './theme/loginheader.php';
include_once('includes/db_connect.php');
include_once('includes/games.php');
?>
    
    </head>
    <body>
                <h1> Login </h1>

<?php
// Includes

// Vars
$username = $_POST['username'];
$password = PASSWORD_HASH($_POST['password'], PASSWORD_BCRYPT); 

//SQL
$findusersql = "select user_id, password, role_id, username, approved from users where username = '$username'";
$result = $mysqli->query($findusersql);

// Print Response
if ( $result->num_rows == 1 ) {
        while($row = $result->fetch_assoc()) {
        $hashed = $row["password"];
            if($row["approved"] == 1) {
                if(password_verify($_POST["password"], $hashed)) {
			echo "Signed In";
                        session_start();
                        $_SESSION["username"] = $row["username"];
                        $_SESSION["user_id"] = $row["user_id"];
                        $_SESSION["role_id"] = $row["role_id"];
                        $user_id = $row["user_id"];
                        
                        
                        
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
		else {
			echo "Password Incorrect.";
		}
            } else {
                echo "User account not yet approved.";
            }
    }

    }
else {
    die("Error: {$mysqli->errno} : {$mysqli->error}");
}




?>
    </body>
</html>