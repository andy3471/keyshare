<?php include './theme/header.php';
$results_per_page = 15;
if (isset($_GET["page"])) { 
	$page  = $_GET["page"]; 
} 
else { 
	$page=1; 
}; 
$start_from = ($page-1) * $results_per_page;
echo "<h2> Top Users </h2>";
$sql = "
SELECT U.user_id, U.username, IFNULL(TD.createdkeys,0) AS totaldonated, IFNULL(C.createdkeys,0) AS totaldonatedclaimed, IFNULL(O.ownedkeys,0) AS totalowned, (IFNULL(TD.createdkeys,0) - IFNULL(O.ownedkeys,0)) AS karma FROM users as U
LEFT OUTER JOIN (
	SELECT COUNT(created_user_id) AS createdkeys, created_user_id AS user_id FROM `keys`
	WHERE removed is null
	GROUP BY created_user_id
    ) AS TD
ON TD.user_id = U.user_id
LEFT OUTER JOIN (
	SELECT COUNT(created_user_id) AS createdkeys, created_user_id AS user_id FROM `keys`
	WHERE owned_user IS NOT null
	and removed is null
	GROUP BY created_user_id
    ) AS C
ON C.user_id = U.user_id
LEFT OUTER JOIN (
	select count(owned_user) AS ownedkeys, owned_user AS user_id from `keys`
	WHERE removed is null
	GROUP BY owned_user
    ) AS O
ON O.user_id = U.user_id
WHERE U.approved = 1
ORDER BY karma DESC
";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
        echo '<div id="bodytext"> <table class="table"><tr><th> Users </th><th>Total Donated</th><th>Keys Shared (Claimed)</th><th>Keys Taken </th><th>Karma</th></tr>';
    while($row = $result->fetch_assoc()) {
        echo '<tr><td><a href="./viewuser.php?id='.$row["user_id"].'">'. $row["username"].'</a></td>
		<td>'.$row["totaldonated"].'</td>
		<td>'.$row["totaldonatedclaimed"].'</td>
		<td>'.$row["totalowned"].'</td>
                <td><span class="badge badge-pill ';
                    if ($row["karma"] < 0) { echo 'badge-danger">'; }
                    else if ($row["karma"] < 1) { echo 'badge-warning">'; }
                    else if ($row["karma"] < 15) { echo 'badge-info">'; }
                    else { echo 'badge-success">'; }      
                echo $row["karma"].'</span></td></tr>';
    }
        echo '</table>';
} else {
    echo "0 results";
}
//Pagination
$sql = "
SELECT DISTINCT COUNT(user_id) AS total FROM users
WHERE approved = 1";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$total_pages = ceil($row["total"] / $results_per_page); // calculate total pages with results
  
			echo '<br><nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">';
                        
			if ($page == 1) {
				echo "<li class='page-item disabled'><a class='page-link' href='#'>Previous</a></li>";
			} else {
				echo "<li class='page-item'><a class='page-link' href='?page='".($page-1)."'>Previous</a></li>";
			}
			
for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
                        echo "<li class='page-item";
				if ($i==$page)  echo " active";
			echo "'><a class='page-link'href='?page=".$i."'";
                        echo ">".$i."</a></li>";
                        }

			if ($page == $total_pages) {
				echo "<li class='page-item disabled'><a class='page-link' href='#'>Next</a></li>";
			} else {
				echo "<li class='page-item'><a class='page-link' href='?page=".($page+1)."'>Next</a></li>";
			}
			
			echo "<ul></nav>";
			
 include './theme/footer.php';?>