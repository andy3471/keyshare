<?php include './theme/header.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header('Location: games.php');
    exit();
}

$sql = "
SELECT gamename 
FROM games
WHERE game_id = $id
LIMIT 1
";

$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo '<h2>'.$row["gamename"].'</h2>';
    }
}
?>

<form action="uploadgameimage_post.php" method="post" enctype="multipart/form-data">
    <label for="file">File:</label>
    <input type="file"  name="fileToUpload" id="fileToUpload" class="form-control-file">
    <br><p> Image Must be 460x215px </p><br>
    <input type="hidden" name="game_id" value="<?php echo $id;?>" />
    <br>
    <input type="submit"  class="btn btn-default" value="Upload Image" name="submit">
</form>     

                

<?php include './theme/footer.php';?>

