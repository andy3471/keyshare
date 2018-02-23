<?php

class profile {
    private $result;
    private $sql;
    
    function getprofilepic($mysqli,$x) {
        $sql = "
        SELECT profilepic FROM users
        WHERE user_id = $x";

        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
        
        while($row = $result->fetch_assoc()) {
                                        
        if (is_null($row["profilepic"])) {
            echo '<a href=".\viewuser.php?id='.$x.'"><img src="./images/defaultpic.jpg" width="100px" height="100px" class="img-thumbnail"></a>';
        } else {
            echo '<a href=".\viewuser.php?id='.$x.'"><img src="./'.$row["profilepic"].'" width="100px" height="100px" class="img-thumbnail"></a>';
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
            echo '<a href=".\viewuser.php?id='.$x.'"><img src="../images/defaultpic.jpg" width="100px" height="100px" class="img-thumbnail"></a>';
        } else {
            echo '<a href=".\viewuser.php?id='.$x.'"><img src="../'.$row["profilepic"].'" width="100px" height="100px" class="img-thumbnail"></a>';
            }
        }
        }
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
                echo '<a href=".\viewgame.php?id='.$x.'"><img src="./images/gamedefault.png" class="img-responsive rounded" width="460" height="215px"></a>';
             } else {
                echo '<a href=".\viewgame.php?id='.$x.'"><img src="./'.$row["image"].'" class="img-responsive rounded" width="460px" height="215px"></a>';
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