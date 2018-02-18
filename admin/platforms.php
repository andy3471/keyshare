<?php include './theme/header.php';?>


<?php


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


<?php include '../theme/footer.php';?>