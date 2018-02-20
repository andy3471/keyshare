<?php include './theme/header.php';

//Functions
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
} 

$results_per_page = 15;

if (isset($_GET["page"])) { 
	$page  = test_input($_GET["page"]); 
} 
else { 
	$page=1; 
}; 



$start_from = ($page-1) * $results_per_page;

if (isset($_GET['search'])) {
    $search = $_GET['search'];
} else {
    header('Location: games.php');
    exit();
}

if ( $search == null ) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    }


echo "<h2> Search </h2>";




//Check if game exists
$sql = "
SELECT game_id FROM games
WHERE gamename = '$search'
LIMIT 1
";

$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    
    while($row = $result->fetch_assoc()) {
        $game_id = $row["game_id"];#
    }
	
	header('Location: viewgame.php?id='.$game_id);
    
} else {


$sql = "
SELECT DISTINCT G.game_id, G.gamename FROM keyshare.games AS G
JOIN keyshare.keys K
ON K.Game_ID = G.Game_ID
where K.removed is null
and K.dlc_id is null
and K.owned_user is null
and K.dlc_id is null
and G.gamename like '%$search%'
order by G.gamename
LIMIT $start_from, $results_per_page
";

$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
        echo '<div id="bodytext"> <table class="table"><tr><th> Game </th></tr>';
    while($row = $result->fetch_assoc()) {
        echo '<tr><td><a href="./viewgame.php?id='.$row["game_id"].'">'. $row["gamename"].'</a></td>';
    }
        echo '</table>';
} else {
    echo "0 results";
}

}

$sql = "
SELECT DISTINCT COUNT(G.game_id) AS total FROM keyshare.games AS G
JOIN keyshare.keys K
ON K.Game_ID = G.Game_ID
where K.removed is null
and G.gamename like '%$search%'
and K.dlc_id is null
and K.owned_user is null
and K.dlc_id is null";

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
				echo "<li><a href='?search=$search&page=".($page+1)."'>Next</a></li>";
			}
			
			echo "<ul>";
			
 include './theme/footer.php';?>