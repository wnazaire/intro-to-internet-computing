<?php
  require_once './functions.php';

  if (isset($_POST['user']))
  {
    $user   = sanitizeString($_POST['user']);
    $result = queryMysql("SELECT * FROM USERS WHERE username='$user'");

    if ($result->num_rows)
      echo "This username is taken";
    else
      echo "This username is available";
  }
?>
