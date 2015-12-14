<?php
    require_once './php/functions.php';

    destroySession();       //End the session and tell the user what's going on

    echo <<<_END
        <!DOCTYPE html>\n<html>
        <head>
            <title>You are logged out</title>
            <META http-equiv="refresh" content="3;URL=http://lamp.cse.fau.edu/~wnazaire2013/fp/index.php">
            <link href='./css/bootstrap.min.css' rel='stylesheet'>
            <link rel="icon" type="image/png" href="../favicon-32x32.png" sizes="32x32" />
            <link rel="icon" type="image/png" href="../favicon-16x16.png" sizes="16x16" />
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="icon" type="../image/png" href="favicon-32x32.png" sizes="32x32" />
            <link rel="icon" type="../image/png" href="favicon-16x16.png" sizes="16x16" />
            <link href="./css/bootstrap.min.css" rel="stylesheet">
            <link href="./css/signin.css" rel="stylesheet">
        </head>
        <div class="container">
        <form class="form-signin" method='post' action='login.php'>
        <h2 class="form-signin-heading">You are logged out</h2>
        <a href='./index.php'>Click here</a> to continue if you are not redirected in 3 seconds.
_END;
?>