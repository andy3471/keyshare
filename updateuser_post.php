<?php include './theme/header.php';

//Functions
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
} 

//Form Data
$username = test_input($_POST['username']);
$displayname = test_input($_POST['displayname']);
$forename = test_input($_POST['forename']);
$surname = test_input($_POST['surname']);
$email = test_input($_POST['email']);
$bio = test_input($_POST['bio']);
$user_id = $_SESSION["user_id"];


// Check For Valid Email
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {


//Check If Password Is Changed
if(!isset($_POST['password']) || empty($_POST['password'])) {
        $updateusersql = "UPDATE users
                   SET username = '$username',
                   forename = '$forename',
                   surname = '$surname',    
                   email = '$email',
                   bio = '$bio',
                   displayname = '$displayname'
                   WHERE user_id = $user_id";

    $updateuser = $mysqli->query($updateusersql);

    if ( $updateuser ) {
        echo "User Updated" ;
        $_SESSION["displayname"] = $displayname;
        }
    else {
        die("Error: {$mysqli->errno} : {$mysqli->error}");
    }
}
else {
    $password = PASSWORD_HASH(($_POST['password']), PASSWORD_BCRYPT);

    $updateusersql = "UPDATE users
        SET username = '$username',
        password = '$password',
        forename = '$forename',
        surname = '$surname',    
        email = '$email',
        bio = '$bio',
        displayname = '$displayname'
        WHERE user_id = $user_id";

    $updateuser = $mysqli->query($updateusersql);

//    Print Response
    if ( $updateuser ) {
        echo "User Updated - Password Changed" ;
        $_SESSION["displayname"] = $displayname;
        }
    else {
        die("Error: {$mysqli->errno} : {$mysqli->error}"); 
    }
}

} 

else {
    echo "Email address '$email' is considered invalid.\n";
}


include './theme/footer.php';?>