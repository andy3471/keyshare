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
SELECT DISTINCT G.game_id, G.gamename, G.description, G.created_user_id, U.displayname AS createdusername FROM games AS G
LEFT JOIN users U
ON U.user_id = G.created_user_id
ORDER BY G.gamename
LIMIT $start_from, $results_per_page
";

$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
        echo '<div id="bodytext"> <table class="table"><tr><th> Game </th><th> Description </th><th> Created User </th></tr>';
    while($row = $result->fetch_assoc()) {
        echo '<tr><td><a href="./viewgame.php?id='.$row["game_id"].'">'. $row["gamename"].'</a></td><td>'. $row["description"].'</td><td><a href="./viewuser.php?id='.$row["created_user_id"].'">'. $row["createdusername"].'</a></td><tr>';
    }
        echo '</table>';
} else {
    echo "0 results";
}



$sql = "
SELECT COUNT(game_id) AS total FROM games";

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