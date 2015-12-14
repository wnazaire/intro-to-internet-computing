<?php
  require_once './db_connect.php';
  require_once './functions.php';

  if (isset($_POST['user']))
  {
    $user   = sanitizeString($db, $_POST['user']);
    $result = queryMysql("SELECT username FROM USERS WHERE username='$user'");
                                //Make sure the username is unique, not just white space, doesn't contain characters that 
                                //have to be escaped, and doesn't contain "admin" Only I can be admin...
    if ($result->num_rows || trim($user) === "" || strpbrk($user, "\"\':;/") != FALSE || stripos($user, "admin") > -1){
      echo "false";
    }
    else{
      echo "true";
    }
  }
 $db->close();
?>
