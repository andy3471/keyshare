<?php
include_once './includes/db_connect.php';


    //get search term
    $searchTerm = $_GET['term'];
    
    //get matched data from skills table
    $query = $mysqli->query("SELECT gamename FROM games WHERE gamename LIKE '%".$searchTerm."%' ORDER BY gamename LIMIT 15");
    while ($row = $query->fetch_assoc()) {
        $data[] = $row['gamename'];
    }
    
    //return json data
    echo json_encode($data);


 ?>