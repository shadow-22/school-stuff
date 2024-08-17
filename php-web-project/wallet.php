<?php
require_once 'core/init.php';
$user = new User();

if(!$user->isLoggedIn()){
  Redirect::to('index.php');
}

?>
<!-- Modal -->
<div class="modal modal-center fade">
  <div class="modal-dialog w-300px" style="max-width:90vw;">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="px-15 py-10">

            <h4 class="header-title text-center"><strong>Το Πορτοφόλι μου</strong></h4>
            <hr class="border-primary w-200px">


            <p class="lead text-center">Null Coins: <?php echo escape($user->data()->wallet); ?></p>
            <center><button class="btn btn-outline btn-primary" data-dismiss="modal" data-provide="modaler" data-url="buy_points.php" data-is-modal="true">Αγορά Null Coins</button></center>
        </div>
      </div>
    </div>
  </div>
</div>
