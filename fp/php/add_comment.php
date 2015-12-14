<?php
  require_once './db_connect.php';
  require_once './functions.php';
    
  session_start();

  if (isset($_POST['text']) && isset($_POST['id']))
  {
    $time = $_SERVER['REQUEST_TIME'];
    $text = sanitizeString($db, $_POST['text']);
    $user = $_SESSION['user'];
    $id = $_POST['id'];
    
        /* Prepared statement, stage 1: prepare query */
        if (!($stmt = $db->prepare("INSERT INTO COMMENTS(TIME_STAMP, COMMENT_TEXT, USER, POST_ID) VALUES (?, ?, ?, ?)")))
        {
            return "Prepare failed: (" . $db->errno . ") " . $db->error;
        }

        /* Prepared statement, stage 2: bind parameters*/
        if (!$stmt->bind_param('ssss', $time, $text, $user, $id))
        {
            return "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        /* Prepared statement, stage 3: execute*/
        if (!$stmt->execute())
        {
            return "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
  }
 $db->close();
?>
