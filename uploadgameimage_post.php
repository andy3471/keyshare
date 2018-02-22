<?php include './theme/header.php';

$target_dir = "uploads/games/";
$origname = basename($_FILES["fileToUpload"]["name"]);
$imageFileType = strtolower(pathinfo($origname,PATHINFO_EXTENSION));
$uploadOK = 1;
$filename = uniqid();
$target_file = $target_dir.$filename.'.'.$imageFileType ;
$game_id = $_POST['game_id'];

echo $game_id;

if (empty($_FILES["fileToUpload"]["name"])) {
        echo 'No file uploaded';
        $uploadOk = 0;
  }   
//Check if image MIMI
$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}



// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

        
            //Write Upload to DB if not null

                //Delete Old File
                $sql = "SELECT image FROM games
                        WHERE game_id = $game_id
                        LIMIT 1";

                $result = $mysqli->query($sql);

                    if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        
                        if (is_null($row["image"])) { 
                        }
                        else {
                        
                        $oldfile = $row["image"];

                        unlink($oldfile);
                }
                }
                }
                
                //Add New File
                $updateusersql = "UPDATE games
                                  SET image = '$target_file'
                                  WHERE game_id = $game_id
                                  LIMIT 1";

                $updateuser = $mysqli->query($updateusersql);
            
                if ( $updateuser ) {
                echo "The file has been uploaded."; 
                }
                else {
                die("Error: {$mysqli->errno} : {$mysqli->error}");

            }
            
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

 include './theme/footer.php';?>