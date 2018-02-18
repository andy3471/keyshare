<?php
include './theme/loginheader.php';
?>
    
    </head>
    <body>
                <h1> Register </h1>
                <form method="post" action="register_post.php">
                <label for="username"> Username: </label>
                <input name="username" class="form-control" type="text" required>
                <label for="password"> Password*: </label>
                <input name="password" class="form-control" type="password" required>
                <label for="password"> Confirm Password*: </label>
                <input name="password" class="form-control" type="password" required>
                <label for="forename"> Forename*: </label>
                <input name="forename" class="form-control" type="text" required>
                <label for="surname"> surname*: </label>
                <input name="surname" class="form-control" type="text" required>
                <label for="email"> Email*: </label>
                <input name="email" class="form-control" type="text" required>
                <br>
                <input type="submit" class="btn btn-default" value="Sign Up">
                </form>

    </body>
</html>