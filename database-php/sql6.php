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

$sql = "SELECT DoctorId,FirstName,LastName,Speciality,ExperienceYears
        FROM Doctor
        ORDER BY ExperienceYears desc" ;
$result =  mysqli_query($conn,$sql);

if (mysqli_num_rows($result) > 0)
{
	while ($row = mysqli_fetch_assoc($result))
	{
		echo "Doctor ID: " . $row['DoctorId'] . " -" .
		     "First Name: " . $row['FirstName'] . " -" .
		     "Last Name: " . $row['LastName'] . " -" .
		     "Speciality: " . $row['Speciality'] . " -" .
		     "Experience Years:" . $row['ExperienceYears'] . 
		     "<br> <br>" ;
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