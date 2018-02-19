<?php include './theme/header.php';

$results_per_page = 15;

if (isset($_GET["page"])) { 
	$page  = $_GET["page"]; 
} 
else { 
	$page=1; 
}; 

$start_from = ($page-1) * $results_per_page;

?>

                    <h2> Shared Games </h2>

<?php
                        

//vars
$user_id = $_SESSION["user_id"];

$sql = "
SELECT K.key_id, G.gamename, P.platformname, CU.username AS claimeduser FROM keyshare.keys AS K
JOIN keyshare.games G
ON K.Game_ID = G.Game_ID
JOIN keyshare.platforms P
ON K.platform_id = P.platform_id
LEFT OUTER JOIN keyshare.users CU
ON K.owned_user = CU.user_id
where K.created_user_id = $user_id
LIMIT $start_from, $results_per_page
";

$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    echo '<table class="table"><tr><th>Game Name</th><th>Platform</th><th>Claimed By</th></tr>';
    while($row = $result->fetch_assoc()) {
        echo '<tr><td><a href="./viewkey.php?id='.$row["key_id"].'">'. $row["gamename"].'</a></td><td>'.$row["platformname"].'</td><td>'.$row["claimeduser"].'<td></tr>';
    }
    echo '</table>';
} else {
    echo "No Keys Shared";
}

?>

<?php

$sql = "
SELECT count(K.key_id) AS total FROM keyshare.keys AS K
JOIN keyshare.games G
ON K.Game_ID = G.Game_ID
JOIN keyshare.platforms P
ON K.platform_id = P.platform_id
LEFT OUTER JOIN keyshare.users CU
ON K.owned_user = CU.user_id
where K.created_user_id = $user_id";

$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$total_pages = ceil($row["total"] / $results_per_page); // calculate total pages with results
  
			echo '<ul class="pagination justify-content-center">';
			
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