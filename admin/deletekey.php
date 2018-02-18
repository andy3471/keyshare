<?php include './theme/header.php';

//Form Data
$key_id = $_POST['key_id']; 


        $updategamesql = "UPDATE keyshare.keys
                   SET removed = 1
                   WHERE key_id = $key_id";

    $updategame = $mysqli->query($updategamesql);

//    Print Response
    if ( $updategame ) {
        echo "Key Removed";
        }
    else {
        die("Error: {$mysqli->errno} : {$mysqli->error}");
    }

include './theme/footer.php';?>