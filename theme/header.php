<?php
//Includes
include_once('includes/db_connect.php');
require "includes/functions.php";

$profile = new profile;
$games = new games;
$page = new page;

//Start Session
session_start();
// If not logged in, return to login
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: index.php");
  exit;
}

$user_id = $_SESSION['user_id']
?>

<html>

    <head>
        <title><?php echo TITLE; ?></title>

            <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
            
            <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js" integrity="sha384-feJI7QwhOS+hwpX2zkaeJQjeiwlhOP+SdQDqhgvvo1DsjtiSQByFdThsxO669S2D" crossorigin="anonymous"></script>
            
            <link rel="stylesheet" type="text/css" href="./theme/css/style.css">
        
            <link rel="icon" 
      type="image/x-icon" 
      href="./images/favicon.ico">
            
    </head>
    <body>
        
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="#"><?php echo TITLE; ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="./games.php">Games</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./addkey.php">Add Key</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="./viewuser.php?id=<?php echo $user_id;?>" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          User
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="./updateuser.php">Update Profile</a>
          <a class="dropdown-item" href=./uploadprofilepic.php">Upload Picture</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="./claimedkeys.php">Claimed Keys</a>
          <a class="dropdown-item" href="./sharedkeys.php">Shared Keys</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href=./logout.php">Logout</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./topusers.php">Top Users</a>
      </li>
      
      <?php 
      if($_SESSION["role_id"] == 2){
        echo '<li class="nav-item"><a class="nav-link" href="./admin">Admin</a></li>';
      }   
      ?>
      
    </ul>
    <form class="form-inline my-2 my-lg-0" method="get" action="./search.php?">
      <input class="form-control mr-sm-2" id="search" type="search" placeholder="search" aria-label="search">
            <script>
                $(function() {
                    $( "#search" ).autocomplete({
                        source: 'gameslist.php'
                    });
                });
            </script>
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>
        
  -->
        
        
        <div class="jumbotron">
            <img src="./images/LogoWeb.png" alt="360NoHope" width="137" height="110">
        </div>
            
  <div class="Container">
