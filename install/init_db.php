<?php
include '../theme/installheader.php';
include_once('../includes/db_connect.php');
?>

                <h1> Register </h1>
            
            <?php
// Includes
 
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
} 

// Vars
$username = test_input($_POST['username']);
$password = PASSWORD_HASH($_POST['password'], PASSWORD_BCRYPT); 
$forename = test_input($_POST['forename']);
$surname = test_input($_POST['surname']);
$email = test_input($_POST['email']);

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

//SQL
    
$query= "CREATE TABLE `dlc` (
  `dlc_id` int(11) NOT NULL,
  `dlcname` varchar(45) NOT NULL,
  `game_id` varchar(45) NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_dttm` datetime NOT NULL
) ";

$query .= "CREATE TABLE `games` (
  `game_id` int(11) NOT NULL,
  `gamename` varchar(45) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_user_id` int(11) DEFAULT NULL,
  `created_dttm` varchar(45) DEFAULT NULL
  `image` varchar(255) DEFAULT NULL
  
) ";

$query .= "CREATE TABLE `keys` (
  `key_id` int(11) NOT NULL,
  `game_id` int(11) DEFAULT NULL,
  `dlc_id` int(11) DEFAULT NULL,
  `platform_id` int(11) DEFAULT NULL,
  `keycode` varchar(45) DEFAULT NULL,
  `owned_user` int(11) DEFAULT NULL,
  `removed` binary(1) DEFAULT NULL,
  `created_user_id` int(11) DEFAULT NULL,
  `created_dttm` varchar(45) DEFAULT NULL
) ";

$query .= "CREATE TABLE `platforms` (
  `platform_id` int(11) NOT NULL,
  `platformname` varchar(45) DEFAULT NULL,
  `created_dttm` varchar(45) DEFAULT NULL
) ";

$query .= "INSERT INTO `platforms` (`platform_id`, `platformname`, `created_dttm`) VALUES
(1, 'Steam', '2018-02-04'),
(2, 'Uplay', '2018-02-05'),
(3, 'Origin', '2018-02-05'),
(4, 'Windows Store', '2018-02-05'),
(5, 'Blizzard', '2018-02-05'),
(6, 'GOG', '2018-02-05'),
(7, 'PS3', '2018-02-05'),
(8, 'PS4', '2018-02-05'),
(9, 'PS Vita', '2018-02-05'),
(10, 'Switch', '2018-02-05'),
(11, 'Xbox 360', '2018-02-05'),
(12, 'Xbox One', '2018-02-05');";

$query .= "CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `Name` varchar(45) NOT NULL
) ";

$query .= "INSERT INTO `roles` (`role_id`, `Name`) VALUES
(2, 'Admin'),
(1, 'User');";

$query .= "CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` char(128) NOT NULL,
  `forename` varchar(45) NOT NULL,
  `surname` varchar(45) NOT NULL,
  `email` varchar(50) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `approved` int(1) DEFAULT NULL,
  `profilepic` varchar(255)
) ";


$query .= "ALTER TABLE `dlc`
  ADD PRIMARY KEY (`dlc_id`) USING BTREE,
  ADD UNIQUE KEY `dlcname` (`dlcname`),
  ADD KEY `game_id` (`game_id`),
  ADD KEY `created_user_id` (`created_user_id`);";

$query .= "ALTER TABLE `games`
  ADD PRIMARY KEY (`game_id`),
  ADD UNIQUE KEY `gamename` (`gamename`),
  ADD KEY `created_user_id` (`created_user_id`);";

$query .= "ALTER TABLE `keys`
  ADD PRIMARY KEY (`key_id`),
  ADD UNIQUE KEY `key` (`keycode`),
  ADD KEY `dlc_id` (`dlc_id`),
  ADD KEY `game_id` (`game_id`),
  ADD KEY `platform_id` (`platform_id`),
  ADD KEY `created_user_id` (`created_user_id`),
  ADD KEY `owned_user` (`owned_user`);";

$query .= "ALTER TABLE `platforms`
  ADD PRIMARY KEY (`platform_id`),
  ADD UNIQUE KEY `platformname` (`platformname`);";

$query .= "ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `Name` (`Name`);";

$query .= "ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);";


$query .= "ALTER TABLE `dlc`
  MODIFY `dlc_id` int(11) NOT NULL AUTO_INCREMENT;";

$query .= "ALTER TABLE `games`
  MODIFY `game_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;";

$query .= "ALTER TABLE `keys`
  MODIFY `key_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;";

$query .= "ALTER TABLE `platforms`
  MODIFY `platform_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;";

$query .= "ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;";


$query .= "ALTER TABLE `keys`
  ADD CONSTRAINT `keys_ibfk_1` FOREIGN KEY (`dlc_id`) REFERENCES `dlc` (`dlc_id`),
  ADD CONSTRAINT `keys_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `games` (`game_id`),
  ADD CONSTRAINT `keys_ibfk_3` FOREIGN KEY (`platform_id`) REFERENCES `platforms` (`platform_id`),
  ADD CONSTRAINT `keys_ibfk_4` FOREIGN KEY (`created_user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE SET NULL;";

$query .= "ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);";

$query .= "INSERT INTO USERS (username,password,forename,surname,email,role_id,create_date,approved) VALUES 
    ( '$username','$password','$forename','$surname','$email',2,curdate(),1) ";


$initdb = $mysqli->query($initdbsql);

if ($mysqli->multi_query($query)) {
    do {
        /* store first result set */
        if ($result = $mysqli->store_result()) {
            while ($row = $result->fetch_row()) {
                printf("%s\n", $row[0]);
            }
            $result->free();
        }
        /* print divider */
        if ($mysqli->more_results()) {
            printf("-----------------\n");
        }
    } while ($mysqli->next_result());
}

else {
    echo "Email address '$email' is considered invalid.\n";
}
}

?>