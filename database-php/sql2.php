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

if(isset($_POST['pharmacy_town']))
{
	$searchtown = $_POST['pharmacy_town'];
}

$result = 0;

if(isset($searchtown))
{
	$sql = "SELECT PharmacyId, Name, Town, StreetName,
	               Number, PostalCode, PhoneNumber
	        FROM Pharmacy
	        WHERE Town = '$searchtown' "; 
$result = mysqli_query($conn, $sql);	        
}

if (mysqli_num_rows($result) > 0)
{
	// output data of each row
	while ($row = mysqli_fetch_assoc($result))
	{
		echo "PharmacyID: " . $row["PharmacyId"] . "<br>"
		   . "Name: " . $row["Name"] . "<br>"
		   . "Town: " . $row["Town"] . "<br>"
		   . "Street Name: " . $row["StreetName"] . "<br>"
		   . "Number: " . $row["Number"] . "<br>"
		   . "Postal Code: " . $row["PostalCode"] . "<br>"
		   . "Phone Number: " . $row["PhoneNumber"] . "<br>"
		   . "<br> <br>";
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