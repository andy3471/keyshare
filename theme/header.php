<?php
//Includes
include_once('includes/db_connect.php');
require "includes/functions.php";

$profile = new profile;
$games = new games;

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
            <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js" integrity="sha384-feJI7QwhOS+hwpX2zkaeJQjeiwlhOP+SdQDqhgvvo1DsjtiSQByFdThsxO669S2D" crossorigin="anonymous"></script>

            <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
            <link rel="stylesheet" type="text/css" href="./theme/css/style.css">
        
            <link rel="icon" 
      type="image/x-icon" 
      href="./images/favicon.ico">
            
    </head>
    <body>
        
<nav class="navbar navbar-expand-md bg-dark navbar-dark fixed-top">
      <a class="navbar-brand" href="#"><?php echo TITLE; ?></a>
    </div>
    
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="nav navbar-nav">
                <?php 
                if($_SESSION["role_id"] == 2){
                echo '<li><a class="nav-link" href="./admin">Admin</a></li>';
                }   
                ?>
                <li class="nav-item"><a class="nav-link" href="./games.php">Games</a></li>
                <li class="nav-item"><a class="nav-link" href="claimedkeys.php">My Keys</a></li>
                <li class="nav-item"><a class="nav-link" href="./addkey.php">Add Key</a></li>
		<li class="nav-item"><a class="nav-link" href="./topusers.php">Top Users</a></li>
      </ul>
        <form class="form-inline" action="/action_page.php">
            <input class="form-control mr-sm-2" type="text" placeholder="Search">
        <button class="btn" type="submit">Search</button>
  </form>
    </div>
 
</nav>
        
        
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
 
        
        
        <div class="container-fluid" style="margin-top:50px">
        <div class="jumbotron">
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
        
			<?php
			$filename = dirname(__FILE__).'/../install/index.php';

						if (file_exists($filename)) {
				echo "<h1><b> PLEASE DELETE INSTALL DIRECTORY </b></h1>";
			}
			?>

            <!-- Main Body -->

