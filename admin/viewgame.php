<?php include './theme/header.php';?>
<?php 

//get id from url, else redirect
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header('Location: games.php');
    exit();
}

$sql = "
SELECT gamename, description
FROM games
WHERE game_id = $id
LIMIT 1
";

$result = $mysqli->query($sql);


echo '<h2>';
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo $row["gamename"];
        
        $games->getgamepicadmin($mysqli,$id);
        
        echo '</h2>
              <form method="post" action="../admin/updategame.php"> 
              <div class="form-group">
                  <label for="gamename">Name:</label>
                  <input name="gamename" input type="text" class="form-control" id="gamename" value="'.$row["gamename"].'">
              </div>
              <div class="form-group">
                  <label for="description">Description:</label>
                  <input name="description" input type="text" class="form-control" id="description" value="'.$row["description"].'">
              </div>
               <input type="hidden" name="game_id" value="'.$id.'" />
              <br>
              <button type="submit" class="btn btn-default">Update</button>
';

       }

   
   
}

//else {
//    header('Location: ../admin/games.php');
//}

?>
   

<?php include './theme/footer.php';?>