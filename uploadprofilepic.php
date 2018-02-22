<?php include './theme/header.php';?>

<h2> Update Profile Picture </h2>

<form action="uploadprofilepic_post.php" method="post" enctype="multipart/form-data">
    <label for="file">File:</label>
    <input type="file"  name="fileToUpload" id="fileToUpload" class="form-control-file">
    <br>
    <input type="submit"  class="btn btn-default" value="Upload Image" name="submit">
</form>     
                

<?php include './theme/footer.php';?>