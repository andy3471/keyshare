<?php include './theme/header.php';?>

            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
            <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
            <script src="//code.jquery.com/jquery-1.10.2.js"></script>
            <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
            <link rel="stylesheet" type="text/css" href="./theme/css/style.css">

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
                <input id="gamename" input name="gamename" class="form-control" required>
                
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