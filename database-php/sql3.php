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

if(isset($_POST['pharm_comp_id']))
{
    $searchID = $_POST['pharm_comp_id'];
}

$result = 0;

if(isset($searchID))
{
    $sql = "SELECT PhoneNumber
            FROM PharmaceuticalCompany
            WHERE PharmaceuticalCompanyId = '$searchID'  ";
$result = mysqli_query($conn, $sql);
}

if (mysqli_num_rows($result) > 0)
{
  //output data of each row
  while ($row = mysqli_fetch_assoc($result))
  {
  	echo "Phone Number: " . $row["PhoneNumber"] . "<br>";
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