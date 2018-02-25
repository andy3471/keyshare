<?php
include './theme/loginheader.php';
include_once('./steamauth/steamauth.php');
?>
    
    </head>
    <body>
                <h1> Login </h1>
                <form method="post" action="login_post.php">
                <label for="username"> Username: </label>
                <input name="username" class="form-control" type="text" required>
                <label for="password"> Password*: </label>
                <input name="password" class="form-control" type="password" required>
                <br>
                <input type="submit" class="btn btn-default" value="Sign In">
                
                <br>
                <p> Not Registered? <a href="./register.php">Sign Up</a> </p>
                </form>
				<?php if (STEAMLOGINS == 1) echo loginbutton();?>
    </body>
</html>