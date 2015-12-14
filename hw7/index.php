<?php
    require_once './db_connect.php';
    require_once './functions.php';

    echo <<<_END
    <!DOCTYPE html>\n<html><head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="../favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="../favicon-16x16.png" sizes="16x16" />
    <title>Login</title>
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/signin.css" rel="stylesheet">
    <div class="container">
    <form class="form-signin" method='post' action='index.php'>
    <h2 class="form-signin-heading">Please log in</h2>
_END;

    $error = $user = $pass = "";

    if (isset($_POST['user']))
    {
        $user = sanitizeString($_POST['user']);
        $pass = sanitizeString($_POST['pass']);

        if ($user == "" || $pass == "")                         //Check to see if all the fields were entered
        {
            $error = "Not all fields were entered";
        }
        else
        {
            $token = encrypt($pass);
            $result = queryMySQL("SELECT username,password FROM USERS
                    WHERE username='$user' AND password='$token'");

            if ($result->num_rows == 0)                         //Check to see if the username/password combination is correct
            {
                $error = "<span class='error'>Username/Password
                        invalid</span><br><br>";
            }
            else                                                //Username/Password match, start the session and redirect to The Wall
            {
                session_start();
                $_SESSION['user'] = $user;
                $_SESSION['pass'] = $token;
                die("Click to proceed to <a href='wall.php'>The Wall</a>");
            }
        }
    }

    echo <<<_END
    $error
      <label for="user" class="sr-only">Username</label>
        <input type="text" name="user" class="form-control" placeholder="Username" value="$user" required autofocus>
        <label for="pass" class="sr-only">Password</label>
        <input type="password" name="pass" class="form-control" placeholder="Password" required>
_END;

    $db->close();                                               //The db_connect form said that we were to include this at the end of every file that uses it.
?>

            <button class="btn btn-md btn-primary btn-block" type="submit">Login</button>
            <br>
            <p>Don't have an account? <a href="./signup.php">Sign up!</a></p>
        </form>
    </div>
  </body>
</html>