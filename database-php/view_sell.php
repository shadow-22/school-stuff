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

$sql = "CREATE VIEW Sell_View AS 
         SELECT PharmacyId,DrugId,Price
         FROM Sell
       /*  WHERE Age > 20*/ " ;
   
if (mysqli_query($conn, $sql))
{
echo "Sell View created successfully<br><br>VIEW:<br><br>";
}/*
else
{
echo "Error: " . $sql . "<br>" . mysqli_error($conn) ."<br><br>VIEW:<br><br>";
}*/



$sql = "SELECT PharmacyId,DrugId,Price
        FROM Sell_View";
$result = mysqli_query($conn, $sql);   

if (mysqli_num_rows($result) > 0)
{
  //output data of each row
  while ($row = mysqli_fetch_assoc($result))
  {
  	echo "PharmacyID: " . $row["PharmacyId"] . "<br>" . 
         "DrugId: " . $row["DrugId"] . "<br>" . 
         "Price: " . $row["Price"] . "<br><br>" ;
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