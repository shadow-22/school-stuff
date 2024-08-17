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

$sql = "CREATE VIEW Prescription_View AS 
         SELECT PatientId,DoctorId,DrugId,Date,Quantity
         FROM Prescription " ;
   
if (mysqli_query($conn, $sql))
{
echo "Prescription View created successfully<br><br>VIEW:<br><br>";
}/*
else
{
echo "Error: " . $sql . "<br>" . mysqli_error($conn) ."<br><br>VIEW:<br><br>";
}*/



$sql = "SELECT PatientId,DoctorId,DrugId,Date,Quantity
        FROM Prescription_View";
$result = mysqli_query($conn, $sql);   

if (mysqli_num_rows($result) > 0)
{
  //output data of each row
  while ($row = mysqli_fetch_assoc($result))
  {
  	echo "PatientID: " . $row["PatientId"] . "<br>" . 
         "DoctorID: " . $row["DoctorId"] . "<br>" . 
         "DrugID: " . $row["DrugId"] . "<br>" .
         "Date: " . $row["Date"] . "<br>" . 
         "Quantity: " . $row["Quantity"] . "<br><br>" ;
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