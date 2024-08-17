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
/*
$sql = "SELECT Drug.Name,Price
        FROM (SELECT AVG(Price) AS Avg_price
              FROM Sell),Drug,Sell
        WHERE Drug.DrugId=Sell.DrugId AND Price>Avg_price";
$sql1 = "SELECT Avg_price";
echo "avg.price is = " . $row['$sql1'] . "<br>" ;
*/

$sql = "SELECT First,Last
        FROM 
       (SELECT FirstName AS First,LastName AS Last,Speciality AS Spec,ExperienceYears AS Exp       
        FROM Doctor
        WHERE ExperienceYears >= 30) as Table1
        WHERE Spec = 'Cardiology'";
/*
if (mysqli_query($conn, $sql))
{
echo "Table 'Table1' created successfully<br>";
}
else
{
echo "Error: " . $sql . "<br>" . mysqli_error($conn) ."<br>";
}        
*/
$result = mysqli_query($conn,$sql);

/*
if (mysqli_num_rows($result) > 0)
{
  while ($row = mysqli_fetch_assoc($result))
  {
  	echo "Drug Name: " . $row['Avg_price'] . "<br>";
  }       
}
else
{
	echo "0 results<br>";
}
*/

if (mysqli_num_rows($result) > 0)
{
  while ($row = mysqli_fetch_assoc($result))
  {
  	echo "First Name: " . $row['First'] . "<br>" .
         "Last Name:" . $row['Last'] . "<br><br>" ;
  }       
}
else
{
	echo "0 results<br>";
}

mysqli_close($conn);
?>

<br>
<a href="http://localhost/Ergasia/choose_query.php" target="_self">
<button id="mybtn">Go back to query selection!</button>
</a>

</body>
</html>