<?php include './theme/header.php';?>



                <h2> Add Key </h2>

                <form method="post" action="addkey_post.php">

                <script>
                $(function() {
                    $( "#gamename" ).autocomplete({
                        source: 'gameslist.php'
                    });
                });
                </script>
                <label for="gamename">Game: </label>
                <input id="gamename" name="gamename" class="form-control" required>
                
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
                
                
           
</body>
</html>

<?php include './theme/footer.php';?>