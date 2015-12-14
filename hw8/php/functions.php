<?php
    $connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    function sanitizeString($_db, $str)
    {
        $str = strip_tags($str);
        $str = htmlentities($str);
        $str = stripslashes($str);
        return mysqli_real_escape_string($_db, $str);
    }


    function SavePostToDB($_db, $_user, $_title, $_text, $_time, $_file_name, $_filter)
    {
        /* Prepared statement, stage 1: prepare query */
        if (!($stmt = $_db->prepare("INSERT INTO WALL(USER_USERNAME, STATUS_TITLE, STATUS_TEXT, TIME_STAMP, IMAGE_NAME, FILTER) VALUES (?, ?, ?, ?, ?, ?)")))
        {
            echo "Prepare failed: (" . $_db->errno . ") " . $_db->error;
        }

        /* Prepared statement, stage 2: bind parameters*/
        if (!$stmt->bind_param('ssssss', $_user, $_title, $_text, $_time, $_file_name, $_filter))
        {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        /* Prepared statement, stage 3: execute*/
        if (!$stmt->execute())
        {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
    }

    function getContent($_db)
    {
        $query = "SELECT USER_USERNAME, STATUS_TITLE, STATUS_TEXT, TIME_STAMP, IMAGE_NAME, FILTER FROM WALL ORDER BY TIME_STAMP DESC";

        if(!$result = $_db->query($query))
        {
            die('There was an error running the query [' . $_db->error . ']');
        }

        $output = '';
        while($row = $result->fetch_assoc())
        {
            $title = $row['STATUS_TITLE'];
            $text = $row['STATUS_TEXT'];
            $time = getRelTime($row['TIME_STAMP']);
            
            $output = $output . '<div class="row"><div class="col-md-7"><img class="img-responsive center-block" src="' 
            . $server_root . 'wall_pics/' . $row['IMAGE_NAME'] . '" width="450px" style="-webkit-filter:'
            . $row['FILTER'] . '"></div><div class="col-md-5"><h3>'
            . str_replace("\'", "'", "$title") . '</h3>'
            . '<h4>Posted by <strong>' . $row['USER_USERNAME'] . '</strong> ' . $time . '</h4>'
            . "<p>" . str_replace("\'", "'", "$text") . "</p>"
            . '</div></div><hr>' ;
        }

        return $output;
    }

    function destroySession()
    {
        $_SESSION=array();

        if (session_id() != "" || isset($_COOKIE[session_name()]))
        setcookie(session_name(), '', time()-3200000, '/');

        session_destroy();
    }

     function encrypt($str)
     {
         $salt1 = "3*2^7";
         $salt2 = "#>*w1";

         return hash('ripemd128', "$salt1$str$salt2");
     }

     function queryMysql($query)
     {
         global $connection;
         $result = $connection->query($query);
         if (!$result) die($connection->error);
         return $result;
     }

    function getRelTime($time){
        if(!ctype_digit($time))
            $ts = strtotime($time);

        $diff = time() - $time;

        $day_diff = floor($diff / 86400);
        if($day_diff == 0)
        {
            if($diff < 60) return 'just now';
            if($diff < 120) return '1 minute ago';
            if($diff < 3600) return floor($diff / 60) . ' minutes ago';
            if($diff < 7200) return '1 hour ago';
            if($diff < 86400) return floor($diff / 3600) . ' hours ago';
        }
        if($day_diff == 1) return 'yesterday';
        if($day_diff < 7) return $day_diff . ' days ago';
        if($day_diff < 31) return ceil($day_diff / 7) . ' weeks ago';
        if($day_diff < 60) return 'last month';
        return date('F Y', $ts);
    }
?>