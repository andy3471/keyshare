<?php
include_once 'config.php';
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if (!$mysqli) {
    die("Could not conenct to database:" . mysqli_connect_error());
}

?>