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
                if (user.value == '')
                {
                    document.getElementById('info').innerHTML = ''
                    return
                }
                
                $.post("./php/check_user.php",
                {
                    user: user.value
                },
                function(data, status){
                    alert(data);
                });
            }
        </script>
        
        <div class="container">
        <form class="form-signin" method='post' action='signup.php'>
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

          if ($result->num_rows > 0)
          {
            $error = "<span class='error'>Username already exists</span><br><br>";
          }
          else                                                                  //All else successful, so add user to table
          {
            $token = encrypt($pass);
            add_user($connection, $user, $token);
            header("Location: http://lamp.cse.fau.edu/~wnazaire2013/fp/index.php");
            die("Sign up sucessful! <a href='index.php'>Login here.</a>");
          }
        }
    }

    echo <<<_END
    <span id='info'>$error</span>
    <label for="user" class="sr-only">Username</label>
        <input type="text" name="user" class="form-control" placeholder="Choose a username" value="$user" required autofocus onBlur='checkUser(this)'>
    <label for="pass" class="sr-only">Password</label>
        <input type="password" name="pass" class="form-control" placeholder="Password" required>
    <label for="passver" class="sr-only">Verify password</label>
        <input type="password" name="passver" class="form-control" placeholder="Verify password" required>
_END;

    $db->close();
?>

            <br>
            <button class="btn btn-md btn-primary btn-block" type="submit">Sign up!</button>
            <br>
            <p>Already have an account? <a href="./index.php">Log in here.</a></p>
        </form>
    </div>
    <script src="js/jquery.js"></script>
  </body>
</html>