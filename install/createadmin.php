<?php
include '../theme/installheader.php';
include_once('../includes/db_connect.php');
?>
    
    </head>
    <body>
                <h1> Create Admin User </h1>
                <form method="post" action="init_db.php">
                <label for="username"> Username: </label>
                <input name="username" class="form-control" type="text" required>
                <label for="password"> Password*: </label>
                <input name="password" class="form-control" type="password" required>
                <label for="forename"> Forename*: </label>
                <input name="forename" class="form-control" type="text" required>
                <label for="surname"> Surname*: </label>
                <input name="surname" class="form-control" type="text" required>
                <label for="email"> Email*: </label>
                <input name="email" class="form-control" type="text" required>
                <br>
                <input type="submit" class="btn btn-default" value="Next">
                </form>

    </body>
</html>