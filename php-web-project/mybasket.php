<?php
require_once 'core/init.php';

$user = new User();


$event_title = "";
$event_date = "";
$pointsToRemove = 0;
$ticketPrice = 2;


if(!$user->isLoggedIn()){
   Redirect::to('index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{

  if (isset($_POST['ticketsNumber']))
  {
		$pointsToRemove = $ticketPrice * $_POST['ticketsNumber'];
  }
}
?>


<div class="main-content center">
	<h3>Το Καλάθι μου</h3>

	<h4>Tίτλος Εκδηλωσης: <?php echo $event_title ?></h4>
	<h4>Ημερομηνία Διεξαγωγής: <?php echo $event_date ?></h4>
	<h4>Τιμή εισιτηρίου: <?php echo $ticketPrice ?></h4>
	<h4>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">Εισιτηρια:<input type="text" name="ticketsNumber">
		<input type="submit" name="submit" value="Επιλογή">
		</form>
	</h4>
  <h4>Πόντοι: <?php echo $pointsToRemove; ?></h4>
	<form  method = "post" action = '<?php echo "removepoints.php"; ?>'>
    <input type="hidden" name="pointsToRemove" value="<?php echo $pointsToRemove; ?>"/>
    <input type="submit" name="pay" value="Πληρωμή" />
	</form>
</div>
