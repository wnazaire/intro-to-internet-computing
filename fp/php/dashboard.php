<?php
    require_once "./db_connect.php";
    require_once "./functions.php";

    session_start();
    
    function getUsers()
    {
        $query = "SELECT username FROM USERS ORDER BY username ASC";

        $result = queryMysql($query);
        
        $output = '';
        
        while($row = $result->fetch_assoc())
        {
            $output = $output . '<tr> <td>' . $row['username'] . '</td>'
            . '<td> <form name="Remove ' . $row['username']
            . '" class="form-horizontal" method="POST" action="./remove_user.php">'
            . '<input type="button" value="Remove ' . $row['username']
            . '" class="btn btn-primary btn-xs btn-block" id="remove_user"> </td>'
            . '<input type="hidden" class="form-control" name="username" value="' 
            . $row['username'] . '" id="username">'
            . '</form>' 
            . '</tr>';
        }
        
        return $output;
    }
    
    if ($_SESSION['user'] == 'Lilian' || $_SESSION['user'] == 'omarques')       //Check to see if the user has administrative rights
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

                <title>Admin Dashboard</title>

                <!-- Bootstrap Core CSS -->
                <link href="../css/bootstrap.min.css" rel="stylesheet">

                <!-- Custom CSS -->
                <link href="../css/1-col-portfolio.css" rel="stylesheet">

                <!-- Tweaks -->
                <link href="../css/wall.css" rel="stylesheet">
                <link href="../css/signin.css" rel="stylesheet">

                <!-- Favicon -->
                <link rel="icon" type="image/png" href="../../favicon-32x32.png" sizes="32x32" />
                <link rel="icon" type="image/png" href="../../favicon-16x16.png" sizes="16x16" />

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
                                <a href="../form.php">Post to The Wall</a>
                            </li>
                            <li>
                                <a href="../wall.php">The Wall</a>
                            </li>
                            <li>
                                <a href="../logout.php">Logout</a>
                            </li>
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
                        <h1 class="page-header">Admin Dashboard</h1>
                    </div>
                </div>
                <div class="container" id="content">
                <div class="col-sm-6 col-sm-offset-3">
                    <table class="table table-condensed">
                        <tr><th>Username</th> <th>Remove Button</th></tr>
_END;
        echo getUsers();
        echo <<<_END
                    </table>
                </div>
        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Willene Nazaire 2015 -- <a href="http://startbootstrap.com/template-overviews/1-col-portfolio/">Template</a> from Start Bootstrap</p>
                </div>
            </div>
            <!-- /.row -->
        </footer>

        </div>
        <!-- /.container -->

        <!-- jQuery -->
        <script src="../js/jquery.js"></script>
        
        <script src="../functions.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../js/bootstrap.min.js"></script>
    </body>
    </html>
_END;
    }
    else                                                    //Otherwise tell them to login properly
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