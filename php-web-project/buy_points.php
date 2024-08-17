<?php
require_once 'core/init.php';

$user 	= new User();
$pointsToAdd = 0;

if(!$user->isLoggedIn()){
  Redirect::to('index.php');
}
$curPoints = $user->data()->wallet;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['buy1'])){
    $pointsToAdd = 1;
  }elseif (isset($_POST['buy2'])) {
    $pointsToAdd = 2;
  }elseif (isset($_POST['buy10'])) {
    $pointsToAdd = 10;
  }else{
    $pointsToAdd=0;
  }
}
if($pointsToAdd != 0){

  try{
    $total = $curPoints+$pointsToAdd;
    $user->update(array(
      'wallet'	=> ($total)
    ));
    $pointsToAdd = 0;
    Session::flash('home', 'Points purchased.');
    Redirect::to('index.php');
  } catch(Exception $e){
    die($e->getMessage());
  }
}
//xwse $nullPoints + sto wallet toy



?>
<!-- Modal -->
<div class="modal modal-center fade">
  <div class="modal-dialog w-400px" style="max-width:90vw;">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="px-15 py-10">
          <h4 class="header-title text-center"><strong>Επιλογή πακέτου:</strong></h4>
          <hr class="border-primary w-200px">
          <p class="text-center text-muted">
            <i class="fa fa-quote-left fa-2x fa-pull-left"></i>
            <i>Παρακαλώ επιλέξτε ένα από τα παρακάτω πακέτα.</i>
          </p><br />
          <form action = "buy_points.php" method = "post">
            <input type="submit" class="btn btn-primary btn-block" name="buy1" value="5€ για 1 Null Point" />
          </form>
          <br>

          <form action = "buy_points.php" method = "post">
            <input type="submit" class="btn btn-primary btn-block" name="buy2" value="10€ για 2 Null Point" />
          </form>
          <br>

          <form action = "buy_points.php" method = "post">
            <input type="submit" class="btn btn-primary btn-block" name="buy10" value="50€ για 10 Null Point" />
          </form>
          <br>
        </div>
      </div>
    </div>
  </div>
</div>
