<?php
require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()){
  Session::flash('home', 'Tickets purchased succesfully.');
  Redirect::to('index.php');
}


$curPoints = $user->data()->wallet;
if (isset($_POST['pointsToRemove']) )
{
  $pointsToRemove = $_POST['pointsToRemove'];
  if ($curPoints >= $pointsToRemove){
    try{
      $user->update(array(
        'wallet' => ($curPoints-$pointsToRemove)
      ));

      $user->create2(array(

       'activity_id' => $_POST['activity_id'],
       'username'  => $user->data()->username,
       'valid' => 1,
       'number' => hash('sha256', $_POST['activity_id'] . $user->data()->username)
     ),'tickets');



      Session::flash('home', 'Purchase completed succefully.');
      Redirect::to('index.php');
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }else{
    try{
      Session::flash('home', 'Not enough Null Points.');
      Redirect::to('index.php');
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }
}

?>
