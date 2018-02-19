<?php
include './theme/loginheader.php';
?>

                <h1> Register </h1>
            
            <?php
// Includes
 
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
} 

// Vars
$username = test_input($_POST['username']);
$password = PASSWORD_HASH($_POST['password'], PASSWORD_BCRYPT); 
$forename = test_input($_POST['forename']);
$surname = test_input($_POST['surname']);
$email = test_input($_POST['email']);



//SQL
$addusersql = "insert into users (username,password,forename,surname,email,role_id,create_date,approved) VALUES ( '$username','$password','$forename','$surname','$email',1,curdate(),0) ";
$insertuser = $mysqli->query($addusersql);

// Print Response
if ( $insertuser ) {
    echo "User account Created. Awaiting Approval" ;
    }
else {
    die("Error: {$mysqli->errno} : {$mysqli->error}");
}

?>
<br>
<form method="get" action="./index.php">
    <button type="submit" class="btn btn-default">Go Back</button>
</form>
