<?php
//Includes
include_once('../includes/db_connect.php');
require "../includes/functions.php";

$profile = new Profile;
$games = new games;

//Start Session
session_start();
// If not logged in, return to login
if($_SESSION["role_id"] != 2){
    header("location: ../index.php");
    exit;
}

?>

<html>

    <head>
        <title><?php echo TITLE; ?> - Admin</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
            <link rel="stylesheet" type="text/css" href="../theme/css/style.css">
        
            <link rel="icon" 
      type="image/x-icon" 
      href="../images/favicon.ico">
            
    </head>

    
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"><?php echo TITLE; ?></a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="../games.php">Front End</a></li>
      <li><a href="./users.php">Users</a></li>
      <li><a href="./games.php">Games</a></li>
      <li><a href="./keys.php">Keys</a></li>
      <li><a href="./platforms.php">Platforms</a></li>
    </ul>
  </div>
</nav>

    
    <div class="container" style="margin-top:50px">