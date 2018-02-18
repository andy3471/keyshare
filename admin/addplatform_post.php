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


        $addplatformsql = "INSERT INTO platforms (platformname,created_dttm)
                   VALUES ('$platformname',curdate())";

    $addplatform = $mysqli->query($addplatformsql);

//    Print Response
    if ( $addplatform ) {
        echo "Platform Added" ;
        }
    else {
        die("Error: {$mysqli->errno} : {$mysqli->error}");
    }
?>


<?php include './theme/footer.php';?>