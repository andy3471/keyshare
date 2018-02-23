<?php include './theme/header.php';

echo "<h2> Top Users </h2>";
$sql = "
SELECT U.user_id, (IFNULL(TD.createdkeys,0) - IFNULL(O.ownedkeys,0)) AS karma FROM users as U
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
LIMIT 5
";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $profile->getprofilecard($mysqli,$row["user_id"]);
        echo '<br>';
    }
} else {
    echo "0 results";
}

			
 include './theme/footer.php';?>