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

@sum;
$sql ="CREATE 
       TRIGGER trigger1 AFTER INSERT ON Doctor
       FOR EACH ROW
       BEGIN
       SET @sum = @sum + NEW.ExperienceYears
       END ";

if (mysqli_query($conn, $sql))
{
  echo "Doctor Trigger created successfully<br><br>";
}
else
{
  echo "Error: " . $sql . "<br>" . mysqli_error($conn) ."<br><br>";
}    
/*
$sql = "SET @sum = 0";

if (mysqli_query($conn, $sql))
{
  echo "Sum set to zero successfully<br><br>";
}
else
{
  echo "Error: " . $sql . "<br>" . mysqli_error($conn) ."<br><br>";
}  

echo "@sum<br><br>";
*/

?>

</body>
</html>   