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
        SELECT image FROM games
        WHERE game_id = $x";

        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
        
        while($row = $result->fetch_assoc()) {
                                        
        if (is_null($row["image"])) {
            echo '<a href=".\viewgame.php?id='.$x.'"><img src="./images/gamedefault.png" width="420px" height="215px" class="img-thumbnail"></a>';
        } else {
            echo '<a href=".\viewgame.php?id='.$x.'"><img src="./'.$row["image"].'" width="420px" height="215px" class="img-thumbnail"></a>';
            }
        }
        }
    }
}    
    
    ?>