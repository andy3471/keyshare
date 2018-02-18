<?php include './theme/header.php';

//Functions
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
} 

//Form Data
$password = PASSWORD_HASH(($_POST['password']), PASSWORD_BCRYPT);
$user_id = $_POST['user_id'];

    $updateusersql = "UPDATE users SET
        password = '$password'
        WHERE user_id = $user_id";

    $updateuser = $mysqli->query($updateusersql);

//    Print Response
    if ( $updateuser ) {
        echo "User Updated - Password Changed" ;
        session_destroy();
        }
    else {
        die("Error: {$mysqli->errno} : {$mysqli->error}"); 
    }


include './theme/footer.php';?>