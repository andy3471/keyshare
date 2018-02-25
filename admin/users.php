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
SELECT U.user_id, U.displayname, U.forename, U.surname, U.email, R.Name as role, U.approved, steamuser
FROM users AS U 
LEFT JOIN roles AS R 
ON U.role_id = R.role_id 
ORDER BY U.approved, U.displayname
";

$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
        echo '<div id="bodytext"> <table class="table"><tr><th> Display Name </th><th> Forename </th><th> Surname </th><th> Email </th><th> Role </th><th> Steam User? </th><th> Approved? </th></tr>';
    while($row = $result->fetch_assoc()) {
        echo '<tr><td><a href="./viewuser.php?id='.$row["user_id"].'">'. $row["displayname"].'</a></td><td>'. $row["forename"].'</td><td>'. $row["surname"].'</td><td>'. $row["email"].'</td><td>'. $row["role"].'</td><td>';
                if ($row["steamuser"] == 0) {
                    echo 'No</td>';
                }
                else {
                    echo 'Yes</td>';
                }
                echo '<td>';
                if ($row["approved"] == 0) {
                    echo 'No</td><tr>';
                }
                else {
                    echo 'Yes</td><tr>';
                }
    }
        echo '</table>';
} else {
    echo "0 results";
}

$sql = "
SELECT COUNT(user_id) AS total FROM users 
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