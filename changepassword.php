<?php include './theme/header.php';?>

        <h2> Change Password </h2>

                        <form method="post" action="changepassword_post.php">
                            <label for="password"> New Password*: </label>
                            <input name="password" class="form-control" type="password" required>
                            <br>
                            <input type="submit" class="btn btn-default" value="Submit">
                            <?php
                            echo '<input type="hidden" name="user_id" value="'.$_SESSION['user_id'].'" />';
                                ?>
                       </form>
        
        
<?php include './theme/sidebar.php';
include './theme/footer.php';?>