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
SELECT platform_id, platformname FROM platforms
order by platformname
";

$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
        echo '<div id="bodytext"> <table class="table"><tr><th> Platform </th></tr>';
    while($row = $result->fetch_assoc()) {
        echo '<tr><td><a href="./viewplatform.php?id='.$row["platform_id"].'">'. $row["platformname"].'</a></td><tr>';
    }
        echo '</table>';
} else {
    echo "0 results";
}

?>
<form method="get" action="./addplatform.php">
    <button type="submit" class="btn btn-default">Add Platform</button>
</form>

<?php
$sql = "
SELECT COUNT(platform_id) AS total FROM platforms 
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