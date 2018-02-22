<?php
include './theme/loginheader.php';
?>
    
    </head>
    <body>
                <h1> Login </h1>

<?php
// Includes
include_once('includes/db_connect.php');
include_once('includes/games.php');
include 'includes/functions.php';
 
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
                        
                        header("location: games.php");
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