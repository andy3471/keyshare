<?php include './theme/header.php';?>

<div class="col-lg-12g-*">
<?php


$sql = "
SELECT U.user_id, U.username, U.forename, U.surname, U.email, R.Name as role, U.approved 
FROM users AS U 
JOIN roles AS R 
ON U.role_id = R.role_id 
ORDER BY U.approved, U.username
";

$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
        echo '<div id="bodytext"> <table class="table"><tr><th> Username </th><th> Forename </th><th> Surname </th><th> Email </th><th> Role </th><th> Approved? </th></tr>';
    while($row = $result->fetch_assoc()) {
        echo '<tr><td><a href="./viewuser.php?id='.$row["user_id"].'">'. $row["username"].'</a></td><td>'. $row["forename"].'</td><td>'. $row["surname"].'</td><td>'. $row["email"].'</td><td>'. $row["role"].'</td><td>';
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

?>
                        
</div>


<?php include './theme/footer.php';?>