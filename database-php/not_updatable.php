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

$sql = "CREATE VIEW /*Count_Patient doctorid_patient*/ Avg_patient AS 
         SELECT /*FirstName,LastName,COUNT(Age) DISTINCT AS count distinct DoctorId*/
                AVG(Age) as avg_age
         FROM Patient";

if (mysqli_query($conn, $sql))
{
echo "Not updateable Patient View created successfully<br><br>VIEW:<br><br>";
}
else
{
echo "Error: " . $sql . "<br>" . mysqli_error($conn) ."<br><br>VIEW:<br><br>";
}  

mysqli_close($conn);
?>

</body>
</html>     