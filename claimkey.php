<?php
//Includes
include_once('includes/db_connect.php');

//Start Session
session_start();
// If not logged in, return to login
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: index.php");
  exit;
}


//Form Data
$key_id = $_POST['key_id'];
$user_id = $_SESSION["user_id"];
        
//SQL
$claimkey = "UPDATE keyshare.keys SET owned_user = $user_id WHERE key_id = $key_id AND owned_user IS NULL LIMIT 1";
$updateowner = $mysqli->query($claimkey);

//Print Response
if ( $claimkey ) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
else {
    die("Error: {$mysqli->errno} : {$mysqli->error}");
}
?>