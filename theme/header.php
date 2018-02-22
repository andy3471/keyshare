<?php
//Includes
include_once('includes/db_connect.php');
require "includes/functions.php";

$profile = new Profile;

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
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
            <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
            <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
            <link rel="stylesheet" type="text/css" href="./theme/css/style.css">
        
            <link rel="icon" 
      type="image/x-icon" 
      href="./images/favicon.ico">
            
    </head>
    <body>

        
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#"><?php echo TITLE; ?></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
                <?php 
                if($_SESSION["role_id"] == 2){
                echo '<li><a href="./admin">Admin</a></li>';
                }   
                ?>
                <li><a class="active" href="./games.php">Games</a></li>
                <li><a href="claimedkeys.php">My Keys</a></li>
                <li><a href="./addkey.php">Add Key</a></li>
				<li><a href="./topusers.php">Top Users</a></li>
      </ul>
    <form class="navbar-form navbar-right" method="get" action="./search.php?">
      <div class="form-group">
        <input name="search" id="search" type="text" class="form-control" placeholder="Search">
		
			    <script>
                $(function() {
                    $( "#search" ).autocomplete({
                        source: 'gameslist.php'
                    });
                });
                </script>
      </div>
      <button type="Search" class="btn btn-default">Search</button>
    </form>
    </div>
  </div>
</nav>
        
        
        <div class="container-fluid" style="margin-top:50px">
        <div class="jumbotron well">
            <img src="./images/LogoWeb.png" alt="360NoHope" width="137" height="110">
        </div>
            
        
        
        <div class="col-md-2 text-left sidenav"> 
            <div class="well">
                        <h3><?php echo $_SESSION["username"] ?></h3>
                        
                            <?php 
                            $profile->getprofilepic($mysqli,$user_id);
                            ?>
 

                        <li><a href="claimedkeys.php">Claimed Keys</a></li>
                        <li><a href="sharedkeys.php">Shared Keys</a></li>
                        <li><a href="updateuser.php">Update Profile</a></li>
                        <li><a href="uploadprofilepic.php">Upload Picture</a></li>
                        
                        <?php 
                            if($_SESSION["role_id"] == 2){
                            echo '<li><a href="./admin">Admin</a></li>';
                            }   
                        ?>
                        
                        <li><a href="logout.php">Log Out</a></li>
            </div>
        </div>
        
        <div class="col-md-10 text-left"> 
            <div class="well">
			
			<?php
			$filename = dirname(__FILE__).'/../install/index.php';

						if (file_exists($filename)) {
				echo "<h1><b> PLEASE DELETE INSTALL DIRECTORY </b></h1>";
			}
			?>

            <!-- Main Body -->

