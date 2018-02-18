<?php include './theme/header.php';?>
                <div id="bodytitle">
                    <h2> Add DLC </h2>
                </div>
                <div id="bodytext">
                    <div id="Form">
                        <form method="post" action="adddlc_post.php">
                            Game: <br>
                            <?php
                            $sql = "SELECT game_id, gamename FROM games";
                            $result = $mysqli->query($sql);

                            echo "<select name='game_id'>";
                            while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['game_id'] . "'>" . $row['gamename'] . "</option>";
                            }
                            echo "</select>";
                            ?>
                            <br>
                            DLC Name: <br>
                            <input name="name" type="text">
                            <br>
                            <input type="submit" value="Submit">
                       </form>
                    </div>
                </div>
            </div>
        
        
<?php include './theme/sidebar.php';?>
<?php include './theme/footer.php';?>