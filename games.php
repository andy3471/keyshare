<?php include './theme/header.php';

$results_per_page = 15;

if (isset($_GET["page"])) { 
	$page  = $_GET["page"]; 
} 
else { 
	$page=1; 
}; 

$start_from = ($page-1) * $results_per_page;


echo "<h2> Available Games </h2>";


$sql = "
SELECT DISTINCT G.game_id, G.gamename FROM games AS G
JOIN `keys` K
ON K.Game_ID = G.Game_ID
WHERE K.removed is null
AND K.dlc_id is null
AND K.owned_user is null
AND K.dlc_id is null
ORDER BY G.gamename
LIMIT $start_from, $results_per_page
";

$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
        echo '<div class="row">';
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo '<div class="col-sm-4 well">';
        $games->getgamepic($mysqli,$row["game_id"]);
        echo '<br><a href="./viewgame.php?id='.$row["game_id"].'">';
                if (strlen($row["gamename"]) > 26) {
                  echo substr($row["gamename"],0,26).'...</a>';
                }
                else {
                  echo $row["gamename"].'</a>';
                }
        echo '</div>';
    }
        echo '</div>';
} else {
    echo "0 results";
}


$sql = "
SELECT DISTINCT COUNT(G.game_id) AS total FROM games AS G
JOIN `keys` K
ON K.Game_ID = G.Game_ID
WHERE K.removed is null
AND K.dlc_id is null
AND K.owned_user is null
AND K.dlc_id is null";

$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$total_pages = ceil($row["total"] / $results_per_page); // calculate total pages with results
  
			echo '<br><ul class="pagination justify-content-center">';
			
			if ($page == 1) {
				echo "<li class='disabled'><a href='#'>Previous</a></li>";
			} else {
				echo "<li><a href='?page=".($page-1)."'>Previous</a></li>";
			}
			
for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
            echo "<li";
				if ($i==$page)  echo " class='active'";
			echo "><a href='?page=".$i."'";
            echo ">".$i."</a></li>";
		}

			if ($page == $total_pages) {
				echo "<li class='disabled'><a href='#'>Next</a></li>";
			} else {
				echo "<li><a href='?page=".($page+1)."'>Next</a></li>";
			}
			
			echo "<ul>";
			
 include './theme/footer.php';?>