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

$sql = "CREATE VIEW Patient_View AS 
         SELECT PatientId,FirstName,LastName,Town,StreetNumber,Number,PostalNumber,Age,DoctorId
         FROM Patient
       /*  WHERE Age > 20*/ " ;
   
if (mysqli_query($conn, $sql))
{
echo "Patient View created successfully<br><br>VIEW:<br><br>";
}/*
else
{
echo "Error: " . $sql . "<br>" . mysqli_error($conn) ."<br><br>VIEW:<br><br>";
}*/



$sql = "SELECT PatientId,FirstName,LastName,Town,StreetNumber,Number,PostalNumber,Age,DoctorId
        FROM Patient_View";
$result = mysqli_query($conn, $sql);   

if (mysqli_num_rows($result) > 0)
{
  //output data of each row
  while ($row = mysqli_fetch_assoc($result))
  {
  	echo "PatientID:" . $row["PatientId"] . "<br>" . 
         "Patient First Name: " . $row["FirstName"] . "<br>" . 
         "Patient Last Name: " . $row["LastName"] . "<br>" .
         "Patient Town: " . $row["Town"] . "<br>" . 
         "Patient Street Number: " . $row["StreetNumber"] . "<br>" .
         "Patient Number: " . $row["Number"]  ."<br>" . 
         "Patient Postal Code: " . $row["PostalNumber"] . "<br>" . 
         "Patient Age:" . $row["Age"] . "<br>" .  	
         "Patient Doctor ID: " . $row["DoctorId"] . "<br><br>" ;
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