<html>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "210";
$dbname = "ergasia_db";

//create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
//check connection
if (!$conn)
{
  die("Connection failed: " . mysqli_connect_error() . "<br>");
}

if(isset($_POST['pharmacyid']))
{
    $searchID = $_POST['pharmacyid'];
}

$result = 0;

if(isset($searchID))
{
$sql = "SELECT Pharmacy.Name AS PhName,Drug.Name AS DName
        FROM Pharmacy,Sell,Drug 
        WHERE Pharmacy.PharmacyId = '$searchID'
        AND Pharmacy.PharmacyId = Sell.PharmacyId
        AND Sell.DrugId = Drug.DrugId ";
$result = mysqli_query($conn,$sql);
}

 if (mysqli_num_rows($result) > 0)
{
  //output data of each row
  while ($row = mysqli_fetch_assoc($result))
  {
  	echo "Pharmacy Name: " . $row["PhName"] . "  |" .
  	     "Drug Name: " . $row["DName"] . "<br>";
  }
} 
else
{
	echo "0 results";
}	

mysqli_close($conn);

?>
<br>
<a href="http://localhost/Ergasia/choose_query.php" target="_self">
<button id="mybtn">Go back to query selection!</button>
</a>

</body>
</html>