<?php include './theme/header.php';

//Functions
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
} 

//Form Data
$platformname = test_input($_POST['platformname']);
$platform_id = $_POST['platform_id']; 


        $updateplatformsql = "UPDATE platforms
                   SET platformname = '$platformname'
                   WHERE platform_id = $platform_id";

    $updateplatform = $mysqli->query($updateplatformsql);

//    Print Response
    if ( $updateplatform ) {
        echo "Platform Updated" ;
        }
    else {
        die("Error: {$mysqli->errno} : {$mysqli->error}");
    }
?>


<?php include './theme/footer.php';?>