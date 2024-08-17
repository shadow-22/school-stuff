<?php
  // Admin Check
  if((!$user->isLoggedIn())) {
    Redirect::to('index.php');
  } else {
    $dbh = new PDO('mysql:host='.Config::get('mysql/host').';'.
                'dbname='.Config::get('mysql/db'),
                Config::get('mysql/username'),
                Config::get('mysql/password'));
    $myid = $_GET['id'];
    $stmt = $dbh->prepare("DELETE FROM `activity` WHERE `activity_id` = '{$myid}'");
    $stmt->execute();
    $arrValues = $stmt->fetchAll(PDO::FETCH_ASSOC);
    Redirect::to('index.php?page=admin');
  }

 ?>
