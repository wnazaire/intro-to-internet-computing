<?php
    require_once "./php/db_connect.php";
    require_once "./php/functions.php";
        
    if(isset($_GET['post']))
    {
        $image_name = $_GET['post'] . ".jpg";
    }

    function getComments($id)
    {
        $query = "SELECT TIME_STAMP, COMMENT_TEXT, USER FROM COMMENTS WHERE POST_ID='$id'";
        $output = "";
        
        $result = queryMysql($query);
        
        if ($result->num_rows)
        {
            while($row = $result->fetch_assoc())
            {
                $comment_text = $row['COMMENT_TEXT'];
                $output = $output . '<hr><h4><strong>' . $row['USER'] . '</strong> said, </h4>'
                . '<p>"' . unescapeSpecialCharacters($comment_text) . '"</p>'
                . getRelTime($row['TIME_STAMP']);
            }
        }
        
        return $output;
    }

    session_start();

    if (isset($_SESSION['user']))                           //Check to see if the user has logged in
    {
        $name = $_SESSION['user'];
        echo <<<_END
        <!DOCTYPE html>
        <html lang="en">

        <head>

            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="">
            <meta name="author" content="">

            <title>Comments</title>

            <!-- Bootstrap Core CSS -->
            <link href="css/bootstrap.min.css" rel="stylesheet">

            <!-- Custom CSS -->
            <link href="css/1-col-portfolio.css" rel="stylesheet">

            <!-- Tweaks -->
            <link href="css/wall.css" rel="stylesheet">
            <link href="css/signin.css" rel="stylesheet">

            <!-- Favicon -->
            <link rel="icon" type="image/png" href="../favicon-32x32.png" sizes="32x32" />
            <link rel="icon" type="image/png" href="../favicon-16x16.png" sizes="16x16" />

            <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
            <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
                <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <![endif]-->

        </head>
        <body>
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <p class="navbar-brand">Welcome $name</p>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="#top">Top of Page</a>
                        </li>
                        <li>
                            <a href="form.php">Post to The Wall</a>
                        </li>
                        <li>
                            <a href="wall.php">The Wall</a>
                        </li>
                        <li>
                            <a href="logout.php">Logout</a>
                        </li>
_END;
        
        if ($name == 'Lilian' || $name == 'omarques')
        {
            echo '<li><a href="./php/dashboard.php">Admin Dashboard</a></li>';
        }
        
        echo <<<_END
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>

        <!-- Page Content -->
        <div class="container" id="top">
        
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Post Comments</h1>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
            
_END;
        $query = "SELECT USER_USERNAME, STATUS_TITLE, STATUS_TEXT, TIME_STAMP, FILTER, COMMENT_ID FROM WALLI WHERE IMAGE_NAME='$image_name'";
        $result = queryMysql($query);
                                                            //Check to see if a post actually exists
        if ($result->num_rows === 0)
        {
            echo '<p class="text-center">There seems to be nothing here</p>';
        }
        else
        {
            $output = "";
                                                            //Get the original post
            if ($result->num_rows)
            {
                while($row = $result->fetch_assoc())
                {
                    $title = $row['STATUS_TITLE'];
                    $text = $row['STATUS_TEXT'];
                    $id = $row['COMMENT_ID'];

                    $output = '<img class="img-responsive center-block" src="' 
                    . $server_root . '/quarantine/' . $image_name . '" width="450px" style="-webkit-filter:'
                    . $row['FILTER'] . '"></div><div class="col-md-6 col-md-offset-3"><h3>'
                    . unescapeSpecialCharacters($title) . '</h3>'
                    . '<h4>Posted by <strong>' . $row['USER_USERNAME'] . '</strong> on ' . date('F jS, Y g:i a', $row['TIME_STAMP']) . '</h4>'
                    . "<p>" . unescapeSpecialCharacters($text) . "</p>";
                }
            }
            echo $output;
                                                            //Display the commenting form
            echo '<form id="postComment" class="form-horizontal" method="POST" action="./post_comment.php" enctype="multipart/form-data">
                    <label for="commentText" class="control-label">Post a comment!</label>
                    <textarea class="form-control" id="commentText" name="commentText" maxlength="140" placeholder="140 characters" required></textarea>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="hidden" class="form-control" id="post_name" name="post_name" value=';
            echo $id;
            echo '>
                        </div>
                    </div>
                    <br>
                    <input type="button" id="submitComment" value="Post comment" class="btn btn-primary btn-sm"></form>
                    <br><br>
                    <h3>Comments on this post</h3>';
                                                            //Get the actual comments if there are any
            $comments = getComments($id);
            
            if ($comments)
            {
                echo $comments;
            }
            else
            {
                echo '<p class="text-center">No comments yet. Be the first to post one!</p>';
            }
            
            echo '</div></div></div>
                    <!-- jQuery -->
                    <script src="js/jquery.js"></script>

                    <!-- Functions -->
                    <script src="./functions.js"></script>';
        }
    }
    else                                                    //Tell them to login properly if they aren't
    {
        echo <<<_END
        <!DOCTYPE html>\n<html><head> 
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>The Wall</title>
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