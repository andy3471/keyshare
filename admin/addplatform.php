<?php include './theme/header.php';?>



<div id="bodytext">
    <form method="post" action="../admin/addplatform_post.php"> 
        <div class="form-group">
            <label for="platformname">Name:</label>
            <input name="platformname" input type="text" class="form-control" id="platformname">
        </div>
            <input type="hidden" name="platform_id" />
            <br>
            <button type="submit" class="btn btn-default">Add Platform</button>
        </div>
   

<?php include './theme/footer.php';?>