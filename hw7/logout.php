<?php
    require_once './functions.php';

    destroySession();       //End the session and tell the user what's  going on

    echo <<<_END
        <!DOCTYPE html>\n<html><head> 
        <link href='./css/bootstrap.min.css' rel='stylesheet'>
        <link rel="icon" type="image/png" href="../favicon-32x32.png" sizes="32x32" />
        <link rel="icon" type="image/png" href="../favicon-16x16.png" sizes="16x16" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="../image/png" href="favicon-32x32.png" sizes="32x32" />
        <link rel="icon" type="../image/png" href="favicon-16x16.png" sizes="16x16" />
        <title>Log out</title>
        <link href="./css/bootstrap.min.css" rel="stylesheet">
        <link href="./css/signin.css" rel="stylesheet">
        <div class="container">
        <form class="form-signin" method='post' action='index.php'>
        <h2 class="form-signin-heading">You are logged out</h2>
        <a href='./index.php'>Log in</a> again.
_END;
?>