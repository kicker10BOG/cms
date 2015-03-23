<!DOCTYPE HTML>
<html>
  <head>
    <?php
      $end_of_title = "404 ERROR - File Not Found";
      $title .= $end_of_title;
      header("HTTP/1.0 404 Not Found");
      header("Location: ../index.php?error=404");
      ?>