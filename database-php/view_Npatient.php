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

$sql = "SELECT /*FirstName,LastName,count DoctorId*/ avg_age
        FROM /*Count_Patient doctorid_patient*/ Avg_patient";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0)
{
  //output data of each row
  while ($row = mysqli_fetch_assoc($result))
  {
  	echo /* "Patient First Name: " . $row["FirstName"] . "<br>" .
  	     "Patient Last Name: " . $row["LastName"] . "<br>" . *
  	     "Patient Count is:" . $row["count"] . "<br><br>"
  	     "DoctorId is : " . $row["DoctorId"] . "<br><br>"*/
  	      "Average Patient Age is : " . $row["avg_age"] . "<br><br>" ;
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