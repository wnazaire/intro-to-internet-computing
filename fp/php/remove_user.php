<?php
    require_once "./db_connect.php";
    require_once "./functions.php";

    session_start();

    if ($_SESSION['user'] == 'Lilian' || $_SESSION['user'] == 'omarques')       //Check to see if the user has administrative rights
    {
        echo "<!DOCTYPE html>\n<html><head><title>Remove User</title>";
        
        if(isset($_POST['username']))
        {
            $user = $_POST['username'];
            $query = "DELETE FROM USERS WHERE username = '$user'";
            queryMysql($query);
   
            header("Location: http://lamp.cse.fau.edu/~wnazaire2013/fp/php/rd2dash.php");//Redirect to prevent form resubmission
        }
    }
    else
    {
        echo <<<_END
        <!DOCTYPE html>\n<html><head> 
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Access Denied</title>
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/signin.css" rel="stylesheet">
        <div class="container">
        <form class="form-signin" method='post' action='index.php'>
        <h2 class="form-signin-heading">Access denied</h2>
        This page is for administrators only.   
_END;
    }

    $db->close(); 
?>