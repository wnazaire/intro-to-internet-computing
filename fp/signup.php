<?php
    require_once './php/db_connect.php';
    require_once './php/functions.php';
    
    $connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname); 
    if ($connection->connect_error) die($connection->connect_error);
    
    echo <<<_END
        <!DOCTYPE html>\n<html>
        <head> 
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="icon" type="image/png" href="../favicon-32x32.png" sizes="32x32" />
            <link rel="icon" type="image/png" href="../favicon-16x16.png" sizes="16x16" />
            <title>Sign up</title>
            <link href="./css/bootstrap.min.css" rel="stylesheet">
            <link href="./css/signin.css" rel="stylesheet">
        </head>
        <script>
            function checkUser(user)
            {
                var val = user.value;
                if (val == '')
                {
                    $('#validation_state').removeClass("form-group has-error");
                    $('#validation_state').removeClass("form-group has-success");
                    $('#info').text('');
                    $('#info').removeClass("error");
                    $('#info').removeClass("success");
                    return
                } else {
                    $.post("./php/check_user.php", { user: val },
                    function(data){
                        if (data == "true"){
                            $('#validation_state').removeClass("form-group has-error");
                            $('#validation_state').addClass("form-group has-success");
                            $('#info').text('This username is available');
                            $('#info').removeClass("error");
                            $('#info').addClass("success");
                        } else {
                            $('#validation_state').removeClass("form-group has-success");
                            $('#validation_state').addClass("form-group has-error");
                            $('#info').text('This username is not available');
                            $('#info').removeClass("success");
                            $('#info').addClass("error");
                        }
                    });
                }
            }
        </script>
        
        <div class="container">
        <form id="signupUser" class="form-signin" method='post' action='signup.php'>
        <h2 class="form-signin-heading">Enter your details</h2>
_END;
    
    $error = $user = $pass = $passver= "";

    function add_user($connection, $un, $pw)
    {
        $query = "INSERT INTO USERS VALUES('$un', '$pw')";
        $result = $connection->query($query);
        if (!result) die($connection->connect_error);
    }

    if (isset($_SESSION['user'])) destroySession();

    if (isset($_POST['user']))
    {
        $user = sanitizeString($db, $_POST['user']);                            //Get the form fields
        $pass = sanitizeString($db, $_POST['pass']);
        $passver = sanitizeString($db, $_POST['passver']);

        if ($user == "" || $pass == "" || $passver == "")                       //Check to see that all fields were entered
        {
            $error = "Not all fields were entered<br>";
        }
        else if ($pass != $passver)                                             //Check to see if passwords match
        {
            $error = "Passwords don't match<br>";
        }
        else
        {                                                                       //Check to see if username already exists
          $result = queryMySQL("SELECT username FROM USERS WHERE username='$user'");

          if ($result->num_rows > 0 || stripos($user, "admin") > -1)
          {
            $error = "Username unavailable";
          }
          else                                                                  //All else successful, so add user to table
          {
            $token = encrypt($pass);
            add_user($connection, $user, $token);
            echo '<META http-equiv="refresh" content="3;URL=http://lamp.cse.fau.edu/~wnazaire2013/fp/index.php">';
            die("Sign up sucessful! <a href='index.php'>Login here</a> if redirect fails.");
          }
        }
    }

    echo <<<_END
    $error
    <div id='info' class=""></div>
    <div id="validation_state" class="">
    <label for="user" class="sr-only">Username</label>
        <input type="text" id="user" name="user" class="form-control" maxlength="13" size="13" placeholder="Choose a username" value="$user" required autofocus onBlur='checkUser(this)'>
    </div>
    <label for="pass" class="sr-only">Password</label>
        <input type="password" id="pass" name="pass" class="form-control" placeholder="Password" required>
    <label for="passver" class="sr-only">Verify password</label>
        <input type="password" id="passver" name="passver" class="form-control" placeholder="Verify password" required>
_END;

    $db->close();
?>

            <br>
            <input type="button" id="signup" value="Sign up!" class="btn btn-md btn-primary btn-block">
            <br>
            <p>Already have an account? <a href="./index.php">Log in here.</a></p>
        </form>
    </div>
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Functions -->
    <script src="./functions.js"></script>
  </body>
</html>