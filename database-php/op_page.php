<html>
<body>

<?php
if ($_POST['op'] == 'insert')
{
  echo 'You want insertion to happen to...<br>
  <form action="handle_insert.php" method="post">
  <input type="radio" name="array" value="Patient"> Patient<br>
  <input type="radio" name="array" value="Doctor"> Doctor<br>
  <input type="radio" name="array" value="Pharmacy"> Pharmacy<br>
  <input type="radio" name="array" value="Drug"> Drug<br>
  <input type="radio" name="array" value="Company"> Pharmaceutical Company<br>
  <input type="radio" name="array" value="Sell"> Sell<br>
  <input type="radio" name="array" value="Prescription"> Prescription<br>
  <input type="radio" name="array" value="Contract"> Contract<br>
  <input type="submit" value="Submit">
</form>';
}

if ($_POST['op'] == 'delete')
{
  echo 'You want deletion to happen to...<br>
  <form action="handle_delete.php" method="post">
  <input type="radio" name="array" value="Patient"> Patient<br>
  <input type="radio" name="array" value="Doctor"> Doctor<br>
  <input type="radio" name="array" value="Pharmacy"> Pharmacy<br>
  <input type="radio" name="array" value="Drug"> Drug<br>
  <input type="radio" name="array" value="Company"> Pharmaceutical Company<br>
  <input type="radio" name="array" value="Sell"> Sell<br>
  <input type="radio" name="array" value="Prescription"> Prescription<br>
  <input type="radio" name="array" value="Contract"> Contract<br>  
  <input type="submit" value="Submit">
</form>';
}

if ($_POST['op'] == 'update')
{
  echo 'You want updating to happen to...<br>
  <form action="handle_update.php" method="post">
  <input type="radio" name="array" value="Patient"> Patient<br>
  <input type="radio" name="array" value="Doctor"> Doctor<br>
  <input type="radio" name="array" value="Pharmacy"> Pharmacy<br>
  <input type="radio" name="array" value="Drug"> Drug<br>
  <input type="radio" name="array" value="Company"> Pharmaceutical Company<br>
  <input type="radio" name="array" value="Sell"> Sell<br>
  <input type="radio" name="array" value="Prescription"> Prescription<br>
  <input type="radio" name="array" value="Contract"> Contract<br>  
  <input type="submit" value="Submit">
</form>';
}

?>

</body>
</hmtl>
