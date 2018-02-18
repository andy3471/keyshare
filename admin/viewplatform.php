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
SELECT platformname
FROM platforms
WHERE platform_id = $id
LIMIT 1
";

$result = $mysqli->query($sql);


echo '<div id="bodytitle"><h2>';
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        
        
        echo '</div></h2> <div id="bodytext">
              <form method="post" action="../admin/updateplatform.php"> 
              <div class="form-group">
                  <label for="platformname">Name:</label>
                  <input name="platformname" input type="text" class="form-control" id="platformname" value="'.$row["platformname"].'">
              </div>
               <input type="hidden" name="platform_id" value="'.$id.'" />
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