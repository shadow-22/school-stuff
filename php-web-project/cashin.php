<?php
require_once 'core/init.php';

$user = new User();

$pointsToRemove = 0;


if(!$user->isLoggedIn()){
   Redirect::to('index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{

  if (isset($_POST['pointsToCashIn']))
  {
		$pointsToRemove = $_POST['pointsToCashIn'];
  }
}
?>

<div class="main-content center">
	<h3>Εξαργύρωση πόντων.</h3>
	<h4>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      Επιθυμητό ποσό Null Coins για εξαργύρωση:
      <input type="text" name="pointsToCashIn">
      <input type="submit" name="submit" value="Επιλογή">
		</form>
	</h4>
  <h4>Ποσό: <?php echo ($pointsToRemove*5); ?> €</h4>
	<form  method = "post" action = '<?php echo "removepoints.php"; ?>'>
    <input type="hidden" name="pointsToRemove" value="<?php echo $pointsToRemove; ?>"/>
    <input type="submit" name="pay" value="Εξαργύρωση" />
	</form>
</div>
