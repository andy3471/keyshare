<?php include './theme/header.php';

$results_per_page = 15;

if (isset($_GET["page"])) { 
	$page  = $_GET["page"]; 
} 
else { 
	$page=1; 
}; 

$start_from = ($page-1) * $results_per_page;

//get id from url, else redirect
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header('Location: topusers.php');
    exit();
}

$sql = "
SELECT username FROM users
WHERE approved = 1
AND user_id = $id
LIMIT 1
";

$result = $mysqli->query($sql);


if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

        $profile->getprofilecard($mysqli,$id);
        echo '<br>';

        //Get Available Keys
        $fetchkeys = "
        SELECT G.gamename, K.key_id, P.platformname FROM `keys` AS K
        JOIN platforms AS P
        ON K.platform_id = P.platform_id
        JOIN users AS U
        ON K.created_user_id = U.user_id
        JOIN games AS G
        ON G.game_id = K.game_id
        WHERE K.created_user_id = $id
        AND K.removed IS NULL
        AND K.owned_user IS NULL
	LIMIT $start_from, $results_per_page
        ";

        $keyresults = $mysqli->query($fetchkeys);

            echo '<table class="table"><tr><th>Game</th><th>Platform</th></tr>';
        if ($keyresults->num_rows > 0) {
            // output data of each row
            while($keyrow = $keyresults->fetch_assoc()) {
                
                echo '<tr><td><a href="./viewkey.php?id='.$keyrow["key_id"].'">'.$keyrow["gamename"].'</a></td><td>'.$keyrow["platformname"].'</tr>';
            }
        } else {
            echo "0 Donated Keys";
        }
            echo '</table>';
       }

   $sql = "
        SELECT count(K.key_id) AS total FROM `keys` AS K
        WHERE K.created_user_id = $id
        AND removed IS NULL
        AND owned_user IS NULL";

$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$total_pages = ceil($row["total"] / $results_per_page); // calculate total pages with results
  
			echo '<br><nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">';
                        
			if ($page == 1) {
				echo "<li class='page-item disabled'><a class='page-link' href='#'>Previous</a></li>";
			} else {
				echo "<li class='page-item'><a class='page-link' href='?id=".$id."&page='".($page-1)."'>Previous</a></li>";
			}
			
for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
                        echo "<li class='page-item";
				if ($i==$page)  echo " active";
			echo "'><a class='page-link'href='?id=".$id."&page=".$i."'";
                        echo ">".$i."</a></li>";
                        }

			if ($page == $total_pages) {
				echo "<li class='page-item disabled'><a class='page-link' href='#'>Next</a></li>";
			} else {
				echo "<li class='page-item'><a class='page-link' href='?id=".$id."&page=".($page+1)."'>Next</a></li>";
			}
			
			echo "<ul></nav>";

   
   
} else {
   header('Location: topusers.php');
}




include './theme/sidebar.php';
include './theme/footer.php';?>