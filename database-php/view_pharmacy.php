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

$sql = "CREATE VIEW Pharmacy_View AS 
         SELECT PharmacyId,Name,Town,StreetName,Number,PostalCode,PhoneNumber
         FROM Pharmacy" ;
   
if (mysqli_query($conn, $sql))
{
echo "Pharmacy View created successfully<br><br>VIEW:<br><br>";
}/*
else
{
echo "Error: " . $sql . "<br>" . mysqli_error($conn) ."<br><br>VIEW:<br><br>";
}*/



$sql = "SELECT PharmacyId,Name,Town,StreetName,Number,PostalCode,PhoneNumber
        FROM Pharmacy_View";
$result = mysqli_query($conn, $sql);   

if (mysqli_num_rows($result) > 0)
{
  //output data of each row
  while ($row = mysqli_fetch_assoc($result))
  {
  	echo "PharmacyID:" . $row["PharmacyId"] . "<br>" . 
         "Pharmacy Name: " . $row["Name"] . "<br>" . 
         "Pharmacy Town: " . $row["Town"] . "<br>" . 
         "Pharmacy Street Name: " . $row["StreetName"] . "<br>" .
         "Pharmacy Number: " . $row["Number"]  ."<br>" . 
         "Pharmacy Postal Code: " . $row["PostalCode"] . "<br>" . 
         "Pharmacy Phone Number:" . $row["PhoneNumber"] . "<br><br>" ;
  }
}
else 
{
	echo "0 results<br>";
}

mysqli_close($conn);
?>

<br>
<a href="http://localhost/Ergasia/main_gui.php" target="_self">
<button id="mybtn">Go back to main menu!</button>
</a>

</body>
</html>