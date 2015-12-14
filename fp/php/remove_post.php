<?php
    require_once "./db_connect.php";
    require_once "./functions.php";

    session_start();

    if ($_SESSION['user'] == 'Lilian' || $_SESSION['user'] == 'omarques')       //Check to see if the user has administrative rights
    {
        echo "<!DOCTYPE html>\n<html><head><title>Remove Post</title>";
        
        if(isset($_POST['image_name']))
        {
            $name = $_POST['image_name'];
                                                                                //Get comment id of post to be deleted
            $query_id = "SELECT COMMENT_ID FROM WALLI WHERE IMAGE_NAME='$name'";
            $result = queryMysql($query_id);
            while($row = $result->fetch_assoc())
            {
                $id = $row['COMMENT_ID'];
            }
                                                                                //Delete comments
            $query_delete_comments = "DELETE FROM COMMENTS WHERE POST_ID='$id'";
            queryMysql($query_delete_comments);
                                                                                //Delete post
            $query_delete_post = "DELETE FROM WALLI WHERE IMAGE_NAME = '$name'";
            queryMysql($query_delete_post);
            
            $dstFolder = '../quarantine/';
            fclose(realpath($dstFolder.$name));                                 //Close image if open
            unlink(realpath($dstFolder.$name));                                 //Remove image from server
                   
            header("Location: http://lamp.cse.fau.edu/~wnazaire2013/fp/rd.php");//Redirect to prevent form resubmission
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