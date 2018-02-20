<?php
include '../theme/installheader.php';
?>

                <h1> Creating Config </h1>
            
            <?php


// Vars
$db_server = $_POST['db_server'];
$db_name = $_POST['db_name'];
$db_username = $_POST['db_username'];
$db_password = $_POST['db_password'];
$title = $_POST['title'];


$configfile = fopen("../includes/config.php", "w") or die("Unable to open file!");
$txt = "<?php
        //Db Connection
        define('DB_SERVER', '".$db_server."');
        define('DB_USERNAME', '".$db_username."');
        define('DB_PASSWORD', '".$db_password."');
        define('DB_NAME', '".$db_name."');
        
        //Config
        define('TITLE','".$db_name."');
        ?>";
        
    fwrite($configfile, $txt);
    echo 'Config Created Successfully';
    fclose($configfile);
    ?>
                
                
   <a href="./index.php">Back</a>
  <a href="./createadmin.php">Next</a>
