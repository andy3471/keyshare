<?php include './theme/header.php';

//get id from url, else redirect
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header('Location: games.php');
    exit();
}

$sql = "
SELECT user_id, username, displayname, forename, surname, email, role_id, bio, approved, steamuser
FROM users
WHERE user_id = $id
LIMIT 1
";

$result = $mysqli->query($sql);


echo '<h2>';
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo $row["displayname"];
        echo '</h2>';
        
        echo '<br> <div id="bodytext">
              <form method="post" action="../admin/updateuser.php"> 
              <div class="form-group">
                  <label for="username">Username:</label>
    <input name="username" input type="text" class="form-control" id="username" value="'.$row["username"].'"'; if ($row["steamuser"] == 1) echo 'disabled'; echo '>
              </div>
              <div class="form-group">
                  <label for="displayname">Display Name:</label>
                  <input name="displayname" input type="text" class="form-control" id="displayname" value="'.$row["displayname"].'"'; if ($row["steamuser"] == 1) echo 'disabled'; echo '>
              </div>
              <div class="form-group">
                  <label for="password">Password:</label>
                  <input name="password" input type="password" class="form-control" id="password"'; if ($row["steamuser"] == 1) echo 'disabled'; echo '>
              </div>
              <div class="form-group">
                  <label for="forename">Forename:</label>
                  <input name="forename" input type="text" class="form-control" id="forename" value="'.$row["forename"].'">
              </div>
              <div class="form-group">
                  <label for="forename">Surname:</label>
                  <input name="surname" input type="text" class="form-control" id="surname" value="'.$row["surname"].'">
              </div>
              <div class="form-group">
                  <label for="email">Email:</label>
                  <input name="email" input type="text" class="form-control" id="email" value="'.$row["email"].'">
              </div>
              <div class="form-group">
                  <label for="bio">Bio:</label>
                  <input name="bio" input type="text" class="form-control" id="bio" value="'.$row["bio"].'"  maxlength="255">
              </div>
              <label for="sel1">Role:</label>
              <select name="role_id" select class="form-control" id="role_id">
                    <option value="1"';
                        if($row["role_id"] == 1){
                            echo 'selected';
                        }
                    echo '>User</option>
                    <option value="2"';
                        if($row["role_id"] == 2){
                            echo 'selected';
                        }
                    echo '>Admin</option>
               </select>
               <br>
              <label for="sel1">Approved?:</label>
              <select name="approved" select class="form-control" id="approved">
                    <option value="0"';
                        if($row["approved"] == 0){
                            echo 'selected';
                        }
                    echo '>No</option>
                    <option value="1"';
                        if($row["approved"] == 1){
                            echo 'selected';
                        }
                    echo '>Yes</option>
               </select>
               <input type="hidden" name="user_id" value="'.$id.'" />
              <br>
              <button type="submit" class="btn btn-default">Update</button>
';

       }

   
   
} else {
    header('Location: ../admin/users.php');
}

?>
   

<?php include './theme/footer.php';?>