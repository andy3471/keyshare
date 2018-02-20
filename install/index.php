<?php
include '../theme/installheader.php';
?>
    
    </head>
    <body>
            <h1> Key Share </h1>
            <form method="post" action="createconfig.php">
                <label for="title"> Site Title: </label>
                <input name="title" class="form-control" type="text" required>
                <label for="db_server"> DB Server: </label>
                <input name="db_server" class="form-control" type="text" required>
                <label for="db_name"> DB Name: </label>
                <input name="db_name" class="form-control" type="text" required>
                <label for="db_username"> DB Username: </label>
                <input name="db_username" class="form-control" type="text" required>
                <label for="db_password"> DB Password: </label>
                <input name="db_password" class="form-control" type="password" required>
                <br>
                <input type="submit" class="btn btn-default" value="Next">
            </form>

    </body>
</html>