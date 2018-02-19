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
SELECT K.game_id, G.gamename, K.platform_id, P.platformname, K.keycode
FROM keyshare.keys AS K
JOIN games AS G
ON K.game_id = G.game_id
JOIN platforms AS P
ON K.platform_id = P.platform_id
WHERE key_id = $id
AND K.removed is null
LIMIT 1
";

$result = $mysqli->query($sql);


echo '<div id="bodytitle"><h2>';
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo $row["gamename"];
        
        
        echo '</div></h2> <div id="bodytext">
              <form method="post" action="../admin/deletekey.php"> 
              <div class="form-group">
                  <label for="gamename">Name:</label>
                  <input name="gamename" input type="text" class="form-control" id="gamename" value="'.$row["gamename"].'" disabled>
              </div>
              <div class="form-group">
                  <label for="description">Platform:</label>
                  <input name="description" input type="text" class="form-control" id="description" value="'.$row["platformname"].'" disabled>
              </div>
              <div class="form-group">
                  <label for="description">Keycode:</label>
                  <input name="description" input type="text" class="form-control" id="description" value="'.$row["keycode"].'" disabled>
              </div>
               <input type="hidden" name="key_id" value="'.$id.'" />
              <br>
              <button type="submit" class="btn btn-default">Delete Key</button>
';

       }

   
   
}

//else {
//    header('Location: ../admin/games.php');
//}

?>
   

<?php include './theme/footer.php';?>