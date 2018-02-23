<?php

class profile {
    private $result;
    private $sql;
    
    function getprofilepic($mysqli,$x,$y) {
        $sql = "
        SELECT profilepic FROM users
        WHERE user_id = $x";

        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
        
        while($row = $result->fetch_assoc()) {
                                        
        if (is_null($row["profilepic"])) {
            echo '<a href=".\viewuser.php?id='.$x.'"><img src="./images/defaultpic.jpg" width="'.$y.'px" height="'.$y.'px" class="img-thumbnail mx-auto d-block"></a>';
        } else {
            echo '<a href=".\viewuser.php?id='.$x.'"><img src="./'.$row["profilepic"].'" width="'.$y.'px" height="$'.$y.'px" class="img-thumbnail mx-auto d-block"></a>';
            }
        }
        }
    }
    
    
    function getprofilepicadmin($mysqli,$x) {
        $sql = "
        SELECT profilepic FROM users
        WHERE user_id = $x";

        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
        
        while($row = $result->fetch_assoc()) {
                                        
        if (is_null($row["profilepic"])) {
            echo '<a href=".\viewuser.php?id='.$x.'"><img src="../images/defaultpic.jpg" width="100px" height="100px" class="img-thumbnail mx-auto d-block"></a>';
        } else {
            echo '<a href=".\viewuser.php?id='.$x.'"><img src="../'.$row["profilepic"].'" width="100px" height="100px" class="img-thumbnail mx-auto d-block"></a>';
            }
        }
        }
    }
    
    function getkarma($mysqli,$x) {
        $sql = "
        SELECT U.username, (IFNULL(C.createdkeys,0) - IFNULL(O.ownedkeys,0)) AS karma FROM users AS U
        LEFT OUTER JOIN (
                SELECT COUNT(created_user_id) AS createdkeys, created_user_id AS user_id FROM `keys`
                WHERE removed IS NULL
                AND created_user_id = $x
                GROUP BY created_user_id
            ) AS C
        ON C.user_id = U.user_id
        LEFT OUTER JOIN (
                SELECT count(owned_user) AS ownedkeys, owned_user AS user_id FROM `keys`
                WHERE removed IS NULL
            AND owned_user = $x
                GROUP BY owned_user
            ) AS O
        ON O.user_id = U.user_id
        WHERE U.approved = 1
        AND U.user_id = $x
        LIMIT 1
        ";

        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo '<span class="badge badge-pill ';
                    if ($row["karma"] < 0) { echo 'badge-danger">'; }
                    else if ($row["karma"] < 1) { echo 'badge-warning">'; }
                    else if ($row["karma"] < 15) { echo 'badge-info">'; }
                    else { echo 'badge-success">'; }      
                echo $row["karma"].'</span>';
            }
        }
    }
    
    
        function getsessionkarma() {
                echo '<span class="badge badge-pill ';
                    if ($_SESSION["karma"] < 0) { echo 'badge-danger">'; }
                    else if ($_SESSION["karma"] < 1) { echo 'badge-warning">'; }
                    else if ($_SESSION["karma"] < 15) { echo 'badge-info">'; }
                    else { echo 'badge-success">'; }      
                echo $_SESSION["karma"].'</span>';
            }
       
 
    
    
    

    
}


class games {
    private $result;
    private $sql;
    
    function getgamepic($mysqli,$x) {
        $sql = "
        SELECT gamename, image FROM games
        WHERE game_id = $x";

        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
        
        while($row = $result->fetch_assoc()) {
            if (is_null($row["image"])) {
                echo '<a href=".\viewgame.php?id='.$x.'"><img src="./images/gamedefault.png" class="img-responsive mx-auto d-block rounded" width="460" height="215px"></a>';
             } else {
                echo '<a href=".\viewgame.php?id='.$x.'"><img src="./'.$row["image"].'" class="img-responsive mx-auto d-block rounded" width="460px" height="215px"></a>';
            }
        }
        }
    }
    
        function getgamepicadmin($mysqli,$x) {
        $sql = "
        SELECT gamename, image FROM games
        WHERE game_id = $x";

        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
        
        while($row = $result->fetch_assoc()) {
            if (is_null($row["image"])) {
                echo '<a href=".\viewgame.php?id='.$x.'"><img src="../images/gamedefault.png" class="img-responsive" align="middle" width="460px" height="215px"></a>';
             } else {
                echo '<a href=".\viewgame.php?id='.$x.'"><img src="../'.$row["image"].'" class="img-responsive" align="middle" width="460px" height="215px></a>';
            }
        }
        }
    }
    
        function getgamecard($mysqli,$x) {
        $sql = "
        SELECT gamename, image FROM games
        WHERE game_id = $x";

        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
        
        while($row = $result->fetch_assoc()) {
            echo '<div class="card" style="width: 18rem;">';
            if (is_null($row["image"])) {
                echo '<a href=".\viewgame.php?id='.$x.'"><img src="./images/gamedefault.png" alt="Card image cap" class="card-img-top"></a>';
             } else {
                echo '<a href=".\viewgame.php?id='.$x.'"><img src="./'.$row["image"].'" alt="Card image cap" class="card-img-top"></a>';
            }
            echo '<div class="card-body">
                    <h5 class="card=title"><a href=".\viewgame.php?id='.$x.'">'.$row["gamename"].'</a></h4>
                  </div>
                  </div>';
        }
        }
    }
    
    
        function getkeycard($mysqli,$x) {
        $sql = "
        SELECT P.platformname, G.gamename, G.image FROM `keys` AS K
        JOIN games AS G
        ON G.game_id = K.game_id
        JOIN platforms as P
        ON P.platform_id = K.platform_id
        WHERE key_id = $x";

        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
        
        while($row = $result->fetch_assoc()) {
            echo '<div class="card" style="width: 18rem;">';
            if (is_null($row["image"])) {
                echo '<a href=".\viewkey.php?id='.$x.'"><img src="./images/gamedefault.png" alt="Card image cap" class="card-img-top"></a>';
             } else {
                echo '<a href=".\viewkey.php?id='.$x.'"><img src="./'.$row["image"].'" alt="Card image cap" class="card-img-top"></a>';
            }
            echo '<div class="card-body">
                    <h5 class="card=title"><a href=".\viewkey.php?id='.$x.'">'.$row["platformname"].' - '.$row["gamename"].'</a></h4>
                  </div>
                  </div>';
        }
        }
    }
    
    
    
}    
    
class page {
    private $total_pages;
    public $i;
    
    function pagination($mysqli, $result) {

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
    }

}


    ?>