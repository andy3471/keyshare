<?php include './theme/header.php';

$id = $_SESSION["user_id"];

$sql = "
SELECT user_id, username, forename, surname, email, role_id, bio, approved 
FROM users AS U 
WHERE user_id = $id
LIMIT 1
";

$result = $mysqli->query($sql);


if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo '<H2>'.$row["username"].'</H2>';
        
        
        echo '
              <form method="post" action="./updateuser_post.php"> 
              <div class="form-group">
                  <label for="username">Username:</label>
                  <input name="username" input type="text" class="form-control" id="username" value="'.$row["username"].'">
              </div>
              <div class="form-group">
                  <label for="password">Password:</label>
                  <input name="password" input type="password" class="form-control" id="password">
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
                  <input name="bio" input type="textarea" class="form-control" id="email" value="'.$row["bio"].'"  maxlength="255">
              </div>
              

              <input type="hidden" name="user_id" value="'.$id.'" />
              <br>
              <button type="submit" class="btn btn-default">Update</button>
';

       }

   
}



include './theme/footer.php';?>