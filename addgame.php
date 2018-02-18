<?php include './theme/header.php';?>

    <h2> Add Game </h2>
                    
                <div class="form-group">
                    <form method="post" action="addgame_post.php">
                            <label for="name"> Game Name*: </label>
                            <input name="name" type="text" class="form-control"  required>
                            <label for="desc"> Description: </label>
                            <textarea input name="desc" class="form-control" type="textarea" rows="5"></textarea>
                            <br>
                            <button type="submit" class="btn btn-default">Submit</button>
                       </form>
                </div>

<?php include './theme/sidebar.php';
include './theme/footer.php';?>