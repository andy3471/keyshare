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
$forename = test_input($_POST['forename']);
$surname = test_input($_POST['surname']);
$email = test_input($_POST['email']);
$role_id = $_POST['role_id'];
$approved = $_POST['approved'];
$user_id = $_POST['user_id']; 

// Check For Valid Email
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {


//Check If Password Is Changed
if(!isset($_POST['password']) || empty($_POST['password'])) {
        $updateusersql = "UPDATE users
                   SET username = '$username',
                   forename = '$forename',
                   surname = '$surname',    
                   email = '$email',
                   role_id = $role_id,
                   approved = $approved
                   WHERE user_id = $user_id";

    $updateuser = $mysqli->query($updateusersql);

    if ( $updateuser ) {
        echo "User Updated" ;
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
        role_id = $role_id,
        approved = $approved
        WHERE user_id = $user_id";

    $updateuser = $mysqli->query($updateusersql);

//    Print Response
    if ( $updateuser ) {
        echo "User Updated - Password Changed" ;
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