<?php
  // Admin Check
  if((!$user->isLoggedIn()) || !($user->data()->group == 0)) {
    Redirect::to('index.php');
  } else {
    $dbh = new PDO('mysql:host='.Config::get('mysql/host').';'.
                'dbname='.Config::get('mysql/db'),
                Config::get('mysql/username'),
                Config::get('mysql/password'));
    $myusername = $_GET['uname'];
    $stmt = $dbh->prepare("DELETE FROM `users` WHERE `username` = '{$myusername}'");
    $stmt->execute();
    $arrValues = $stmt->fetchAll(PDO::FETCH_ASSOC);
    Redirect::to('index.php?page=admin');
  }

 ?>
