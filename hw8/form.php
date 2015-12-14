<?php
    require_once "./php/db_connect.php";
    require_once "./php/functions.php";

    session_start();

    if (isset($_SESSION['user']))                           //Check to see if the user has logged in
    {
        echo <<<_END
        <!DOCTYPE html>
        <html>
        <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Post to The Wall</title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">

        <link rel="stylesheet" href="css/signin.css">
        
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="css/form.css">
        
        <!-- Font Awesome CDN -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="../favicon-32x32.png" sizes="32x32" />
        <link rel="icon" type="image/png" href="../favicon-16x16.png" sizes="16x16" />

        <link href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        </head>
        <body onload="initialize();">
            <div class="container">    
                <div class="row">
                    <div id="formParent" class="col-md-6 col-md-offset-3">
                        <h2 class="text-center">Upload a photo to post to The Wall</h2>
                        <br>
                        <form id="form" class="form-horizontal" method="POST" action="wall.php" enctype="multipart/form-data">
                        
                            <div class="form-group">
                                <label class="sr-only" for="image">Original Image</label>
                                <img class="img-responsive center-block" id="image" name="image" src="./img/placeholder.png">
                                <input type="file" id="upload" name="upload" accept="image/*" required>
                            </div>
                            
                            <br>
                            
                            <div class="form-group">
                                <label for="title" class="control-label col-xs-1">Title</label>
                                <div class="col-xs-11">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-header fa-fw"></span></span>
                                        <input type="text" class="form-control" id="title" name="title" 
                                    maxlength="30" size="20" value="" required placeholder="30 characters" autofocus>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="text" class="control-label col-xs-1">Text</label>
                                <div class="col-xs-11">
                                    <textarea class="form-control" id="text" name="text" maxlength="140" placeholder="140 characters" required></textarea>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <h3>Filter Photo</h3>
                                <div class="checkbox-inline">
                                    <label for="myNostalgia">Nostalgia</label>
                                    <input type="radio" name="filter" id="myNostalgia" value="myNostalgia" onclick="applyNostalgiaFilter();">
                                </div>
                                <div class="checkbox-inline">
                                    <label for="grayscale">Grayscale</label>
                                    <input type="radio" name="filter" id="grayscale" value="grayscale" onclick="applyGrayscaleFilter();">
                                </div>
                                <div class="checkbox-inline">
                                    <label for="original">Invert</label>
                                    <input type="radio" name="filter" id="invert" value="invert" onclick="applyInvertFilter();">
                                </div>
                                <div class="checkbox-inline">
                                    <label for="original">Blur</label>
                                    <input type="radio" name="filter" id="blur" value="blur" onclick="applyBlurFilter();">
                                </div>
                                <div class="checkbox-inline">
                                    <label for="original">Original Image</label>
                                    <input type="radio" name="filter" id="original" checked="checked" value="original" onclick="revertToOriginal();">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="hidden" class="form-control" id="tempFilter" name="tempFilter" 
                                 value="">
                                </div>
                            </div>
                    
                            <input type="submit" value="Upload image" class="btn btn-primary">
                            <input type="button" id="resetForm" value="Reset" class="btn btn-default" onclick="location.reload();">
                            
                            <br><br>
                            <a href="wall.php"><i class="fa fa-long-arrow-left"></i>Back to The Wall</a>
                        </form>
                    </div>
                </div>
            </div>

            <!-- JavaScript placed at bottom for faster page loadtimes. -->
            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

            <!-- Latest compiled and minified JavaScript -->
            <script src="./js/bootstrap.min.js"></script>

            <script src="./functions.js"></script>            
        </body>
        </html>
_END;
    }
    else
    {
        echo <<<_END
        <!DOCTYPE html>\n<html><head> 
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Post to The Wall</title>
        <link href="./css/bootstrap.min.css" rel="stylesheet">
        <link href="./css/signin.css" rel="stylesheet">
        <div class="container">
        <form class="form-signin" method='post' action='index.php'>
        <h2 class="form-signin-heading">Access denied</h2>
        Please <a href='./index.php'>log in</a> or <a href='./signup.php'>sign up</a> if you don't have an account.   
_END;
    }

    $db->close(); 
?>