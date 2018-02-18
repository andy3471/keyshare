<?php include './theme/header.php';?>

    <h2> Add Key </h2>

            <form method="post" action="addkey_post.php">
                <label for="game"> Game: </label>
                            
                            <?php
                            $sql = "SELECT game_id, gamename FROM games";
                            $result = $mysqli->query($sql);

                            echo "<select class='form-control' name='game_id'>";
                            while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['game_id'] . "'>" . $row['gamename'] . "</option>";
                            }
                            echo "</select>";
                            ?>
                            
                <label for="platform"> Platform: </label>
                            
                            <?php
                            $sql = "SELECT platform_id, platformname FROM platforms order by platform_id";
                            $result = $mysqli->query($sql);

                            echo "<select class='form-control' name='platform_id'>";
                            while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['platform_id'] . "'>" . $row['platformname'] . "</option>";
                            }
                            echo "</select>";
                            ?>
                            
                <label for=key"> Key: </label>
                            <input name="key" class="form-control" type="text" required>
                            <br>
                            <input type="submit" class="btn btn-default" value="Submit">
                       </form>
                    </div>
                </div>
            </div>
        
        
<?php include './theme/sidebar.php';
include './theme/footer.php';?>