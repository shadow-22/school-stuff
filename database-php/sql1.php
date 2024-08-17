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

if(isset($_POST['patientid']))
{
    $searchID = $_POST['patientid'];
}

$result = 0;

if(isset($searchID))
{
    $sql = "SELECT PatientId, FirstName, LastName, Town, 
                   StreetNumber, PostalNumber, Number, Age,
                   DoctorId
            FROM Patient
            WHERE PatientId = '$searchID'  ";
$result = mysqli_query($conn, $sql);
}

if (mysqli_num_rows($result) > 0)
{
  //output data of each row
  while ($row = mysqli_fetch_assoc($result))
  {
    echo "Patient ID: " . $row["PatientId"] . "<br>" .
         "First Name: " . $row["FirstName"] . "<br>" .
         "Last Name: " . $row["LastName"] . "<br>" .
         "Town: " . $row["Town"] . "<br>" .
         "Street Number: " . $row["StreetNumber"] . "<br>" .
         "Postal Number: " . $row["PostalNumber"] . "<br>" .
         "Number: " . $row["Number"] . "<br>" .
         "Age: " . $row["Age"] . "<br>" .
         "Doctor ID: " . $row["DoctorId"] . "<br>" ;
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
