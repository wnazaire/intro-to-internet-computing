<?php
    $connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

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

    function sanitizeString($var)
    {
        global $connection;
        $var = strip_tags($var);
        $var = htmlentities($var);
        $var = stripslashes($var);
        return $connection->real_escape_string($var);
    }
?>
