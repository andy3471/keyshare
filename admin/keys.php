<?php include './theme/header.php';

$results_per_page = 18;

if (isset($_GET["page"])) { 
	$page  = $_GET["page"]; 
} 
else { 
	$page=1; 
}; 

$start_from = ($page-1) * $results_per_page;

$sql = "
SELECT K.key_id, G.gamename, P.platformname, K.owned_user AS owneduserid, OU.username AS ownedusername, K.created_user_id AS createduserid, CU.username AS createdusername, K.removed FROM `keys` as K
LEFT JOIN games AS G
ON G.game_id = K.game_id
LEFT JOIN platforms AS P
ON P.platform_id = K.platform_id
LEFT JOIN users AS CU
ON K.created_user_id = CU.user_id
LEFT JOIN users AS OU
ON K.owned_user = OU.user_id
WHERE removed is null
ORDER BY G.gamename
LIMIT $start_from, $results_per_page
";

$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
        echo '<div id="bodytext"> <table class="table"><tr><th> Key </th><th> Platform </th><th> Owned User </th><th> Shared By User </th></tr>';
    while($row = $result->fetch_assoc()) {
        echo '<tr><td><a href="./viewkey.php?id='.$row["key_id"].'">'. $row["gamename"].'</a></td>
              <td>'. $row["platformname"].'</td>
              <td><a href="./viewuser.php?id='.$row["owneduserid"].'">'. $row["ownedusername"].'</a></td>
              <td><a href="./viewuser.php?id='.$row["createduserid"].'">'. $row["createdusername"].'</a></td>
              <tr>';
    }
        echo '</table>';
} else {
    echo "0 results";
}

$sql = "
SELECT COUNT(key_id) AS total FROM `keys`
WHERE removed IS NULL
";

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

 include '../theme/footer.php';?>